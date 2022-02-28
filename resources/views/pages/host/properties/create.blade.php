<div>
    <x-slot:goback></x-slot:goback>
    <x-slot:title>
        Add New Property
    </x-slot:title>

    <div class="section-spacing">
        {{-- Property Information --}}
        <div class="section md:grid md:grid-cols-3 md:gap-5">
            <div>
                <x-heading>
                    Property Information
                </x-heading>
                <p class="text-muted">
                    The basic information about your property
                </p>
            </div>
            <div class="col-span-2">
                <div class="panel" wire:loading.class="opacity-50" wire:target="submit">
                    <div class="grid grid-cols-1 gap-5 md:grid-cols-12">
                        <x-forms.text wireId="name" class="md:col-span-6" label="Property Name" />
                        <x-forms.text wireId="address_street" class="md:col-span-8" label="Street Address" />
                        <x-forms.text wireId="address_city" class="md:col-span-5" label="City" />
                        <x-forms.select wireId="address_state" class="md:col-span-5" label="State" :options="['AL'=>'Alabama','AK'=>'Alaska','AZ'=>'Arizona','AR'=>'Arkansas','CA'=>'California','CO'=>'Colorado','CT'=>'Connecticut','DE'=>'Delaware','DC'=>'District of Columbia','FL'=>'Florida','GA'=>'Georgia','HI'=>'Hawaii','ID'=>'Idaho','IL'=>'Illinois','IN'=>'Indiana','IA'=>'Iowa','KS'=>'Kansas','KY'=>'Kentucky','LA'=>'Louisiana','ME'=>'Maine','MD'=>'Maryland','MA'=>'Massachusetts','MI'=>'Michigan','MN'=>'Minnesota','MS'=>'Mississippi','MO'=>'Missouri','MT'=>'Montana','NE'=>'Nebraska','NV'=>'Nevada','NH'=>'New Hampshire','NJ'=>'New Jersey','NM'=>'New Mexico','NY'=>'New York','NC'=>'North Carolina','ND'=>'North Dakota','OH'=>'Ohio','OK'=>'Oklahoma','OR'=>'Oregon','PA'=>'Pennsylvania','RI'=>'Rhode Island','SC'=>'South Carolina','SD'=>'South Dakota','TN'=>'Tennessee','TX'=>'Texas','UT'=>'Utah','VT'=>'Vermont','VA'=>'Virginia','WA'=>'Washington','WV'=>'West Virginia','WI'=>'Wisconsin','WY'=>'Wyoming']" />
                        <x-forms.text wireId="address_zip" class="md:col-span-2" label="Zip" inputType="tel" inputClass="zip-code" />
                    </div>
                </div>
            </div>
        </div>

        {{-- Listing Information --}}
        <div class="section md:grid md:grid-cols-3 md:gap-5">
            <div>
                <x-heading>
                    Listing Information
                </x-heading>
                <p class="text-muted">
                    The information that is displayed to guests.
                </p>
            </div>
            <div class="col-span-2">
                <div class="panel" wire:loading.class="opacity-50" wire:target="submit">
                    <div class="grid grid-cols-1 gap-5 md:grid-cols-12">
                        <x-forms.text wireId="listing_headline" class="md:col-span-6" label="Listing Headline" />
                        <x-forms.textarea wireId="listing_description" class="md:col-span-8" label="Listing Description" />
                    </div>
                </div>
            </div>
        </div>

        {{-- Pricing Information --}}
        <div class="section md:grid md:grid-cols-3 md:gap-5">
            <div>
                <x-heading>
                    Pricing Information
                </x-heading>
                <p class="text-muted leading-snug">
                    The information about the amount to charge per night, as well as taxes and fees.
                </p>
            </div>
            <div class="col-span-2">
                <div class="panel" wire:loading.class="opacity-50" wire:target="submit">
                    <div class="grid grid-cols-2 gap-5 md:grid-cols-12">
                        <x-forms.text wireId="rate" class="md:col-span-3" label="Nightly Rate" placeholder="0.00" inputClass="money">
                            <x-slot:before class="text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon h-4 w-4" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2">
                                    </path>
                                    <path d="M12 3v3m0 12v3"></path>
                                </svg>
                            </x-slot:before>
                            <x-slot:after class="text-muted">USD</x-slot:after>
                        </x-forms.text>
                        <x-forms.text wireId="tax_rate" class="md:col-span-3" label="Tax Rate" placeholder="7" inputClass="money">
                            <x-slot:after class="text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon h-4 w-4" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="17" cy="17" r="1"></circle>
                                    <circle cx="7" cy="7" r="1"></circle>
                                    <line x1="6" y1="18" x2="18" y2="6"></line>
                                </svg>
                            </x-slot:after>
                        </x-forms.text>
                        <div class="col-span-full flex items-baseline md:col-span-6 md:mt-7 md:justify-end">
                            <button wire:click="addFee()" type="button" class="button button-gray">Add additional
                                fees</button>
                        </div>
                        @foreach ($fees as $key => $fee)
                            <hr class="col-span-full md:hidden">

                            <div class="col-span-full grid grid-cols-2 gap-5 md:col-span-8">
                                <x-forms.text wireId="fees.{{ $key }}.name" label="Fee Name" />
                                <x-forms.text wireId="fees.{{ $key }}.amount" label="Fee Amount" placeholder="{{ $fees[$key]['type'] == 'fixed' ? '0.00' : '0' }}" inputClass="money">
                                    @if ($fees[$key]['type'] == 'fixed')
                                        <x-slot:before class="text-muted">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon h-4 w-4" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2">
                                                </path>
                                                <path d="M12 3v3m0 12v3"></path>
                                            </svg>
                                        </x-slot:before>
                                        <x-slot:after class="text-muted">USD</x-slot:after>
                                    @else
                                        <x-slot:after class="text-muted">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon h-4 w-4" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <circle cx="17" cy="17" r="1"></circle>
                                                <circle cx="7" cy="7" r="1"></circle>
                                                <line x1="6" y1="18" x2="18" y2="6"></line>
                                            </svg>
                                        </x-slot:after>
                                    @endif
                                </x-forms.text>
                            </div>
                            <div class="col-span-full grid grid-cols-2 gap-5 md:col-span-4">
                                <div class="col-span-4 flex justify-between">
                                    <div>
                                        <span class="mr-5 self-start text-sm font-medium text-gray-700">Fee Type</span>
                                        <div class="mt-1 flex space-x-5 md:mt-3">
                                            <x-forms.radio wireId="fees.{{ $key }}.type" value="fixed" label="Fixed" />
                                            <x-forms.radio wireId="fees.{{ $key }}.type" value="percentage" label="Percentage" />
                                        </div>
                                    </div>
                                    <div class="mt-7 flex justify-end md:mt-9">
                                        <svg wire:click="removeFee({{ $key }})" xmlns="http://www.w3.org/2000/svg" class="text-muted icon h-6 w-6 cursor-pointer hover:text-red-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Amenities --}}
        <div class="section md:grid md:grid-cols-3 md:gap-5">
            <div>
                <x-heading>
                    Amenities
                </x-heading>
                <p class="text-muted">
                    Add all of the amenities that your property has to offer.
                </p>
            </div>
            <div class="col-span-2">
                <div class="panel" wire:loading.class="opacity-50" wire:target="submit">
                    <div class="grid grid-cols-1 gap-5 md:grid-cols-12">
                        <x-forms.text wire:keydown.enter="addAmenity" wireTarget="addAmenity" wireId="amenity" class="md:col-span-6" label="Add Amenities" description="Type an amenity to add, then press enter." />
                        @if (count($amenities) > 0)
                            <div class="col-span-full flex flex-wrap gap-3 leading-7">
                                @foreach ($amenities as $key => $amenity)
                                    <div wire:click="removeAmenity({{ $key }})" class="badge badge-gray hover:badge-red flex cursor-pointer items-center space-x-2 text-sm">
                                        <span class="capitalize">{{ $amenity }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon h-4 w-4" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Photos --}}
        <div class="section md:grid md:grid-cols-3 md:gap-5">
            <div>
                <x-heading>
                    Photos
                </x-heading>
                <p class="text-muted">
                    Show off your property by adding a few photos. You can add up to 20 photos.
                </p>
            </div>
            <div class="col-span-2">
                <div class="panel" wire:loading.class="opacity-50" wire:target="submit">
                    <label for="file-upload">
                        <button type="button" onclick="document.getElementById('photo-upload').click()" class="button button-gray">Select Photos</button>
                        <input wire:model="stagedPhotos" id="photo-upload" type="file" accept="image/png, image/jpeg" class="sr-only" multiple>
                    </label>


                    @if ($stagedPhotos)
                        <div class="mt-5 grid grid-cols-2 gap-5 md:grid-cols-5">
                            @foreach ($stagedPhotos as $key => $photo)
                                <div class="group relative">
                                    <div class="absolute inset-0 hidden items-center justify-center rounded-lg bg-gray-900/60 backdrop-blur-sm group-hover:flex">
                                        <button wire:click="removeStagedPhoto({{ $key }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon h-12 w-12 cursor-pointer text-red-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M4 7h16"></path>
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                <path d="M10 12l4 4m0 -4l-4 4"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="aspect-square rounded-lg bg-cover bg-center ring-1 ring-inset ring-gray-800/30" style="background-image: url({{ $photo->temporaryUrl() }})"></div>
                                </div>
                            @endforeach
                        </div>
                    @endif


                    @error('photos.*')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Amenities --}}
        <div class="section md:grid md:grid-cols-3 md:gap-5">
            <div>
                <x-heading>
                    Options
                </x-heading>
                <p class="text-muted">
                    Set the options related to this property
                </p>
            </div>
            <div class="col-span-2">
                <div class="panel" wire:loading.class="opacity-50" wire:target="submit">
                    <x-forms.color wireId="calendar_color" label="Calendar Color" description="The background color each reservation will have when assigned to this property. Note: The text color is white, so be sure to pick a darker color" />
                </div>
            </div>
        </div>

        <div class="flex justify-end" x-data="{ready: @entangle('ready')}">
            <button type="button" wire:click="submit" id="submit" :class="ready ? 'button-blue' : 'button-gray'" class="button">Save Property</button>
        </div>
    </div>

</div>
