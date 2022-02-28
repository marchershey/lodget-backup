<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Select extends Component
{
    public $options;
    public $wireId;
    public $wireTarget;
    public $inputClass;
    public $label;
    public $placeholder;
    public $description;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($options, $wireId = null, $wireTarget = null, $inputClass = null, $label = null, $placeholder = null, $description = null)
    {
        $this->options = $options;
        $this->wireId = $wireId ?? false;
        $this->wireTarget = $wireTarget . ", submit";
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
        return view('components.forms.select');
    }
}
