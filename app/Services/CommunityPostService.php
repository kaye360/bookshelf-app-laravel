<?php
namespace App\Services;

use App\Models\CommunityPost;
use Illuminate\Database\Eloquent\Collection;

class CommunityPostService {

    public static function getPostTitle( $post ) {
        $isSingle = count($post) === 1;
        $titles = [
            'CREATE_BOOK' => $isSingle ? 'added a book' : "added " . count($post) . ' books',
            'FAVOURITE_BOOK' => $isSingle ? 'favourited a book' : "favourited " . count($post) . ' books',
            'READ_BOOK' => $isSingle ? 'read a book' : "read " . count($post) . ' books',
            'JOIN' => 'joined HootReads!',
        ];
        return $titles[$post[0]['type']];
    }

    public static function getPosts($page)
    {
        $cp = [];

        CommunityPost::orderBy('updated_at', 'desc')->chunk(100, function(Collection $posts) use (&$cp) {
            $cp[] = $posts->groupBy(['username','type'])
                ->map( fn($group) => $group->values()->toArray() )
                ->collapse()
                ->map( function($books) {
                    return [
                        'books' => $books,
                        'bookCount' => count($books),
                        'title' => ' ' . self::getPostTitle($books),
                        'type' => $books[0]['type'],
                        'username' => $books[0]['username'],
                        'icon' => match( $books[0]['type'] ) {
                            'CREATE_BOOK' => 'book-plus',
                            'FAVOURITE_BOOK' => 'heart',
                            'READ_BOOK' => 'circle-check-big',
                            'JOIN' => 'user',
                        }
                    ];
                })
                ->shuffle()
                ->toArray();
        });

        return $cp[$page] ?? false;
    }

}
