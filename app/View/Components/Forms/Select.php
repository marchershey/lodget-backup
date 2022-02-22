<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Select extends Component
{
    public $inputId;
    public $label;
    public $placeholder;
    public $description;
    public $options;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($options, $inputId = null, $label = null, $placeholder = null, $description = null)
    {
        $this->inputId = $inputId ?? 'text-' . rand();
        $this->label = $label;
        $this->placeholder = $placeholder ?? $label;
        $this->description = $description;
        $this->options = $options;
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
