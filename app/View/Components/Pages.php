<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Pages extends Component
{
    public $pages;
    public $subdomain;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($pages, $subdomain)
    {
        $this->pages = $pages;
        $this->subdomain = $subdomain;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.pages');
    }
}
