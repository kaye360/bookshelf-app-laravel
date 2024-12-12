<?php

namespace App\Http\Controllers;

use App\Dto\CreateBookDto;
use App\Dto\ExternalApiBookDto;
use App\Http\Requests\Book\CreateBookRequest;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{

    public function __construct( private BookService $bookService )
    { }

    /**
     * WEB ROUTE
     */
    public function index()
    {
        $tags = $this->bookService->getUserTags();
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
        $bookDto = new CreateBookDto( $request->validated() );
        $book = Book::create( $bookDto->toArray() );
        $this->bookService->createCommunityPost($book, ['create_book' => true]);

        return response()->json($book);
    }

    /**
     * WEB ROUTE
     */
    public function show($key, )
    {
        $response = Http::get("https://openlibrary.org/works/$key.json");
        $json = $response->json();

        if( isset( $json['error'] ) ) {
            return view('bookNotFound');
        }

        $book = new ExternalApiBookDto($json);

        return view('book', [ 'book' => $book ]);
    }

    /**
     * API ROUTE
     */
    public function update(Request $request, string $id)
    {
        $updates = $request->all();
        $book = $this->bookService->updateBook($updates, $id);
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
