<?php

namespace App\Http\Controllers;

use App\Dto\ExternalApiBookDto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class SearchController extends Controller
{
    public function __construct( )
    { }

    public function search(Request $request)
    {
        $error = $request->all()['error'] ?? false;
        return view('search', [
            'errors' => (bool) $error
        ]);
    }

    public function result(Request $request)
    {
        $query = $request->all()['query'];


        try {
            $response = Http::get("https://openlibrary.org/search.json?q=$query&lang=en")->json();
            $books = array_map( fn($book) => new ExternalApiBookDto($book), $response['docs']);
        } catch(Exception $e) {
            return Redirect::to('/search?error=true');
        }

        return view('search', [
            'result' => $books,
            'query' => $query,
            'errors' => false
        ]);
    }
}
