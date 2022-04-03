<?php

namespace App\Mail\Guests\Reservations;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationCreatedEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $reservation;
    public $user;
    public $property;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
        $this->user = $reservation->user;
        $this->property = $reservation->property;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.reservations.created')->subject($this->property->name . ' Reservation');
    }
}
