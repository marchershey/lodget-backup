<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('https://www.facebook.com/OHANA-Burnside-1416857558456870/', 302);
});


/////////////////////////

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

Route::name('guests.')->prefix('/guests')->group(function () {
    Route::get('/', function () {
        return "Test";
    });
});

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    Artisan::call('event:clear');
    Artisan::call('route:clear');
    cache()->flush();

});
