<?php

namespace App\View\Components\search;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class addBookButtonWithModal extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct( public array $book )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.search.add-book-button-with-modal');
    }
}
