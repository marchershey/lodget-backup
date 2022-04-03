<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Currency;
use App\Models\Property;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Illuminate\Support\Str;
use Livewire\Component;
use Stripe\Exception\CardException;
use Throwable;

class CheckoutPage extends Component
{
    // Reservation data
    public $reservation_slug;
    public $reservation;

    // Property data
    public $property_id;
    public $property;
    public $photo;
    public $fees;

    // Reservation data
    public $checkin_date;
    public $checkout_date;
    public $nights = 4;

    // Pricing details
    public $pricing_base;
    public $pricing_fees;
    public $pricing_tax;
    public $pricing_total;

    // User & Payment details
    public $user;
    public $address;
    public $unit;
    public $city;
    public $state;
    public $zip;

    // Stripe data
    protected $stripe_customer;
    protected $stripe_intent;
    public $stripe_client_secret;

    protected $rules = [
        'address' => 'required|max:100',
        'unit' => 'nullable|max:10',
        'city' => 'required|max:100',
        'state' => 'required|max:2',
        'zip' => 'required|min:',
    ];

    public function render()
    {
        return view('pages.frontend.checkout')->layout('layouts.minimal');
    }
    public function mount($slug)
    {
        $this->reservation_slug = $slug;
    }

    public function load()
    {
        $this->reservation = Reservation::where('slug', $this->reservation_slug)->first();
        $this->property = $this->reservation->property;
        $this->photo = $this->property->photos()->first();
        $this->fees = $this->property->fees()->get();

        $this->checkin_date = Carbon::parse($this->reservation->checkin_date)->format('D, M jS');
        $this->checkout_date = Carbon::parse($this->reservation->checkout_date)->format('D, M jS');
        $this->nights = $this->reservation->nights;

        // Load User & Payment Details
        $this->user = auth()->user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
        $this->address = $this->user->address;
        $this->unit = $this->user->unit;
        $this->city = $this->user->city;
        $this->state = $this->user->state;
        $this->zip = $this->user->zip;

        // Stripe setup
        $this->setupStripe();

        // Calculate pricing data
        $this->calcPricing();

        // Mask the elements on the page (specifically the zip code)
        $this->dispatchBrowserEvent('maskAllElements');
    }

    public function setupStripe()
    {
        // Create Stripe Customer
        $this->stripe_customer = $this->user->createOrGetStripeCustomer([
            'metadata' => [
                'birthdate' => $this->user->birthdate,
            ]
        ]);

        // Create Setup intent
        $this->stripe_intent = $this->user->createSetupIntent([
            'customer' => $this->stripe_customer->id,
            'payment_method_types' => ['card'],
            // 'capture_method' => 'manual',
            // 'setup_future_usage' => 'off_session',
        ]);

        // Get client secret
        $this->stripe_client_secret = $this->stripe_intent->client_secret;

        // Mount the stripe card element
        $this->dispatchBrowserEvent('setupStripeCardElement');
    }

    public function calcPricing()
    {
        // Calculate base price
        $this->pricing_base = $this->property->rate * $this->nights;

        // Add base price to total
        $this->pricing_total = $this->pricing_base;

        // Calculate fees
        foreach ($this->fees as $fee) {
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

    /**
     * When a guest clicks "change" button to change reservation dates,
     * we need to delete this reservation, and redirect the guest back
     * to the property page to restart. 
     * 
     * This needs to be improved. Allow the guest to change on the checkout
     * page.
     */
    public function cancel()
    {
        $this->reservation->delete();

        return redirect('/property/' . $this->property->id);
    }

    /**
     * Just validates the data..
     */
    public function validateUserData()
    {
        $this->validate();
        return true;
    }

    public function finalize($setupIntent)
    {
        // Save user data
        $this->user->address = $this->address;
        $this->user->unit = $this->unit;
        $this->user->city = $this->city;
        $this->user->state = $this->state;
        $this->user->zip = $this->zip;
        $this->user->save();

        // Update User's Stripe data
        $this->user->updateStripeCustomer([
            'address' => [
                'city' => $this->city,
                'country' => 'US',
                'line1' => $this->address,
                'line2' => $this->unit,
                'postal_code' => $this->zip,
                'state' => $this->state,
            ]
        ]);

        // Update user's default payment method
        $this->user->updateDefaultPaymentMethod($setupIntent['payment_method']);

        // Create payment hold
        try {
            $payment = $this->user->charge(Currency::toPennies($this->pricing_total), $this->user->defaultPaymentMethod()->id, [
                'off_session' => true,
                'confirm' => true,

                'statement_descriptor' => Str::limit($this->property->name . ' ' . $this->property->address_city . ' ' . $this->property->address_state, 22, ''),
                'description' => 'This is a test',
                // 'statement_descriptor_suffix' => 'defg',
                'payment_method_options' => [
                    'card' => [
                        'capture_method' => 'manual',
                    ],
                ],
            ]);
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
            toast()->danger($e->getError()->message)->push();
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


        // Update Reservation's status
        $this->reservation->status = 'pending';
        $this->reservation->pricing_total = number_format($this->pricing_total, 2);
        $this->reservation->payment_id = $payment->id;
        $this->reservation->save();

        // Send Reservation Created Email to guest
        Mail::to($this->user->email)->queue(new \App\Mail\Guests\Reservations\ReservationCreatedEmail($this->reservation));


        return redirect('/success/' . $this->reservation->slug);
    }
}
