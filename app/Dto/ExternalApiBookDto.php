<?php
namespace App\Dto;

use App\Models\Book;
use App\Services\BookService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class ExternalApiBookDto {

    /**
     * Title of the book from external api
     */
    public readonly string $title;

    /**
     * External Api OLID key
     */
    public readonly string $key;

    /**
     * Does the logged in user have this book?
     */
    public readonly bool $hasBook;

    /**
     * List of authors, with name, photo url, and OLID key
     * { name: string, key: string, photo: string|null }[]
     */
    public readonly array $authors;

    /**
     * List of users who also have this book
     * Returns only username column
     */
    public readonly Collection $readers;

    /**
     * Total amount of users with this book
     */
    public readonly int $readerCount;

    /**
     * Publish date of book from external api
     */
    public readonly ?string $publishDate;

    /**
     * Description of book from external api
     */
    public readonly string|array|null $description;

    /**
     * List of users formatted, unique tags for book
     * string[]
     */
    public array $tags;

    /**
     * List of cover urls as strings
     * string[]
     */
    public array $covers;

    /**
     * Number of pages in book from external api
     */
    public ?int $pageCount;


    public function __construct( array $book )
    {
        $this->title       = $book['title'];
        $this->key         = BookService::getKey( $book['key'] );
        $this->hasBook     = (bool) BookService::hasBook( $this->key );
        $this->authors     = $this->getAuthors($book);
        $this->readers     = $this->getReadersByKey($this->key);
        $this->readerCount = count($this->readers);
        $this->description = $this->getDescription( $book['description'] ?? null );
        $this->publishDate = $book['first_publish_date'] ?? null;
        $this->tags        = BookService::formatTags( $book['subjects'] ?? $book['subject'] ?? [] );
        $this->randomTags  = $this->getRandomTags( $this->tags );
        $this->covers      = $this->getCovers( $book['covers'] ?? $book['cover_edition_key'] ?? null );
        $this->pageCount   = $book['number_of_pages_median'] ?? null;
    }

    /**
     *
     * Gets up to 5 random tags
     *
     */
    private function getRandomTags( array $tags ) : array
    {
        return  count($tags) >= 5
            ? Arr::random( $tags, 5 )
            : Arr::random( $tags, count($tags) );
    }

    /**
     *
     * Returns a string description
     *
     */
    private function getDescription( string|array|null $description ) : ?string
    {
        if( !$description ) return null;
        return is_array( $description )
            ? implode(' ', $description )
            : (string) $description;
    }

    /**
     *
     * Returns a list of cover urls from external book api
     *
     */
    private function getCovers( string | array | null $apiCovers ) : array
    {
        if( is_string($apiCovers) ) {
            return ["https://covers.openlibrary.org/b/olid/$apiCovers-L.jpg"];
        }

        if( is_array( $apiCovers ) ) {
            return array_map( fn( $cover ) => "https://covers.openlibrary.org/b/id/$cover-L.jpg", $apiCovers );
        }

        return [];
    }

    /**
     *
     * Get list of local readers of a external api book
     *
     */
    private function getReadersByKey(string $key) : Collection
    {
        $readers = Book::where('key', $key)
            ->join('users', 'books.user_id', '=', 'users.id')
            ->select('username')
            ->get();

        $readers->each( fn($reader) => $reader->initial = substr($reader->username, 0, 1) );

        return $readers;
    }

    /**
     *
     * Get author data from the external API book
     *
     */
    private function getAuthors(array $book) : array
    {
        $authors = [];

        // Case: Get author from Search Results
        // Author_name and author_key are corresponding array of strings
        if( isset( $book['author_name'] ) && $book['author_key'] ) {
            $authors = $this->getAuthorsFromSearch($book);
        }

        // Case: Get individual book
        // Authors is an olid key and needs to fetch more data
        if( isset( $book['authors'] )) {
            $authors = $this->getAuthorsFromBook($book);
        }

        $authors = $this->removeDuplicateAuthors( $authors );
        $authors = array_slice($authors, 0, 5);

        return $authors;
    }

    /**
     *
     * Get list of authors from external api book search
     *
     */
    private function getAuthorsFromSearch( array $book ) : array
    {
        return array_map(
            fn( $name, $key ) => (object) [
                'name' => $name ?? '',
                'photo' => null,
                'key' => $key
            ],
            $book['author_name'], $book['author_key']
        );
    }

    /**
     *
     * Get list of authors from single book
     *
     */
    private function getAuthorsFromBook( array $book ) : array
    {
        $authors = [];

        foreach( $book['authors'] as $author ) {
            $url = "https://openlibrary.org" . $author['author']['key'] . '.json';
            $response = Http::get($url);
            $json = $response->json();
            $authors[] = (object) [
                'name' => $json['name'] ?? '',
                'key' => str_replace('/authors/', '', $json['key']),
                'photo' => isset( $json['photos'][0] )
                    ? "https://covers.openlibrary.org/a/id/" . $json['photos'][0] . "-M.jpg"
                    : null,
            ];
        }

        return $authors;
    }

    /**
     *
     * Remove authors with duplicate names
     *
     */
    private function removeDuplicateAuthors( array $authors ) : array
    {
        return collect($authors)
            ->unique( fn($author) => $author->name )
            ->toArray();
    }
}

