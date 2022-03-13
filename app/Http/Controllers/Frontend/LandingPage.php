<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Property;
use Livewire\Component;

class LandingPage extends Component
{
    public $properties;

    public function render()
    {
        return view('pages.frontend.landing');
    }

    public function loadProperties()
    {
        $this->properties = Property::where('active', true)->take(3)->get();
    }
}
