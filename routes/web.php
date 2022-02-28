<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('https://www.facebook.com/OHANA-Burnside-1416857558456870/', 302);
});

Route::name('host.')->prefix('host')->group(function () {
    Route::view('/', 'pages.host.dashboard')->name('dashboard');

    Route::view('/reservations', 'pages.host.reservations')->name('reservations');

    Route::name('properties.')->prefix('properties')->group(function () {
        Route::view('/', 'pages.host.properties.index')->name('index');
        Route::get('/new', \App\Http\Controllers\Host\Properties\CreateProperty::class)->name('create');
    });
});

Route::name('guests.')->prefix('/guests')->group(function () {
    Route::get('/', function () {
        return "Test";
    });
});
