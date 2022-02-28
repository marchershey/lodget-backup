<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Textarea extends Component
{
    public $wireId;
    public $wireTarget;
    public $inputClass;
    public $label;
    public $placeholder;
    public $description;
    public $rows;
    public $cols;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($wireId = null, $wireTarget = null, $inputClass = null, $label = null, $placeholder = null, $description = null, $rows = 4, $cols = 4)
    {
        $this->wireId = $wireId ?? false;
        $this->wireTarget = $wireTarget . ", submit";
        $this->inputClass = $inputClass;
        $this->label = $label;
        $this->placeholder = $placeholder ?? $label;
        $this->description = $description;
        $this->rows = $rows;
        $this->cols = $cols;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.textarea');
    }
}
