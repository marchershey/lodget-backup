<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function fees()
    {
        return $this->hasMany(Fee::class);
    }

    public function amenities()
    {
        return $this->hasMany(Amenity::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class)->orderBy('order');
    }

    public function dummyData()
    {
        // $this->name = "Ohana Burnside";
        // $this->address_street = "123 address ave";
        // $this->address_city = "lexington";
        // $this->address_state = "KY";
        // $this->address_zip = "10001";
        // $this->listing_headline = "a beautiful place to stay";
        // $this->listing_description = "What a wonderful place to stay - What a wonderful place to stay - What a wonderful place to stay - What a wonderful place to stay";
        // $this->guest_count = 8;
        // $this->bedroom_count = 4;
        // $this->bed_count = 8;
        // $this->bathroom_count = 2.5;
        // $this->rate = 379.04;
        // $this->tax_rate = 7;
        // $this->fees = [
        //     [
        //         'name' => 'Cleaning Fee',
        //         'amount' => 175,
        //         'type' => 'fixed',
        //     ],
        //     [
        //         'name' => 'Service Fee',
        //         'amount' => 10,
        //         'type' => 'percentage',
        //     ],

        // ];
        // $this->amenities = [
        //     'garage',
        //     'kitchen',
        //     'swimming pool',
        // ];
        // $this->calendar_color = "#ff6700";
    }
}
