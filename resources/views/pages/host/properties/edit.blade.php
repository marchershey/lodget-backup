<div wire:init="load">
    <x-slot:goback></x-slot:goback>
    <x-slot:title>
        Edit Property
    </x-slot:title>

    <div class="section-spacing">
        {{-- Property Information --}}
        <div class="section xl:grid xl:grid-cols-3 xl:gap-5">
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
                    <div class="grid grid-cols-1 gap-5 xl:grid-cols-12">
                        <x-forms.text wireId="name" class="xl:col-span-6" label="Property Name" />
                        <x-forms.text wireId="address_street" class="xl:col-span-8" label="Street Address" />
                        <x-forms.text wireId="address_city" class="xl:col-span-5" label="City" />
                        <x-forms.select wireId="address_state" class="xl:col-span-5" label="State" :options="['AL'=>'Alabama','AK'=>'Alaska','AZ'=>'Arizona','AR'=>'Arkansas','CA'=>'California','CO'=>'Colorado','CT'=>'Connecticut','DE'=>'Delaware','DC'=>'District of Columbia','FL'=>'Florida','GA'=>'Georgia','HI'=>'Hawaii','ID'=>'Idaho','IL'=>'Illinois','IN'=>'Indiana','IA'=>'Iowa','KS'=>'Kansas','KY'=>'Kentucky','LA'=>'Louisiana','ME'=>'Maine','MD'=>'Maryland','MA'=>'Massachusetts','MI'=>'Michigan','MN'=>'Minnesota','MS'=>'Mississippi','MO'=>'Missouri','MT'=>'Montana','NE'=>'Nebraska','NV'=>'Nevada','NH'=>'New Hampshire','NJ'=>'New Jersey','NM'=>'New Mexico','NY'=>'New York','NC'=>'North Carolina','ND'=>'North Dakota','OH'=>'Ohio','OK'=>'Oklahoma','OR'=>'Oregon','PA'=>'Pennsylvania','RI'=>'Rhode Island','SC'=>'South Carolina','SD'=>'South Dakota','TN'=>'Tennessee','TX'=>'Texas','UT'=>'Utah','VT'=>'Vermont','VA'=>'Virginia','WA'=>'Washington','WV'=>'West Virginia','WI'=>'Wisconsin','WY'=>'Wyoming']" />
                        <x-forms.text wireId="address_zip" class="xl:col-span-2" label="Zip" inputType="tel" inputClass="zip-code" />
                    </div>
                </div>
            </div>
        </div>

        {{-- Listing Information --}}
        <div class="section xl:grid xl:grid-cols-3 xl:gap-5">
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
                    <div class="grid grid-cols-4 gap-5 xl:grid-cols-12">
                        <x-forms.text wireId="listing_headline" class="col-span-full xl:col-span-6" label="Listing Headline" />
                        <x-forms.textarea wireId="listing_description" class="col-span-full xl:col-span-8" label="Listing Description" />

                        <x-forms.number wireId="guest_count" class="col-span-2 xl:col-span-3 xl:col-start-1" label="Guests" min="1" max="16" />
                        <x-forms.number wireId="bedroom_count" class="col-span-2 xl:col-span-3" label="Bedrooms" min="1" max="16" />
                        <x-forms.number wireId="bed_count" class="col-span-2 xl:col-span-3" label="Beds" min="1" max="16" />
                        <x-forms.number wireId="bathroom_count" class="col-span-2 xl:col-span-3" label="Bathrooms" min="1" max="16" step="0.5" />
                    </div>
                </div>
            </div>
        </div>

        {{-- Pricing Information --}}
        <div class="section xl:grid xl:grid-cols-3 xl:gap-5">
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
                    <div class="grid grid-cols-2 gap-5 xl:grid-cols-12">
                        <x-forms.text wireId="rate" class="xl:col-span-3" label="Nightly Rate" placeholder="0.00" inputClass="money">
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
                        <x-forms.text wireId="tax_rate" class="xl:col-span-3" label="Tax Rate" placeholder="7" inputClass="money">
                            <x-slot:after class="text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon h-4 w-4" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <circle cx="17" cy="17" r="1"></circle>
                                    <circle cx="7" cy="7" r="1"></circle>
                                    <line x1="6" y1="18" x2="18" y2="6"></line>
                                </svg>
                            </x-slot:after>
                        </x-forms.text>
                        <div class="col-span-full flex items-baseline xl:col-span-6 xl:mt-7 xl:justify-end">
                            <button wire:click="addFee()" type="button" class="button button-gray">Add additional
                                fees</button>
                        </div>
                        @foreach ($fees as $key => $fee)
                            <hr class="col-span-full xl:hidden">

                            <div class="col-span-full grid grid-cols-2 gap-5 xl:col-span-8">
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
                            <div class="col-span-full grid grid-cols-2 gap-5 xl:col-span-4">
                                <div class="col-span-4 flex justify-between">
                                    <div>
                                        <span class="mr-5 self-start text-sm font-medium text-gray-700">Fee Type</span>
                                        <div class="mt-1 flex space-x-5 xl:mt-3">
                                            <x-forms.radio wireId="fees.{{ $key }}.type" value="fixed" label="Fixed" />
                                            <x-forms.radio wireId="fees.{{ $key }}.type" value="percentage" label="Percentage" />
                                        </div>
                                    </div>
                                    <div class="mt-7 flex justify-end xl:mt-9">
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
        <div class="section xl:grid xl:grid-cols-3 xl:gap-5">
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
                    <div class="grid grid-cols-1 gap-5 xl:grid-cols-12">
                        <x-forms.text wire:keydown.prevent.enter="addAmenity" wireTarget="addAmenity" wireId="amenity" class="xl:col-span-6" label="Add Amenities" description="Type an amenity to add, then press enter." />
                        @if (count($amenities) > 0)
                            <div class="col-span-full flex flex-wrap gap-3 leading-7">
                                @foreach ($amenities as $id => $amenity)
                                    <div wire:click="removeAmenity({{ $id }})" class="badge badge-gray hover:badge-red flex cursor-pointer items-center space-x-2 text-sm">
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
        <div class="section xl:grid xl:grid-cols-3 xl:gap-5">
            <div>
                <x-heading>
                    Photos
                </x-heading>
                <p class="text-muted">
                    Show off your property by adding up to 20 photos.
                </p>
            </div>
            <div class="col-span-2">
                <div class="panel space-y-5" wire:loading.class="opacity-50" wire:target="submit" x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false, $dispatch('initDraggable')" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <div class="flex items-center whitespace-nowrap">
                        <label x-show="!isUploading" for="file-upload">
                            <input wire:model="stagedPhotos" id="photo-upload" type="file" accept="image/png, image/jpeg" class="sr-only" multiple>
                            <button type="button" onclick="document.getElementById('photo-upload').click()" class="button button-gray">
                                <span>Select Photos</span>
                            </button>
                        </label>

                        <div x-show="isUploading" x-cloak class="flex w-full items-center space-x-5">
                            <div class="flex items-center">
                                <svg class="-ml-1 mr-3 h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="text-gray-200" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="text-primary/80" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <div class="text-sm font-medium text-gray-700">Uploading...</div>
                            </div>
                            <!-- Progress Bar -->
                            <div x-show="isUploading" x-cloak class="relative h-5 w-full overflow-hidden rounded-full bg-gray-200">
                                <div class="absolute h-full overflow-hidden whitespace-nowrap rounded-l-full bg-blue-600 p-1 text-center text-xs font-medium leading-none text-white" :style="{ 'width': progress + '%'}"><span x-text="progress" class=""></span>%</div>
                            </div>
                        </div>
                    </div>
                    @if ($stagedPhotos)
                        <div class="space-y-5 rounded-lg bg-gray-100 p-5">
                            <div class="grid grid-cols-3 gap-2 sm:grid-cols-4 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-4">
                                @foreach ($stagedPhotos as $key => $photo)
                                    <div wire:click="removeStagedPhoto({{ $key }})" class="group aspect-w-10 aspect-h-7 draggable--handle block w-full cursor-pointer overflow-hidden rounded-lg bg-gray-100">
                                        <img src="{{ $photo->temporaryUrl() }}" alt="" class="pointer-events-none object-cover group-hover:opacity-75">
                                    </div>
                                @endforeach
                            </div>
                            <div class="text-muted text-xs">
                                <strong>Note:</strong> Click/Tap a photo to delete it. Also, you need to save these photos before you can reorder them.
                            </div>
                        </div>
                    @endif

                    @if ($uploadedPhotos)
                        <div class="draggable grid-smaller -mx-2.5 my-2.5 focus-visible:outline-none">
                            @foreach ($uploadedPhotos as $key => $photo)
                                <div class="draggable--item relative rounded-lg bg-white p-2.5 focus-visible:outline-none" data-photo-id="{{ $photo['id'] }}">
                                    <div class="group aspect-w-10 aspect-h-7 draggable--handle block w-full overflow-hidden rounded-lg bg-gray-100">
                                        <img src="/storage/{{ $photo['path'] }}" alt="" class="pointer-events-none object-cover group-hover:opacity-75">
                                    </div>
                                    <div x-data="{ open: false }" class="flex items-center justify-between">
                                        <div class="pointer-events-none mt-2 truncate font-medium">
                                            <p class="block truncate text-sm">{{ $photo['name'] }}</p>
                                            <p class="text-muted block text-xs">{{ number_format($photo['size'] / 1e6, 2) }}MB</p>
                                        </div>
                                        <div class="relative inline-block text-left">
                                            <div x-on:click="open = !open">
                                                <button type="button" class="text-muted flex items-center hover:text-red-500 focus:outline-none" id="menu-button" aria-expanded="true" aria-haspopup="true">
                                                    <span class="sr-only">Open options</span>
                                                    <!-- Heroicon name: solid/dots-vertical -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <line x1="4" y1="7" x2="20" y2="7"></line>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div x-show="open" x-cloak x-on:click="open = false" x-on:click.away="open = false" class="absolute right-0 z-10 mt-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                                                <div wire:click="removeUploadedPhoto({{ $key }}, {{ $photo['id'] }})" class="flex cursor-pointer select-none items-center space-x-2 px-4 py-2 text-sm text-red-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <line x1="4" y1="7" x2="20" y2="7"></line>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                    </svg>
                                                    <span>Delete</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-muted text-xs">
                            <strong>Note:</strong> To reorder the photos, simply drag the photo to a new position.
                        </div>
                    @endif

                    @error('stagedPhotos')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    @error('stagedPhotos.*')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Options --}}
        <div class="section xl:grid xl:grid-cols-3 xl:gap-5">
            <div>
                <x-heading>
                    Options
                </x-heading>
                <p class="text-muted">
                    Set the options related to this property
                </p>
            </div>
            <div class="col-span-2">
                <div class="panel space-y-10" wire:loading.class="opacity-50" wire:target="submit">
                    <x-forms.color wireId="calendar_color" label="Calendar Color" description="The background color each reservation will have when assigned to this property. Note: The text color is white, so be sure to pick a darker color" />
                    <div>
                        <x-forms.number wireId="min_nights" class="col-span-2 xl:col-span-3 xl:col-start-1" label="Minimum Nights" min="1" max="16" description="The minimum number of nights you require a guest to stay" />
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end xl:justify-between" x-data="{ ready: @entangle('ready') }">
            <button type="button" wire:click="submit" id="submit" :class="ready ?'button-red-link' : 'button-gray-link'" class="button">Delete Property</button>
            <button type="button" wire:click="submit" id="submit" :class="ready ?'button-blue' : 'button-gray'" class="button">Update Property</button>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        function initDraggable() {
            const draggable = new Sortable(document.querySelectorAll('.draggable'), {
                draggable: '.draggable--item',
                handle: '.draggable--handle',
                classes: {
                    'mirror': ['opacity-50'],
                    'draggable:over': ['opacity-0'],
                    'source:original': ['hidden'],
                },
                mirror: {
                    constrainDimensions: true,
                },
                plugins: [Plugins.SortAnimation],
                swapAnimation: {
                    duration: 200,
                    easingFunction: "ease-in-out",
                },
            });
            draggable.on("drag:stopped", (event) => {
                @this.reorderUploadedPhotos(
                    Array.from(document.querySelectorAll('.draggable--item')).map(el => el.dataset.photoId)
                )
            });
        }

        window.addEventListener("initDraggable", (event) => {
            initDraggable();
        });
    </script>
@endpush
