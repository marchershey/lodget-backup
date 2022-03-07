<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class Register extends Component
{
    use WireToast;

    public $email;
    public $password;
    public $password_confirmation;
    public $name;
    public $phone;
    public $birthdate;
    public $terms;

    protected $rules = [
        'email' => 'required|email|unique:users,email|max:250',
        'password' => 'required|min:6|max:250|confirmed',
        'password_confirmation' => 'required|min:6|max:250',
        'name' => 'required|max:250',
        'phone' => 'required',
        'birthdate' => 'required|date_format:m/d/Y|before:-18 years',
        'terms' => 'accepted'
    ];

    protected $messages = [
        'birthdate.before' => 'You must be at least 18 years old to rent our properties',
        'birthdate.date_format' => 'Must be in mm/dd/yyyy format',
    ];

    public function render()
    {
        return view('pages.auth.register')->layout('layouts.minimal');
    }

    public function updated($field)
    {
        $this->validateOnly($field);
        if ($field == 'password_confirmation') {
            $this->validateOnly('password');
        }
    }

    public function register()
    {
        $this->validate();

        $user = new User();
        $user->name = ucwords($this->name);
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->birthdate = Carbon::parse($this->birthdate)->toDateString();
        $user->password = Hash::make($this->password);
        $user->save();

        Auth::login($user, true);
        return redirect()->intended();
    }
}
