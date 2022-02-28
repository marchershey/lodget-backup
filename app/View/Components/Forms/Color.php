<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Color extends Component
{
    public $wireId;
    public $wireTarget;
    public $inputClass;
    public $label;
    public $description;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($wireId = null, $wireTarget = "submit", $inputClass = null, $label = null, $description = null)
    {
        $this->wireId = $wireId ?? false;
        $this->wireTarget = $wireTarget;
        $this->inputClass = $inputClass;
        $this->label = $label;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.color');
    }
}
