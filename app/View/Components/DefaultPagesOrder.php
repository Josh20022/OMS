<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DefaultPagesOrder extends Component
{
    public $pages;
    public $user;
    public $category;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($pages, $user, $category)
    {
        $this->pages = $pages;
        $this->user = $user;
        $this->category = $category;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default-pages-order');
    }
}
