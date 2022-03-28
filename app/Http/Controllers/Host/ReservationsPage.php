<?php

namespace App\Http\Controllers\Host;

use App\Models\Property;
use App\Models\Reservation;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class ReservationsPage extends Component
{
    use WireToast;

    public $properties;
    public $reservations;

    public function render()
    {
        return view('pages.host.reservations')->layout('layouts.host-dashboard');
    }

    public function load()
    {
        $this->reservations = Reservation::where('status', '!=', null)->get()->sortByDesc('checkin_date');
        $this->properties = Property::all();

        $this->loadCalendarData();
    }

    public function loadCalendarData()
    {
        // Add reservations as events to calendar
        $reservations = [];
        foreach ($this->reservations as $reservation) {

            // add PENDING to title if reservation is pending
            $title = ($reservation->status == 'pending') ? '*** ' . $reservation->property->name . ': ' . $reservation->user->name : $reservation->property->name . ': ' . $reservation->user->name;

            $reservations[] = [
                'status' => $reservation->status,
                'title' => $title,
                'start' => $reservation->checkin_date,
                'end' => $reservation->checkout_date,
                'color' => $reservation->property->calendar_color,
                'url' => '/host/reservation/' . $reservation->id,
            ];
        }
        $this->dispatchBrowserEvent('add-reservations-to-calendar', ['reservations' => $reservations]);
    }

    public function approveReservation(Reservation $reservation)
    {
        toast()->success($reservation->user->name . ' has been approved to stay at ' . $reservation->property->name)->push();
    }
}
