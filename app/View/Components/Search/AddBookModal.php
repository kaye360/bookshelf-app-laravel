<?php

namespace App\View\Components\Search;

use App\Services\BookService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddBookModal extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $book,
        public BookService $bookService,
    )
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.search.add-book-modal');
    }
}
