<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Forms extends Component
{
    public $forms;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($forms)
    {
        $this->forms = $forms;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms');
    }
}
