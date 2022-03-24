<?php

namespace App\Http\Controllers\Host;

use App\Models\Reservation;
use Livewire\Component;

class ReservationsPage extends Component
{
    public $reservations;

    public function render()
    {
        return view('pages.host.reservations')->layout('layouts.host-dashboard');
    }

    public function load()
    {
        $this->reservations = Reservation::all();
        // dd($this->reservations);

        $this->loadCalendar();
    }

    public function loadCalendar()
    {
        $data = [];

        foreach ($this->reservations as $reservation) {
            $data[] = [
                'checkin_date' => $reservation->checkin_date,
                'checkout_date' => $reservation->checkout_date,
                'property_name' => $reservation->property->name,
                'guest_name' => $reservation->user->name,
                'color' => $reservation->property->calendar_color,
            ];
        }

        $this->dispatchBrowserEvent('add-reservations-to-calendar', ['reservations' => $data]);
    }
}
