<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Property;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
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
    public $nights;

    // Pricing details
    public $pricing_base;
    public $pricing_fees;
    public $pricing_tax;
    public $pricing_total;

    // Authentication data
    public $user;
    public $name;
    public $email;
    public $password_login;
    public $password_register;
    public $password_register_confirmation;
    public $phone;
    public $birthdate;

    // Page states
    public $authType = "auth";
    public $showCalendar = true;
    public $showLoginForm = false;
    public $showSignupForm = false;

    // Calendar data
    // public $disabled_date_ranges = []; // for existing reservations

    protected $rules = [
        'email' => 'required|email|max:250',
        'password' => 'required|min:6|max:250|confirmed',
        'password_confirmation' => 'required|min:6|max:250',
        'name' => 'required|max:250',
        'phone' => 'required',
        'birthdate' => 'required|date_format:m/d/Y|before:-18 years',
    ];


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

        // load calendar and lock days for existing reservationsd
        $this->loadCalendar();
        // $this->dispatchBrowserEvent('calendarLockDays', ['reservations' => Reservation::all('checkin_date', 'checkout_date')]);
    }

    public function loadCalendar()
    {
        // init the calendar
        $this->dispatchBrowserEvent('calendarInit');

        // update min nights
        $this->dispatchBrowserEvent('calendarUpdateMinNights', ['min_nights' => $this->property->min_nights]);

        // lock existing reservation days
        $dateRangesToLock = Reservation::all('checkin_date', 'checkout_date')->map(function ($reservation) {
            return collect($reservation)->flatten()->toArray();
        })->toArray();
        $this->dispatchBrowserEvent('calendarLockDays', ['dateRangesToLock' => $dateRangesToLock]);
        # code...
    }

    /**
     * This is just a notification action. If a user presses the "check avail" button
     * they will get a notification telling them to select their dates
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
        $this->checkin_date = Carbon::parse($dates[0])->format('Y-m-d');
        $this->checkout_date = Carbon::parse($dates[1])->format('Y-m-d');

        // sets the number of nights
        $this->nights = Carbon::parse($this->checkin_date)->diffInDays(Carbon::parse($this->checkout_date));

        // calculate prices
        $this->calcPricing();

        // hide the calendar
        $this->showCalendar = false;
    }

    // NEEDS IMPLEMENTATION & DOCUMENTATION
    public function clearDates()
    {
        // clear dates
        $this->checkin_date = null;
        $this->checkout_date = null;

        // clear number of nights
        $this->nights = null;

        // clear pricing
        $this->pricing_base = null;
        $this->pricing_fees = [];
        $this->pricing_tax = null;
        $this->pricing_total = null;

        // bring the calendar back
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
        $this->validate([
            'email' => 'required|email|max:250',
        ]);

        $this->user = User::where('email', $this->email)->first();

        if ($this->user) {
            $this->showLoginForm = true;
            $this->showSignupForm = false;
            $this->authType = "login";
        } else {
            $this->showSignupForm = true;
            $this->showLoginForm = false;
            $this->authType = "signup";

            // since we're showing phone and birthdate input fields
            // lets make sure we mask them
            $this->dispatchBrowserEvent('maskAllElements');
        }
    }

    public function login()
    {
        // validate user data
        $this->validate([
            'email' => 'required|email|max:250',
            'password_login' => 'required|min:6|max:250',
        ]);

        // try to authenticate user
        if ($this->user = auth()->attempt(['email' => $this->email, 'password' => $this->password_login])) {
            $this->user = auth()->user();
            toast()->debug('Welcome back, ' . auth()->user()->firstName() . '!')->pushOnNextPage();
            $this->submit();
        } else {
            toast()->danger('Incorrect password.')->push();
        }
    }

    public function signup()
    {
        // validate user data
        $this->validate([
            'email' => 'required|email|max:250',
            'password_register' => 'required|min:6|max:250|confirmed',
            'name' => 'required|max:250',
            'phone' => 'required',
            'birthdate' => 'required|date_format:m/d/Y|before:-18 years',
        ]);

        // create user
        $this->user = User::create([
            'name' => ucwords($this->name),
            'email' => $this->email,
            'password' => Hash::make($this->password_register),
            'phone' => $this->phone,
            'birthdate' => Carbon::parse($this->birthdate)->toDateString(),
        ]);

        // login user
        auth()->attempt(['email' => $this->email, 'password' => $this->password_register]);

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
                'nights' => $this->nights,
                'checkin_date' => $this->checkin_date,
                'checkout_date' => $this->checkout_date,
            ]);
        } catch (\Exception $e) {
            toast()->danger('Please refresh the page and try again. [' . $e->getCode() . ']', 'Server error')->push();
            return;
        }

        return redirect()->route('frontend.checkout', ['slug' => $reservation->slug]);
    }
}
