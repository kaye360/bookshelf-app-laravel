<?php
namespace App\Dto;

use App\Models\Book;
use App\Services\BookService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class ExternalApiBookDto {

    public readonly string $title;
    public readonly string $key;
    public readonly bool $hasBook;
    public readonly array $authors;
    public readonly Collection $readers;
    public readonly int $readerCount;
    public readonly ?string $publishDate;
    public readonly string|array|null $description;
    public array $tags;
    public array $covers;
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
    private function getRandomTags( array $tags )
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
        // Case: Authors is an array of strings
        if( isset( $book['author_name'] ) ) {
            return array_map(
                fn( $author ) => (object) [
                    'name' => $author ?? '',
                    'photo' => null,
                    'key' => null
                ],
                $book['author_name']
            );
        }

        // Case: Authors is a key and needs to be fetched
        if( isset( $book['authors'] )) {
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

        return [];
    }
}
