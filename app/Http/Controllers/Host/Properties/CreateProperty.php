<?php

namespace App\Http\Controllers\Host\Properties;

use Livewire\Component;

class CreateProperty extends Component
{
    // property information
    public $name;
    public $street;
    public $city;
    public $state;
    public $zip;

    // listing information
    public $listing_headline;
    public $listing_description;

    // Amenities
    public $amenity;
    public $amenities = [];

    // pricing information
    public $nightly_rate;
    public $tax_rate;
    public $fees = [];

    // photos


    protected $rules = [
        'name' => 'required',
        'listing_description' => 'required',
    ];

    public function render()
    {
        return view('pages.host.properties.create')->layout('layouts.host-dashboard');
    }
    public function updated($field, $value)
    {
        $this->validateOnly($field);
    }


    /**
     * Amenities
     */
    public function addAmenity()
    {
        if ($this->amenity != null) {
            if (!in_array($this->amenity, $this->amenities)) {
                $this->amenities[] = $this->amenity;
                $this->amenity = "";
            } else {
                $this->amenity = "";
            }
        }
    }
    public function removeAmenity($key)
    {
        unset($this->amenities[$key]);
    }


    /**
     * Pricing
     */
    public function addFee()
    {
        // $this->fees[] = [];
        array_push($this->fees, [
            'name' => '',
            'amount' => '',
            'type' => 'fixed',
        ]);
        $this->dispatchBrowserEvent('maskDollar');
    }

    public function submit()
    {
        sleep(3);
        $this->validate();
        //
    }
}
