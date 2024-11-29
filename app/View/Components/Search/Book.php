<?php

namespace App\View\Components\Search;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Book extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $book,
        public bool $hasBook
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.search.book');
    }
}
