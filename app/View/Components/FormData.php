<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormData extends Component
{
    public $fields;
    public $users;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($fields, $users)
    {
        $this->fields = $fields;
        $this->users = $users;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form-data');
    }
}
