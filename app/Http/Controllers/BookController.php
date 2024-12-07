<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\CreateBookRequest;
use App\Models\Book;
use App\Services\BookService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class BookController extends Controller
{

    public function __construct( private BookService $bookService )
    {
    }

    /**
     * WEB ROUTE
     */
    public function index()
    {
        $tags = Book::where('user_id', Auth::user()->id)
            ->pluck('tags')
            ->map( fn( $item ) => json_decode($item, true) )
            ->flatten()
            ->countBy()
            ->sortByDesc( fn($count) => $count )
            ->slice(0,10)
            ->map( fn( $count, $tag) => [ 'tag' => $tag, 'count' => $count ])
            ->values();
        return view('bookshelf', ['tags' => $tags]);
    }

    /**
     * API Route
     */
    public function get()
    {
        $books = Book::where('user_id', Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->get();
        return response()->json($books);
    }

    /**
     * API ROUTE
     */
    public function store(CreateBookRequest $request)
    {
        // dd($request->validated());
        $formatted = $this->bookService->formatExternalBook( $request->validated() );
        $book = Book::create($formatted);
        $this->bookService->createCommunityPost($book, ['create_book' => true]);

        return response()->json($book);
    }

    /**
     * WEB ROUTE
     */
    public function search(Request $request)
    {
        $error = $request->all()['error'] ?? false;
        return view('search', [
            'errors' => (bool) $error
        ]);
    }

    /**
     * WEB ROUTE
     */
    public function searchResult(Request $request)
    {
        $query = $request->all()['query'];

        try {
            $response = Http::get("https://openlibrary.org/search.json?q=$query&lang=en&sort=rating desc");
            $books = $this->bookService->formatExternalBookSearchResults($response);
        } catch(Exception $e) {
            return Redirect::to('/search?error=true');
        }

        return view('search', [
            'result' => $books,
            'query' => $query,
            'errors' => false
        ]);
    }

    /**
     * WEB ROUTE
     */
    public function show($key)
    {
        $response = Http::get("https://openlibrary.org/works/$key.json");
        $book = $response->json();
        $authors = $this->bookService->getAuthors($book);

        return view('book', [
            'book' => $book,
            'authors' => $authors
        ]);
    }

    /**
     * API ROUTE
     */
    public function update(Request $request, string $id)
    {
        $updates = $request->all();
        $book = $this->bookService->applyUpdates($updates, $id);
        $this->bookService->createCommunityPost($book, $updates);

        return response()->json($book);
    }

    /**
     * API ROUTE
     */
    public function destroy(string $id)
    {
        $delete = Book::where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->delete();
        return response()->json($delete);
    }
}
