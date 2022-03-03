<?php

namespace App\Http\Controllers\Host\Properties;

use App\Models\Property;
use Livewire\Component;

class PropertyIndex extends Component
{
    public $properties = [];

    public function render()
    {
        return view('pages.host.properties.index')->layout('layouts.host-dashboard');
    }

    public function load()
    {
        $this->properties = Property::all();
        # code...
    }
}
