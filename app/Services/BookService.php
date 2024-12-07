<?php
namespace App\Services;

use App\Http\Controllers\CommunityPostController;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class BookService {

    public function __construct(
        private CommunityPostController $communityPost
    )
    {

    }

    /**
     *
     * Transforms a book fetched from the external API into a Book
     * @param validated Validated Request
     *
     */
    public function formatExternalBook(mixed $validated)
    {
        // External API book Key
        $validated['key'] = str_replace('/works/', '', $validated['key']);

        // Tags
        $tags = array_filter( $validated, fn($key) => str_contains($key, 'tag'), ARRAY_FILTER_USE_KEY);
        $tags = array_values( $tags );
        $validated['tags'] = json_encode( $this->formatExternalBookTags( $tags ) );

        // Delete old tag keys. (tag0, tag1 etc.)
        $validated = array_filter( $validated, fn($key) =>
            $key === 'tags' || !str_contains($key, 'tag'),
            ARRAY_FILTER_USE_KEY
        );

        // dd($validated);

        // User ID
        $validated['user_id'] = Auth::user()->id;

        // Is read/owned/fav
        $validated['is_read'] = isset($validated['is_read']) && $validated['is_read'] === 'on';
        $validated['is_owned'] = isset($validated['is_owned']) && $validated['is_owned'] === 'on';
        $validated['is_favourite'] = false;

        // Page Count
        $validated['page_count'] = $validated['page_count'] ?? 0;

        // CoverUrl
        $validated['cover_url'] ??= null;

        return $validated;
    }

    /**
     *
     * Transforms tags from an external API book to an array of strings.
     * Removes invalid characters
     * @param external_tags array of strings
     *
     */
    public function formatExternalBookTags(array $external_tags)
    {
        $tags_max = array_slice($external_tags, 0, 5);
        foreach( $tags_max as &$tag) {
            $tag = str_replace(' ', '-', $tag);
            $tag = str_replace('(', '', $tag);
            $tag = str_replace(')', '', $tag);
            $tag = str_replace('/', '', $tag);
            $tag = str_replace('--', '-', $tag);
            $tag = strtolower($tag);
        }
        unset($tag);
        return $tags_max;
    }

    /**
     *
     * Extracts the array of books from the API and as the 'hasBook' property
     * to each book item
     * @param response = API response
     *
     */
    public function formatExternalBookSearchResults(object $response)
    {
        $books = $response->json();

        foreach( $books['docs'] as &$book ) {
            $book['hasBook'] = BookService::hasBook($book['key']);
        }

        return $books['docs'];
    }

    /**
     *
     * Determines whether the logged in user has this book already
     * @param key The api reference key of the book. /works/ is automatically stripped out.
     *
     */
    public static function hasBook(string $key)
    {
        $key = str_replace('/works/', '', $key );
        return Book::where('key', $key)
                   ->where('user_id', Auth::user()->id)
                   ->exists();
    }

    /**
     *
     * Get author data from the external API book
     * @param book A single book from the external API
     *
     */
    public function getAuthors(mixed $book)
    {
        $authors = [];

        foreach( $book['authors'] as $author ) {
            $url = "https://openlibrary.org" . $author['author']['key'] . '.json';
            $response = Http::get($url);
            $authors[] = $response->json();
        }

        return $authors;
    }

    /**
     *
     * Apply updates to A Book in books table
     * @param updates array of key value pairs corresponding to column and new value
     * @param id Id of the book to update
     *
     */
    public function applyUpdates(array $updates, int $id)
    {
        $book = Book::where('id', $id)->first();

        foreach( $updates as $key => $value) {
            $book[$key] = $value;
        }

        $book->save();
        return $book;
    }

    /**
     *
     * Creates a new community post related to a book event.
     * @param book - Single Book
     * @param updates - Array of key/value pair corresponding to book actions and new value.
     * Book actions can be:
     * - is_favourite (bool)
     * - is_read (bool)
     * - create_book (true)
     *
     */
    public function createCommunityPost(Book $book, array $updates)
    {
        $type = match( true ) {
            array_key_exists('is_favourite', $updates) && $book['is_favourite'] === true => 'FAVOURITE_BOOK',
            array_key_exists('is_read', $updates)      && $book['is_read'] === true =>      'READ_BOOK',
            array_key_exists('create_book', $updates) && $updates['create_book'] === true => 'CREATE_BOOK',
            default => null
        };

        if( $type !== null ) {
            $this->communityPost->store($book, $type);
        }
    }
}
