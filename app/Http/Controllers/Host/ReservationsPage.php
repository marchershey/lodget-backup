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

    public $listeners = [
        'refresh' => '$refresh'
    ];

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
        foreach ($this->reservations->where('status', '!=', null)->where('status', '!=', 'cancelled')->where('status', '!=', 'rejected') as $reservation) {

            // add PENDING to title if reservation is pending
            $title = '[ ' . strtoupper($reservation->status) . ' ] ' . $reservation->property->name . ': ' . $reservation->user->name;

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

    public function approvePendingReservation(Reservation $reservation)
    {
        // charge the guest
        try {
            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
            );

            $stripe->paymentIntents->capture($reservation->payment->payment_intent);

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

        // Update the reservation status
        $reservation->status = 'active';
        $reservation->save();

        // send guest email
        Mail::to($reservation->user->email)->send(new \App\Mail\Guests\Reservations\ReservationApprovedEmail($reservation));

        $this->emitSelf('refresh');

        // udpate status
        toast()->success($reservation->user->name . ' has been successfully charged and approved.')->push();
    }

    public function rejectPendingReservation(Reservation $reservation)
    {
        // cancel payment
        try {
            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
            );

            $stripe->paymentIntents->cancel($reservation->payment->payment_intent);

            toast()->success('Reservation has been successfully rejected.')->push();
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
            // toast()->danger('Type: ' . $e->getError()->type)->push();
            // toast()->danger('Code: ' . $e->getError()->code)->push();
            // toast()->danger('Param: ' . $e->getError()->param)->push();
            // toast()->danger('Message: ' . $e->getError()->message)->push();
            toast()->danger($e->getError()->message . '(' . $e->getError()->code . ')')->push();
        } catch (\Stripe\Exception\RateLimitException $e) {
            // Too many requests made to the API too quickly
            toast()->danger($e->getError()->message)->push();
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
            toast()->danger($e->getError()->message)->push();
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            toast()->danger($e->getError()->message)->push();
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed
            toast()->danger($e->getError()->message)->push();
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            toast()->danger($e->getError()->message)->push();
        } catch (\Exception $e) {
            // Something else happened, completely unrelated to Stripe
            toast()->danger($e->getMessage())->push();
        }

        $reservation->status = 'rejected';
        $reservation->save();

        Mail::to($reservation->user->email)->send(new \App\Mail\Guests\Reservations\ReservationRejected($reservation));

        toast()->success('Reservation has been rejected')->push();

        $this->emitSelf('refresh');
    }




    // DELETE THIS!
    public function resetReservation(Reservation $reservation)
    {
        $reservation->status = 'pending';
        $reservation->save();
        $this->emitSelf('refresh');
    }
}
