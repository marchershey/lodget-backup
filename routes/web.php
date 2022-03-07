<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return redirect('https://www.facebook.com/OHANA-Burnside-1416857558456870/', 302);
// });

/* Auth */

Route::get('/login', \App\Http\Controllers\Auth\Login::class)->name('login');
Route::get('/signup', \App\Http\Controllers\Auth\Register::class)->name('register');


/* Frontend */
Route::name('frontend.')->prefix('/')->group(function () {
    Route::get('/', \App\Http\Controllers\Frontend\LandingPage::class)->name('landing');
});


/* Reservations */
Route::name('reservation.')->prefix('reserve')->middleware('auth')->group(function () {
    Route::get('/{id}', \App\Http\Controllers\Reservation\ReservationPage::class);
});


/* Host */
Route::name('host.')->prefix('host')->group(function () {
    Route::view('/', 'pages.host.dashboard')->name('dashboard');

    Route::view('/reservations', 'pages.host.reservations')->name('reservations');

    Route::name('properties.')->prefix('properties')->group(function () {
        // Route::view('/', 'pages.host.properties.list')->name('list');
        Route::get('/', \App\Http\Controllers\Host\Properties\PropertyIndex::class)->name('index');
        Route::get('/new', \App\Http\Controllers\Host\Properties\CreateProperty::class)->name('create');
        Route::get('/edit/{id}', \App\Http\Controllers\Host\Properties\EditProperty::class)->name('edit');
    });
});

/////////////////////////

Route::get('/test', function () {

    // return auth()->user()->updateDefaultPaymentMethodFromStripe();
    $dd = auth()->user()->charge(500, auth()->user()->stripe_pm, [
        'off_session' => true,
        'confirm' => true,
    ]);
    dd($dd);
});

Route::get('/logout', function () {
    auth()->logout();
    return redirect()->route('login');
});

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    Artisan::call('event:clear');
    Artisan::call('route:clear');
    cache()->flush();
});
