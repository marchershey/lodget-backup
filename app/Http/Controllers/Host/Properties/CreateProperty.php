<?php

namespace App\Http\Controllers\Host\Properties;

use App\Models\Amenity;
use App\Models\Fee;
use App\Models\Photo;
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
    public $guest_count = 1;
    public $bedroom_count = 0;
    public $bed_count = 0;
    public $bathroom_count = 0;

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
        'guest_count' => 'required',
        'bedroom_count' => 'required',
        'bed_count' => 'required',
        'bathroom_count' => 'required',
        'rate' => 'required|max:250',
        'tax_rate' => 'required|max:250|numeric',
        'fees.*.name' => 'required_unless:fees,null|max:250',
        'fees.*.amount' => 'required_unless:fees,null|max:250',
        'fees.*.type' => 'required_unless:fees,null|max:250',
        'amenities' => "",
        'stagedPhotos' => 'required',
        'stagedPhotos.*' => 'image|max:12288', // not needed i guess? 
        'calendar_color' => 'required|size:7',
    ];

    public function render()
    {
        return view('pages.host.properties.create')->layout('layouts.host-dashboard');
    }
    public function mount()
    {
        $this->name = "Ohana Burnside";
        $this->address_street = "123 address ave";
        $this->address_city = "lexington";
        $this->address_state = "KY";
        $this->address_zip = "10001";
        $this->listing_headline = "a beautiful place to stay";
        $this->listing_description = "What a wonderful place to stay - What a wonderful place to stay - What a wonderful place to stay - What a wonderful place to stay";
        $this->guest_count = 0;
        $this->bedroom_count = 4;
        $this->bed_count = 8;
        $this->bathroom_count = 2.5;
        $this->rate = 379.04;
        $this->tax_rate = 7;
        $this->fees = [
            [
                'name' => 'Cleaning Fee',
                'amount' => 175,
                'type' => 'fixed',
            ],
            [
                'name' => 'Service Fee',
                'amount' => 10,
                'type' => 'percentage',
            ],

        ];
        $this->amenities = [
            'garage',
            'kitchen',
            'swimming pool',
        ];
        $this->calendar_color = "#ff6700";
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
    public function updatedStagedPhotos()
    {
        $this->validateOnly('stagedPhotos.*');
    }
    public function removeStagedPhoto($key)
    {
        unset($this->stagedPhotos[$key]);
    }
    public function reorder($ids)
    {
        // dd($ids);
        // dd($this->stagedPhotos);

        $order = [];

        // OPTIMIZE!!!
        foreach ($ids as $key => $id) {
            // $this->order
            $order[$key] = $this->stagedPhotos[$id];
        }

        $this->stagedPhotos = $order;

        // dd($this->stagedPhotos);


        # code...
    }






    public function submit()
    {
        $this->validate();

        // Property
        $property = new Property();
        $property->name = $this->name;
        $property->address_street = $this->address_street;
        $property->address_city = $this->address_city;
        $property->address_state = $this->address_state;
        $property->addresS_zip = $this->address_zip;
        $property->listing_headline = $this->listing_headline;
        $property->listing_description = $this->listing_description;
        $property->guest_count = $this->guest_count;
        $property->bedroom_count = $this->bedroom_count;
        $property->bed_count = $this->bed_count;
        $property->bathroom_count = $this->bathroom_count;
        $property->rate = number_format($this->rate, 2);
        $property->tax_rate = $this->tax_rate;
        $property->calendar_color = $this->calendar_color;
        $property->user_id = 1;
        $property->save();

        if ($this->fees) {
            foreach ($this->fees as $fee) {
                $newFee = new Fee();
                $newFee->name = $fee['name'];
                $newFee->amount = $fee['amount'];
                $newFee->type = $fee['type'];
                $newFee->property_id = $property->id;
                $newFee->user_id = 1;
                $newFee->save();
            }
        }

        // Amenities
        if ($this->amenities) {
            foreach ($this->amenities as $text) {
                $amenity = new Amenity();
                $amenity->text = $text;
                $amenity->property_id = $property->id;
                $amenity->user_id = 1;
                $amenity->save();
            }
        }

        // Photos
        if ($this->stagedPhotos) {
            foreach ($this->stagedPhotos as $key => $stagedPhoto) {
                // upload photo
                $path = $stagedPhoto->store('photos', 'public');

                // store photo in database
                $photo = new Photo();
                $photo->property_id = $property->id;
                $photo->user_id = 1;
                $photo->name = $stagedPhoto->getClientOriginalName();
                $photo->size = $stagedPhoto->getSize();
                $photo->mime = $stagedPhoto->getMimeType();
                $photo->path = $path;
                $photo->order = $key;
                $photo->save();
            }
        }

        // redirect back to properties list
        return redirect()->route('host.properties.index');
    }
}
