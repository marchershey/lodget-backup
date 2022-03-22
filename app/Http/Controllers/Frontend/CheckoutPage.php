<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Currency;
use App\Models\Property;
use App\Models\Reservation;
use App\Models\User;
use Livewire\Component;

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
    public $pricing_total;

    // Payment details
    public $name;
    public $email;
    public $phone;
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

        // $this->property = Property::find($this->property_id);
        // $this->photo = $this->property->photo()->first();
        // $this->fees = $this->property->fees()->get();

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
        $this->stripe_customer = auth()->user()->createOrGetStripeCustomer([
            'metadata' => [
                'birthdate' => auth()->user()->birthdate,
            ]
        ]);

        // Setup Payment intent
        $this->stripe_intent = auth()->user()->createSetupIntent([
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
        if ($this->fees) {
            foreach ($this->fees as $fee) {
                if ($fee['type'] == "fixed") {
                    // $fee is a fixed type
                    $name = (string) $fee['name'];
                    $amount = (float) $fee['amount'];
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
        }
    }

    public function submit()
    {
        $this->validate();

        // Save user data
        $user = User::find(auth()->user()->id);
        $user->address = $this->address;
        $user->unit = $this->unit;
        $user->city = $this->city;
        $user->state = $this->state;
        $user->zip = $this->zip;
        $user->save();

        // Update Stripe data
        $user->updateStripeCustomer([
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
        $user = User::find(auth()->user()->id);
        $user->stripe_pm = $setupIntent['payment_method'];
        $user->save();

        dd($setupIntent);

        // Update reservation
        // dd($user->charge(Currency::toPennies($this->pricing_total), $setupIntent['payment_method'], [
        //     'off_session' => true,
        //     'confirm' => true,
        // ]));
    }
}
