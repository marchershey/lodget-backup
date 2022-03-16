<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Property;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class PropertyPage extends Component
{
    use WireToast;

    // Property data
    public $property_id;
    public $property;
    public $photos;
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

    // Authentication data
    public $user;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    // Page states
    public $authType = "auth";
    public $showCalendar = true;
    public $showLoginForm = false;
    public $showSignupForm = false;


    public function render()
    {
        return view('pages.frontend.property');
    }

    public function mount($property_id)
    {
        $this->property_id = $property_id;
    }

    public function load()
    {
        // load the property data
        $this->property = Property::find($this->property_id);
        $this->photos = $this->property->photos()->get();
        $this->fees = $this->property->fees()->get();

        // load the user if signed in
        if (auth()->user()) {
            $this->user = auth()->user();
        }

        // load slider
        $this->dispatchBrowserEvent('sliderLoad');

        // load calendar
        $this->dispatchBrowserEvent('calendarLoad');
    }

    // public function clearDates()
    // {
    //     $this->checkin = null;
    //     $this->checkout = null;
    //     $this->nights = 0;
    //     $this->basePrice = 0;
    //     $this->cleaningFee = 0;
    //     $this->fees = [];
    //     $this->dispatchBrowserEvent('showcalendar');
    //     $this->dispatchBrowserEvent('clearcalendardates');
    // }

    /**
     * This is just a notification action. If a user presses the "check avail" button
     * they will get a notification telling them to check 
     */
    public function checkAvailabilty()
    {
        toast()->info('Please select your check-in and check-out dates from the calendar')->push();
    }

    /**
     * updateDates updates the selected dates on the b
     */
    public function updateDates($dates)
    {
        // update and formats (YYYY-MM-DD) backend dates
        $this->checkin = Carbon::parse($dates[0])->format('Y-m-d');
        $this->checkout = Carbon::parse($dates[1])->format('Y-m-d');

        // sets the number of nights
        $this->nights = Carbon::parse($this->checkin)->diffInDays(Carbon::parse($this->checkout));

        // calculate prices
        $this->calcPricing();

        // hide the calendar
        $this->showCalendar = false;
    }

    // NEEDS DOCUMENTATION
    public function clearDates()
    {
        $this->checkin = null;
        $this->checkout = null;
        $this->nights = null;
        $this->showCalendar = true;
    }

    /**
     * Calculate the pricing for the selected dates
     */
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

    public function auth()
    {
        $this->user = User::where('email', $this->email)->first();

        if ($this->user) {
            $this->showLoginForm = true;
            $this->showSignupForm = false;
            $this->authType = "login";
        } else {
            $this->showSignupForm = true;
            $this->showLoginForm = false;
            $this->authType = "signup";
        }
    }

    public function login()
    {
        if ($this->user = auth()->attempt(['email' => $this->email, 'password' => $this->password])) {
            $this->user = auth()->user();
            toast()->debug('Welcome back, ' . auth()->user()->firstName() . '!')->pushOnNextPage();
            $this->submit();
        } else {
            toast()->danger('Incorrect password.')->push();
        }
    }

    public function signup()
    {
        // create user
        $this->user = User::create([
            'name' => ucwords($this->name),
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // login user
        auth()->attempt(['email' => $this->email, 'password' => $this->password]);

        // submit the form
        toast()->debug('Thanks for joining, ' . auth()->user()->firstName() . '!')->pushOnNextPage();
        $this->submit();
    }

    public function submit()
    {
        try {
            $reservation = Reservation::create([
                'slug' => Str::uuid()->toString(),
                'property_id' => $this->property->id,
                'user_id' => $this->user->id,
                'checkin' => $this->checkin,
                'checkout' => $this->checkout,
                'nights' => $this->nights,
            ]);
        } catch (\Exception $e) {
            toast()->danger('Please refresh the page and try again. [' . $e->getCode() . ']', 'Server error')->push();
            return;
        }

        return redirect()->route('frontend.checkout', ['reservationSlug' => $reservation->slug]);
    }
}
