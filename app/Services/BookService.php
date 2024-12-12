<?php
namespace App\Services;

use App\Http\Controllers\CommunityPostController;
use App\Models\Book;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class BookService {

    public function __construct( private CommunityPostController $communityPost )
    { }

    /**
     *
     * Determines whether the logged in user has this book already
     * @param key The api reference key of the book. /works/ is automatically stripped out.
     *
     */
    public static function hasBook(string $key)
    {
        $key = self::getKey($key);
        return Book::where('key', $key)
            ->where('user_id', Auth::user()->id)
            ->exists();
    }

    /**
     *
     * Extract a olid key from a string. Strips out /works/
     *
     */
    public static function getKey( $key )
    {
        return str_replace('/works/', '', $key );
    }

    /**
     *
     * @param apiTags array of strings from api
     * @return array list of tags as strings
     *
     */
    public static function formatTags( array $apiTags ) : array
    {
        if( !is_array($apiTags) ) return [];

        $tags = array_map( fn( $tag ) => explode(',', $tag), $apiTags);
        $tags = Arr::flatten($tags);
        $tags = array_map( function( $tag ) {
            $tag = trim($tag);
            $tag = str_replace(' ', '-', $tag);
            $tag = strtolower($tag);
            $tag = preg_replace('/[^0-9a-z-]+/', '', $tag); // Only allowed characters
            $tag = preg_replace('/-+/', '-', $tag); // remove instances of ----
            return $tag;
        }, $tags );
        $tags = array_unique($tags);
        return $tags;
    }

    /**
     *
     * Get list of local readers of a external api book
     *
     */
    public function getReadersByKey(string $key) {

        $readers = Book::where('key', $key)
            ->join('users', 'books.user_id', '=', 'users.id')
            ->select('username')
            ->get();

        $readers->each( fn($reader) => $reader->initial = substr($reader->username, 0, 1) );

        return $readers;
    }

    /**
     *
     * Apply updates to A Book in books table
     * @param updates array of key value pairs corresponding to column and new value
     * @param id Id of the book to update
     *
     */
    public function updateBook(array $updates, int $id)
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

    /**
     *
     * Gets a list of authorized user tags with counts of each tag
     * Sorted by highest count to lowest
     *
     */
    public function getUserTags()
    {
        return Book::where('user_id', Auth::user()->id)
            ->pluck('tags')
            ->map( fn( $item ) => json_decode($item, true) )
            ->flatten()
            ->countBy()
            ->sortByDesc( fn($count) => $count )
            ->slice(0,10)
            ->map( fn( $count, $tag) => [ 'tag' => $tag, 'count' => $count ])
            ->values();
    }
}
