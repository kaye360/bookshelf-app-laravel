<?php

namespace App\View\Components\Book;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class cover extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $src = null,
        public string $size = 'lg',
        public string $title,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.book.cover');
    }
}
