<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Services\BookService;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index( ?string $username = null )
    {
        $username ??= Auth::user()->username;

        $user = User::select('id', 'username', 'created_at')
            ->where('username', $username)
            ->first();

        $books = Book::select('key', 'title', 'cover_url', 'authors', 'tags')
            ->where('user_id', $user->id)
            ->get()
            ->shuffle();

        $authors = BookService::getUserAuthors( $books );
        $tags = BookService::getUserTags( $user->id );

        return view('user', [
            'user' => $user,
            'books' => $books,
            'authors' => $authors,
            'tags' => $tags
        ]);
    }
}
