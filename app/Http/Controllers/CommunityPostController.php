<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CommunityPost;
use Exception;
use Illuminate\Support\Facades\Auth;

class CommunityPostController extends Controller
{
    public function index()
    {
        $communityPosts = CommunityPost::all()->sortByDesc('created_at');
        return view('community', [
            'community_posts' => $communityPosts
        ]);
    }

    public function store(?Book $book, string $type)
    {
        $valid_types = ['CREATE_BOOK', 'FAVOURITE_BOOK', 'READ_BOOK', 'JOIN'];
        if( !in_array($type, $valid_types) ) {
            throw new Exception('Invalid CommunityPost Type');
        }

        $communityPost = CommunityPost::create([
            'user_id' => Auth::user()->id,
            'username' => Auth::user()->username,
            'cover_url' => $book['cover_url'] ?? null,
            'title' => $book['title'] ?? '',
            'key' => $book['key'] ?? '',
            'type' => $type,
        ]);

        return response()->json($communityPost);
    }
}
