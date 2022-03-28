<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Reservation;
use Livewire\Component;

class Success extends Component
{
    public $reservation;

    public function render()
    {
        return view('pages.frontend.success');
    }

    public function mount($slug)
    {
        $this->reservation = Reservation::where('slug', $slug)->firstOrFail();

        // dd($slug);
    }
}
