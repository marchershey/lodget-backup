<?php

namespace App\Http\Controllers\Host\Properties;

use App\Models\Amenity;
use App\Models\Property;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateProperty extends Component
{
    use WithFileUploads;

    // states
    public $ready = true;

    // property information
    public $name;
    public $address_street;
    public $address_city;
    public $address_state;
    public $address_zip;

    // listing information
    public $listing_headline;
    public $listing_description;

    // pricing information
    public $rate;
    public $tax_rate;
    public $fees = [];

    // Amenities
    public $amenity;
    public $amenities = [];

    // photos
    public $stagedPhotos = [];
    public $uploadedPhotos = [];

    // options
    public $calendar_color = '#2C3E50';

    protected $rules = [
        'name' => 'required|max:100',
        'address_street' => 'required|max:100',
        'address_city' => 'required|max:100',
        'address_state' => 'required|size:2',
        'address_zip' => 'required|size:5',
        'listing_headline' => 'required|max:250',
        'listing_description' => 'required|max:65535',
        'rate' => 'required|max:250',
        'tax_rate' => 'required|max:250',
        'fees.*.name' => 'required_unless:fees,null|max:250',
        'fees.*.amount' => 'required_unless:fees,null|max:250',
        'fees.*.type' => 'required_unless:fees,null|max:250',
        'amenities' => "",
        'stagedPhotos.*' => 'image|max:5120',
        'calendar_color' => 'required|size:7',
    ];

    public function render()
    {
        return view('pages.host.properties.create')->layout('layouts.host-dashboard');
    }
    public function updating()
    {
        $this->ready = false;
    }
    public function updated($field, $value)
    {
        if ($value) {
            $this->validateOnly($field);
        }
        $this->ready = true;
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
        $this->dispatchBrowserEvent('maskAllElements');
    }
    public function removeFee($key)
    {
        unset($this->fees[$key]);
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
     * Photos
     */
    public function removeStagedPhoto($key)
    {
        unset($this->stagedPhotos[$key]);
    }





    public function submit()
    {
        // $this->validate();

        // Property
        $property = new Property();
        $property->name = $this->name;
        $property->address_street = $this->address_street;
        $property->address_city = $this->address_city;
        $property->address_state = $this->address_state;
        $property->addresS_zip = $this->address_zip;
        $property->listing_headline = $this->listing_headline;
        $property->listing_description = $this->listing_description;
        $property->rate = $this->rate;
        $property->tax_rate = $this->tax_rate;
        $property->calendar_color = $this->calendar_color;
        $property->user_id = 1;
        $property->save();
        // $this->property = $property;

        // Amenities
        if($this->amenities){
            foreach($this->amenities as $text){
                $amenity = new Amenity();
                $amenity->text = $text;
                $amenity->property_id = $property->id;
                $amenity->user_id = 1;
            }
        }

        // Photos
        if($this->stagedPhotos){
            foreach($this->stagedPhotos as $stagedPhoto){
                $photo = new $photo
            }
        }
    }

    public function test()
    {
        dd('test');
    }
}
