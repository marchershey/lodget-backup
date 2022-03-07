<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class Login extends Component
{
    use WireToast;

    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|email|max:250',
        'password' => 'required|max:250',
    ];

    public function render()
    {
        return view('pages.auth.login')->layout('layouts.minimal');
    }

    public function login()
    {
        $this->validate();

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        } else {
            toast()->danger('Invalid credentials')->push();
        }
    }
}
