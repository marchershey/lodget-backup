<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Currency;
use App\Models\Property;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class CheckoutPage extends Component
{
    // Page states
    public $success = false;
    public $loading = false;

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

        // Setup Payment intent
        $this->stripe_intent = $this->user->createSetupIntent([
            'customer' => $this->stripe_customer->id,
            'payment_method_types' => ['card'],
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

    public function submit()
    {
        $this->validate();

        // Save user data
        $this->user->address = $this->address;
        $this->user->unit = $this->unit;
        $this->user->city = $this->city;
        $this->user->state = $this->state;
        $this->user->zip = $this->zip;
        $this->user->save();

        // Update Stripe data
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

        $this->dispatchBrowserEvent('submitStripe');
    }

    public function finalize($setupIntent)
    {
        // Update user's default payment method
        $this->user->updateDefaultPaymentMethod($setupIntent['payment_method']);

        return redirect('/success/' . $this->reservation->slug);

        // dd($this->user->charge(Currency::toPennies($this->pricing_total), $this->user->defaultPaymentMethod()->id, [
        //     'off_session' => true,
        //     'confirm' => true,
        //     'capture_method' => 'manual',
        // ]));
    }
}
