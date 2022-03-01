<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Number extends Component
{
    public $wireId;
    public $wireTarget;
    public $step;
    public $min;
    public $max;
    public $label;
    public $description;
    public $placeholder;
    public $inputClass;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($wireId, $wireTarget = null, $step = null, $min = null, $max = null, $label = null, $description = null, $placeholder = null, $inputClass = null)
    {
        $this->wireId = $wireId;
        $this->wireTarget = "submit, " . $wireTarget;
        $this->step = $step ?? 1;
        $this->min = $min ?? 0;
        $this->max = $max ?? 50;
        $this->label = $label;
        $this->description = $description;
        $this->placeholder = $placeholder;
        $this->inputClass = $inputClass;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.number');
    }
}
