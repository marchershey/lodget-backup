<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Text extends Component
{
    public $wireId;
    public $wireTarget;
    public $inputType;
    public $inputClass;
    public $label;
    public $placeholder;
    public $description;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($wireId = null, $wireTarget = null, $inputType = "text", $inputClass = null, $label = null, $placeholder = null, $description = null)
    {
        $this->wireId = $wireId ?? false;
        $this->wireTarget = $wireTarget . ", submit";
        $this->inputType = $inputType;
        $this->inputClass = $inputClass;
        $this->label = $label;
        $this->placeholder = $placeholder ?? $label;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.text');
    }
}
