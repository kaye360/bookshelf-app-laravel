<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function index()
    {
        return Auth::check() ? redirect('/books') : view('index');
    }

    public function about()
    {
        dd('About Page');
    }
}
