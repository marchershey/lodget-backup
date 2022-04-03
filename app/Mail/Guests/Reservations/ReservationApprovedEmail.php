<?php

namespace App\Mail\Guests\Reservations;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationApprovedEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $reservation;
    public $property;
    public $user;

    // Pricing details
    public $pricing_base;
    public $pricing_fees;
    public $pricing_tax;
    public $pricing_total;

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
        $this->calcPricing();

        return $this->view('mail.reservations.approved')->subject($this->property->name . ' Reservation Approved!');
    }

    public function calcPricing()
    {
        // Calculate base price
        $this->pricing_base = $this->property->rate * $this->reservation->nights;

        // Add base price to total
        $this->pricing_total = $this->pricing_base;

        // Calculate fees
        foreach ($this->property->fees()->get() as $fee) {
            if ($fee['type'] == "fixed") {
                // $fee is a fixed type
                $name = (string) $fee['name'];
                $amount = (int) $fee['amount'];
            } elseif ($fee['type'] == "percentage") {
                // $fee is a 'percentage' type
                $name = (string) $fee['name'];
                $amount = (float) ($fee['amount'] * 0.01) * $this->pricing_base;
                // $amount on a percentage type is calculated 
            }

            // Add fee to an array with calculated total
            // This helps display the correct amount on percentage types
            $this->pricing_fees[] = [
                'name' => $name,
                'amount' => $amount,
            ];

            // Add fee to total
            $this->pricing_total = $this->pricing_total + $amount;
        }

        // Calculate taxes
        if ($this->property->tax_rate) {
            // convert tax_rate to a percentage
            $tax_percentage = $this->property->tax_rate * 0.01;

            // calculate price of taxes on total
            $this->pricing_tax = $this->pricing_total * $tax_percentage;

            // add tax to total
            $this->pricing_total = $this->pricing_total + $this->pricing_tax;
        }
    }
}
