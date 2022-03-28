<?php

namespace App\Http\Controllers\Host\Properties;

use App\Models\Amenity;
use App\Models\Fee;
use App\Models\Photo;
use App\Models\Property;
use Livewire\Component;
use Livewire\WithFileUploads;
use Usernotnull\Toast\Concerns\WireToast;

class EditProperty extends Component
{
    use WithFileUploads, WireToast;

    // states
    public $ready = true;

    // property information
    public $property_id;
    public $property;
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
    public $min_nights = 1;

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
        'amenities' => '',
        'stagedPhotos' => '',
        'stagedPhotos.*' => 'image|max:5120',
        'calendar_color' => 'required|size:7',
        'min_nights' => 'required|integer|min:1|max:7',
    ];

    public function render()
    {
        return view('pages.host.properties.edit')->layout('layouts.host-dashboard');
    }
    public function mount($id)
    {
        $this->property_id = $id;
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
     * Load the property
     * I have this on a seperate function to 
     * allow the page to load quickly, then 
     * load the property data.
     */
    public function load()
    {
        if ($this->property = Property::find($this->property_id)) {

            // load property data
            $this->name = $this->property->name;
            $this->address_street = $this->property->address_street;
            $this->address_city = $this->property->address_city;
            $this->address_state = $this->property->address_state;
            $this->address_zip = $this->property->address_zip;
            $this->listing_headline = $this->property->listing_headline;
            $this->listing_description = $this->property->listing_description;
            $this->guest_count = (int) $this->property->guest_count;
            $this->bedroom_count = (int) $this->property->bedroom_count;
            $this->bed_count = (int) $this->property->bed_count;
            $this->bathroom_count = (float) $this->property->bathroom_count;
            $this->rate = $this->property->rate;
            $this->tax_rate = $this->property->tax_rate;
            $this->calendar_color = $this->property->calendar_color;
            $this->min_nights = $this->property->min_nights;

            // load fees
            if ($fees = $this->property->fees()->get(['name', 'amount', 'type'])->toArray()) {
                $this->fees = $fees;
            }

            // load amenities
            if ($amenities = $this->property->amenities()->get(['id', 'text'])->toArray()) {
                foreach ($amenities as $amenity) {
                    $this->amenities[$amenity['id']] = $amenity['text'];
                }
            }

            // load photos
            if ($photos = $this->property->photos()->get(['id', 'name', 'size', 'path'])->toArray()) {
                $this->uploadedPhotos = $photos;
            }
        }

        $this->dispatchBrowserEvent('initDraggable');
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
    public function removeAmenity($id)
    {
        unset($this->amenities[$id]);
    }

    /**
     * Photos
     */
    public function removeStagedPhoto($key)
    {
        unset($this->stagedPhotos[$key]);
    }
    public function removeUploadedPhoto($key, $id)
    {
        unset($this->uploadedPhotos[$key]);
        $photo = Photo::find($id);
        $photo->delete();
    }
    public function reorderUploadedPhotos($ids)
    {
        foreach ($ids as $key => $id) {
            $photo = Photo::find($id);
            $photo->order = $key;
            $photo->save();
            $this->uploadedPhotos = Property::find($this->property_id)->photos()->get(['id', 'name', 'size', 'path'])->toArray();
        }
        # code...
    }


    public function submit()
    {
        // Validate
        $this->validate();

        try {
            // Property Data
            $this->property->name = $this->name;
            $this->property->address_street = $this->address_street;
            $this->property->address_city = $this->address_city;
            $this->property->address_state = $this->address_state;
            $this->property->address_zip = $this->address_zip;
            $this->property->listing_headline = $this->listing_headline;
            $this->property->listing_description = $this->listing_description;
            $this->property->guest_count = $this->guest_count;
            $this->property->bedroom_count = $this->bedroom_count;
            $this->property->bed_count = $this->bed_count;
            $this->property->bathroom_count = $this->bathroom_count;
            $this->property->rate = number_format($this->rate, 2);
            $this->property->tax_rate = $this->tax_rate;
            $this->property->calendar_color = $this->calendar_color;
            $this->property->min_nights = $this->min_nights;
            $this->property->user_id = 1;
            $this->property->save();

            // Fees
            foreach ($this->property->fees as $fee) {
                $fee->delete();
            }
            if ($this->fees) {
                foreach ($this->fees as $fee) {
                    $newFee = new Fee();
                    $newFee->name = $fee['name'];
                    $newFee->amount = $fee['amount'];
                    $newFee->type = $fee['type'];
                    $newFee->property_id = $this->property->id;
                    $newFee->user_id = 1;
                    $newFee->save();
                }
            }

            // Amenities
            foreach ($this->property->amenities as $amenity) {
                $amenity->delete();
            }
            if ($this->amenities) {
                foreach ($this->amenities as $text) {
                    $amenity = new Amenity();
                    $amenity->text = $text;
                    $amenity->property_id = $this->property->id;
                    $amenity->user_id = 1;
                    $amenity->save();
                }
            }

            // Photos
            if ($this->stagedPhotos) {
                $lastOrder = Photo::where('property_id', $this->property_id)->get('order')->last()->order;
                foreach ($this->stagedPhotos as $stagedPhoto) {
                    // increase last order
                    $lastOrder++;

                    // upload photo
                    $path = $stagedPhoto->store('photos', 'public');

                    // store photo in database
                    $photo = new Photo();
                    $photo->property_id = $this->property->id;
                    $photo->user_id = 1;
                    $photo->name = $stagedPhoto->getClientOriginalName();
                    $photo->size = $stagedPhoto->getSize();
                    $photo->mime = $stagedPhoto->getMimeType();
                    $photo->path = $path;
                    $photo->order = $lastOrder;
                    $photo->save();
                }
            }

            toast()->success($this->property->name . " updated successfully!")->push();

            // redirect back to properties list
            return redirect()->route('host.properties.index');
        } catch (\Exception $e) {
            toast()->danger($e)->push();
        }
    }
}
