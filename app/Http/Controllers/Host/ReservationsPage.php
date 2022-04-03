<?php

namespace App\Http\Controllers\Host;

use App\Helpers\Currency;
use App\Mail\ReservationCreatedEmail;
use App\Models\Property;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class ReservationsPage extends Component
{
    use WireToast;

    // Reservations
    public $reservations;

    // Properties
    public $properties;

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
                'end' => \Carbon\Carbon::parse($reservation->checkout_date)->addDay()->format('Y-m-d'), // add extra day
                'color' => $reservation->property->calendar_color,
                'url' => '/host/reservation/' . $reservation->id,
            ];
        }
        $this->dispatchBrowserEvent('add-reservations-to-calendar', ['reservations' => $reservations]);
    }

    public function approveReservation(Reservation $reservation)
    {
        // charge the guest
        try {
            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
            );

            $stripe->paymentIntents->capture($reservation->payment_id);

            toast()->success('good')->push();
        } catch (\Laravel\Cashier\Exceptions\IncompletePayment $e) {
            if ($e->payment->requiresPaymentMethod()) {
                // ...
                toast()->danger('User doesn\'t have payment method...')->push();
                return;
            } elseif ($e->payment->requiresConfirmation()) {
                // ...
                toast()->danger('Requires Authentication')->push();
                return;
            }
        } catch (\Stripe\Exception\CardException $e) {
            // Since it's a decline, \Stripe\Exception\CardException will be caught
            toast()->danger('Type: ' . $e->getError()->type)->push();
            toast()->danger('Code: ' . $e->getError()->code)->push();
            toast()->danger('Param: ' . $e->getError()->param)->push();
            toast()->danger('Message: ' . $e->getError()->message)->push();
            return;
        } catch (\Stripe\Exception\RateLimitException $e) {
            // Too many requests made to the API too quickly
            toast()->danger($e->getError()->message)->push();
            return;
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
            toast()->danger($e->getError()->message)->push();
            return;
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            toast()->danger($e->getError()->message)->push();
            return;
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed
            toast()->danger($e->getError()->message)->push();
            return;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            toast()->danger($e->getError()->message)->push();
            return;
        } catch (\Exception $e) {
            // Something else happened, completely unrelated to Stripe
            toast()->danger($e->getMessage())->push();
            return;
        }

        // send guest email
        Mail::to($reservation->user->email)->send(new \App\Mail\Guests\Reservations\ReservationApprovedEmail($reservation));

        // udpate status
        toast()->success($reservation->user->name . ' has been approved to stay at ' . $reservation->property->name)->push();
    }
}
