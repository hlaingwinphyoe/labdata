<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SideBarLink extends Component
{
    public $link,$class,$name;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($link="#",$class="fa-hospital",$name="SideTitle")
    {
        $this->link = $link;
        $this->class = $class;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.side-bar-link');
    }
}
