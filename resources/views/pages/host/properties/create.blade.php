<div>
    <x-slot:title>
        Add New Property
    </x-slot:title>

    <div class="section-spacing">
        {{-- Property Information --}}
        <div class="md:grid md:grid-cols-3 md:gap-5">
            <div class="mb-5">
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
                        <x-forms.text wireId="street" class="md:col-span-8" label="Street Address" />
                        <x-forms.text wireId="city" class="md:col-span-5" label="City" />
                        <x-forms.select wireId="state" class="md:col-span-5" label="State" :options="['AL'=>'Alabama','AK'=>'Alaska','AZ'=>'Arizona','AR'=>'Arkansas','CA'=>'California','CO'=>'Colorado','CT'=>'Connecticut','DE'=>'Delaware','DC'=>'District of Columbia','FL'=>'Florida','GA'=>'Georgia','HI'=>'Hawaii','ID'=>'Idaho','IL'=>'Illinois','IN'=>'Indiana','IA'=>'Iowa','KS'=>'Kansas','KY'=>'Kentucky','LA'=>'Louisiana','ME'=>'Maine','MD'=>'Maryland','MA'=>'Massachusetts','MI'=>'Michigan','MN'=>'Minnesota','MS'=>'Mississippi','MO'=>'Missouri','MT'=>'Montana','NE'=>'Nebraska','NV'=>'Nevada','NH'=>'New Hampshire','NJ'=>'New Jersey','NM'=>'New Mexico','NY'=>'New York','NC'=>'North Carolina','ND'=>'North Dakota','OH'=>'Ohio','OK'=>'Oklahoma','OR'=>'Oregon','PA'=>'Pennsylvania','RI'=>'Rhode Island','SC'=>'South Carolina','SD'=>'South Dakota','TN'=>'Tennessee','TX'=>'Texas','UT'=>'Utah','VT'=>'Vermont','VA'=>'Virginia','WA'=>'Washington','WV'=>'West Virginia','WI'=>'Wisconsin','WY'=>'Wyoming']" />
                        <x-forms.text wireId="zip" class="md:col-span-2" label="Zip" />
                    </div>
                </div>
            </div>
        </div>

        {{-- Listing Information --}}
        <div class="md:grid md:grid-cols-3 md:gap-5">
            <div class="mb-5">
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

        {{-- Amenities --}}
        <div class="md:grid md:grid-cols-3 md:gap-5">
            <div class="mb-5">
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
                        <x-forms.text wire:keydown.enter="addAmenity" wireId="amenity" class="md:col-span-6" label="Add Amenities" description="Type an amenity to add, then press enter." />
                        @if(count($amenities) > 0)
                        <div class="flex flex-wrap gap-3 leading-7 col-span-full">
                            @foreach($amenities as $key => $amenity)
                            <div wire:click="removeAmenity({{ $key }})" class="flex items-center space-x-2 text-sm cursor-pointer badge badge-gray hover:badge-red">
                                <span class="capitalize">{{ $amenity }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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

        {{-- Pricing Information --}}
        <div class="md:grid md:grid-cols-3 md:gap-5">
            <div class="mb-5">
                <x-heading>
                    Pricing Information
                </x-heading>
                <p class="leading-snug text-muted">
                    The information about the amount to charge per night, as well as taxes and fees.
                </p>
            </div>
            <div class="col-span-2">
                <div class="panel" wire:loading.class="opacity-50" wire:target="submit">
                    <div class="grid grid-cols-2 gap-5 md:grid-cols-12">
                        <x-forms.text wireId="nightly_rate" class="md:col-span-3" label="Nightly Rate" placeholder="0.00" inputClass="money">
                            <x-slot:before class="text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2"></path>
                                    <path d="M12 3v3m0 12v3"></path>
                                </svg>
                            </x-slot:before>
                            <x-slot:after class="text-muted">USD</x-slot:after>
                        </x-forms.text>
                        <x-forms.text wireId="tax_rate" class="md:col-span-3" label="Tax Rate" placeholder="7" inputClass="money">
                            <x-slot:after class="text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="17" cy="17" r="1"></circle>
                                    <circle cx="7" cy="7" r="1"></circle>
                                    <line x1="6" y1="18" x2="18" y2="6"></line>
                                </svg>
                            </x-slot:after>
                        </x-forms.text>
                        <div class="flex items-baseline md:justify-end col-span-full md:col-span-6 md:mt-7">
                            <button wire:click="addFee()" type="button" class="button button-gray">Add additional fees</button>
                        </div>
                        @foreach($fees as $key => $fee)
                        <hr class="col-span-full md:hidden">
                        <div class="grid grid-cols-2 gap-5 md:grid-cols-12 col-span-full">
                            <x-forms.text wireId="fees.{{ $key }}.name" label="Fee Name" class="md:col-span-6" />
                            <x-forms.text wireId="fees.{{ $key }}.amount" label="Fee Amount" class="md:col-span-3" placeholder="{{ ($fees[$key]['type'] == 'fixed' ? '0.00' : '0') }}" inputClass="money">
                                @if($fees[$key]['type'] == 'fixed')
                                <x-slot:before class="text-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2"></path>
                                        <path d="M12 3v3m0 12v3"></path>
                                    </svg>
                                </x-slot:before>
                                <x-slot:after class="text-muted">USD</x-slot:after>
                                @else
                                <x-slot:after class="text-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <circle cx="17" cy="17" r="1"></circle>
                                        <circle cx="7" cy="7" r="1"></circle>
                                        <line x1="6" y1="18" x2="18" y2="6"></line>
                                    </svg>
                                </x-slot:after>
                                @endif
                            </x-forms.text>
                            <div class="flex md:flex-col col-span-full md:col-span-3">
                                <span class="self-start mr-5 text-sm font-medium text-gray-700">Fee Type</span>
                                <div class="flex space-x-5 md:mt-4">
                                    <x-forms.radio wireId="fees.{{ $key }}.type" value="fixed" label="Fixed" />
                                    <x-forms.radio wireId="fees.{{ $key }}.type" value="percentage" label="Percentage" />
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Photos --}}
        <div class="md:grid md:grid-cols-3 md:gap-5">
            <div class="mb-5">
                <x-heading>
                    Photos
                </x-heading>
                <p class="text-muted">
                    Show off your property by adding a few photos. You can add up to 20 photos.
                </p>
            </div>
            <div class="col-span-2">
                <div class="panel" wire:loading.class="opacity-50" wire:target="submit">
                    <label for="file-upload" class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <svg class="w-12 h-12 mx-auto text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <div class="relative font-medium text-indigo-600 bg-white rounded-md cursor-pointer hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Select photos</span>
                                    <input id="file-upload" name="file-upload" type="file" accept="image/png, image/jpeg" class="sr-only">
                                </div>
                                <p class="pl-1">or drag and drop them here</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                PNG, JPG, GIF up to 10MB
                            </p>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="button" wire:click="submit" class="button button-blue">Save Property</button>
        </div>
    </div>

</div>