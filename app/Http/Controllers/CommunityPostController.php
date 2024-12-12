<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CommunityPost;
use App\Services\CommunityPostService;
use Exception;
use Illuminate\Support\Facades\Auth;

class CommunityPostController extends Controller
{

    public function __construct(private CommunityPostService $communityPostService)
    {
    }

    public function index()
    {
        return view('community');
    }

    public function get(string $page)
    {
        $communityPosts = CommunityPostService::getPosts($page);
        return response()->json($communityPosts);
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
