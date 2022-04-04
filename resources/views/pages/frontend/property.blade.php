<div class="frontend-container">
    <div class="frontend-section grid grid-cols-1 space-y-5 lg:grid-cols-3 lg:space-y-0 lg:space-x-5" wire:init="load">

        @if ($property)
            <!-- Left column -->
            <div class="space-y-5 lg:col-span-2">
                {{-- Images --}}
                <div class="panel">
                    <div class="space-y-3" wire:ignore>
                        <div id="main-slider" class="splide -mx-5 -mt-6">
                            <div class="splide__track">
                                <ul class="splide__list">
                                    @foreach ($property->photos as $photo)
                                        <li class="splide__slide relative">
                                            <div class="aspect-w-10 aspect-h-7 bg-muted block w-full overflow-hidden md:rounded-b-lg">
                                                <img src="/storage/{{ $photo->path }}" alt="" class="pointer-events-none object-cover object-center">
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div id="thumbnail-slider" class="splide -mx-5">
                            <div class="splide__track">
                                <ul class="splide__list">
                                    @foreach ($property->photos as $photo)
                                        <li class="splide__slide overflow-hidden rounded-lg">
                                            <div class="aspect-w-10 aspect-h-7 bg-muted block w-full overflow-hidden rounded-b-lg">
                                                <img src="/storage/{{ $photo->path }}" alt="" class="pointer-events-none object-cover object-center">
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Details --}}
                <div class="panel space-y-5">
                    <x-heading heading="About {{ $property->name ?? '' }}" />
                    <div class="flex flex-wrap gap-x-3 gap-y-2 text-xs font-semibold uppercase">
                        <span class="bg-muted-lightest text-muted-darkest rounded-lg px-2 py-1">{{ $property->guest_count }} guests</span>
                        <span class="bg-muted-lightest text-muted-darkest rounded-lg px-2 py-1">{{ $property->bedroom_count }} bedrooms</span>
                        <span class="bg-muted-lightest text-muted-darkest rounded-lg px-2 py-1">{{ $property->bed_count }} beds</span>
                        <span class="bg-muted-lightest text-muted-darkest rounded-lg px-2 py-1">{{ $property->bathroom_count }} bath</span>
                        @if ($property)
                            @if ($property->amenities)
                                @foreach ($property->amenities as $amenity)
                                    <span class="bg-muted-lightest text-muted-darkest rounded-lg px-2 py-1">{{ $amenity->text }}</span>
                                @endforeach
                            @endif
                        @endif
                    </div>
                    <div class="space-y-5">
                        <h3 class="mb-2 text-lg font-semibold capitalize leading-6">{{ $property->listing_headline ?? '' }}</h3>
                        <p>{{ $property->listing_description ?? '' }}</p>
                    </div>
                </div>
            </div>

            {{-- Right column --}}
            <div>
                <div class="panel z-10 flex flex-col" x-data="{ showCalendar: @entangle('showCalendar'), showLoginForm: @entangle('showLoginForm'), showSignupForm: @entangle('showSignupForm') }">

                    {{-- Calendar --}}
                    <div wire:ignore x-show="showCalendar" x-cloak class="space-y-5">
                        <div class="flex justify-between">
                            <div class="flex items-baseline">
                                <span class="text-xl font-semibold">${{ number_format($property->rate ?? 0, 2) }}</span>
                                <span class="text-muted">&nbsp;/ night</span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <svg class="-mt-1 h-6 w-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <span class="text-lg font-semibold">4.9</span>
                            </div>
                        </div>
                        <input type="text" id="dates" class="sr-only">
                        <div id="calendar" class="flex h-full w-full justify-center"></div>
                        <button class="button button-primary w-full" wire:click="checkAvailabilty">Check Availability</button>
                        <div class="bg-muted-lightest text-muted-dark flex items-center space-x-2 rounded p-3 text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <circle cx="12" cy="12" r="9"></circle>
                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                <polyline points="11 12 12 12 12 16 13 16"></polyline>
                            </svg>
                            <span>
                                Please note: there is a {{ $property->min_nights ?? 0 }} night minimum
                            </span>
                        </div>
                    </div>

                    <div x-show="!showCalendar" x-cloak class="space-y-5">

                        {{-- Dates --}}
                        <div class="flex justify-between">
                            <div class="flex flex-col">
                                <span class="text-muted text-sm">Check in</span>
                                <span class="text-xl font-semibold">{{ Carbon\Carbon::parse($checkin_date)->format('M jS') }}</span>
                            </div>
                            <div class="flex flex-col text-right">
                                <span class="text-muted text-sm">Check out</span>
                                <span class="text-xl font-semibold">{{ Carbon\Carbon::parse($checkout_date)->format('M jS') }}</span>
                            </div>
                        </div>

                        <hr>


                        {{-- Prices Breakdown --}}
                        <table class="w-full">
                            <tr class="text-muted text-sm">
                                <td>${{ number_format($property->rate, 2) }} x {{ $nights }} nights</td>
                                <td class="text-right">${{ number_format($pricing_base, 2) }}</td>
                            </tr>
                            @if ($pricing_fees)
                                @foreach ($pricing_fees as $fee)
                                    <tr class="text-muted text-sm">
                                        <td>{{ $fee['name'] }}</td>
                                        <td class="text-right">${{ number_format($fee['amount'], 2) }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            @if ($pricing_tax)
                                <tr class="text-muted text-sm">
                                    <td>Taxes</td>
                                    <td class="text-right">${{ number_format($pricing_tax, 2) }}</td>
                                </tr>
                            @endif
                            <tr class="text-lg">
                                <td class="pt-3 font-medium">Total</td>
                                <td class="pt-3 text-right font-medium">${{ number_format($pricing_total, 2) }}</td>
                            </tr>
                        </table>

                        <hr>

                        {{-- Continue button --}}
                        @auth
                            <div>
                                <button wire:click="submit" type="button" class="button button-primary w-full">Reserve dates</button>
                            </div>
                        @else
                            <div>
                                <form wire:submit.prevent="{{ $authType }}" class="space-y-3" autocomplete="off">
                                    {{-- <div class="text-center text-lg font-semibold"> to reserve your dates</div> --}}
                                    <x-forms.text wireId="email" label="Email address" />
                                    <div x-show="showLoginForm" x-cloak>
                                        <x-forms.text wireId="password_login" inputType="password" label="Password" />
                                    </div>
                                    <div x-show="showSignupForm" x-cloak class="space-y-3">
                                        <x-forms.text wireId="name" label="Full name" inputClass="capitalize" />
                                        <x-forms.text wireId="password_register" inputType="password" label="Password" />
                                        <x-forms.text wireId="password_register_confirmation" inputType="password" label="Confirm Password" />
                                        <x-forms.text wireId="phone" label="Phone Number" inputClass="phone" />
                                        <x-forms.text wireId="birthdate" label="Birthdate" inputClass="date" />
                                    </div>

                                    <button type="submit" class="button button-primary w-full">Continue</button>
                                    <button wire:click="clearDates" type="button" class="button button-link w-full">Change Dates</button>
                                </form>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        @else
            {{-- Loading divs --}}
            <div class="lg:col-span-2">
                <div class="animate-pulse space-y-5">
                    <div class="bg-muted h-[320px] w-full rounded-lg md:h-[435px]"></div>
                    <div class="panel">
                        <div class="bg-muted h-[27px] w-[200px] rounded"></div>
                        <hr class="-mx-5 mt-3">
                        <div class="mt-3 flex space-x-5">
                            <div class="bg-muted h-[24px] w-[73px] rounded"></div>
                            <div class="bg-muted h-[24px] w-[93px] rounded"></div>
                            <div class="bg-muted h-[24px] w-[73px] rounded"></div>
                            <div class="bg-muted h-[24px] w-[83px] rounded"></div>
                        </div>
                        <div class="bg-muted mt-5 h-[24px] w-3/4 rounded"></div>
                        <div class="mt-5 flex flex-col space-y-2">
                            <div class="bg-muted h-4 w-full rounded"></div>
                            <div class="bg-muted h-4 w-3/5 rounded"></div>
                            <div class="bg-muted h-4 w-4/5 rounded"></div>
                            <div class="bg-muted h-4 w-2/5 rounded"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="panel animate-pulse">
                    <div class="bg-muted h-6 w-3/4 rounded"></div>
                    <div class="bg-muted mt-5 h-[330px] w-full rounded"></div>
                </div>
            </div>
        @endif
    </div>

</div>

@push('scripts')
    {{-- Calendar --}}
    <script>
        window.addEventListener('calendarInit', event => {
            window.calendar = new Litepicker({
                element: document.getElementById('dates'),
                parentEl: document.getElementById('calendar'),
                zIndex: 1,
                firstDay: 0,
                singleMode: false,
                inlineMode: true,
                minDays: 1, // number of nights + 1
                minDate: new Date() - 1,
                tooltipText: {
                    one: 'night',
                    other: 'nights'
                },
                disallowLockDaysInRange: true,
                // lockDaysFilter: (date1, date2, pickedDates) => {

                //     if(!date2){

                //     }

                //     // if (!date2) {
                //     //     const d = date1.getDay();

                //     //     // return [6, 0].includes(d);
                //     //     return false;
                //     // }

                //     // while (date1.toJSDate() < date2.toJSDate()) {
                //     //     const day = date1.getDay();
                //     //     isWeekend = [6, 0].includes(day);
                //     //     if (isWeekend) {
                //     //         return true;
                //     //     }
                //     //     date1.add(1, 'day');
                //     // }

                //     return false;
                // },
                tooltipNumber: (totalDays) => {
                    return totalDays - 1; // -1 to indicate nights (eg. 2 days selected = 1 night)
                },
                // setup runs when the calendar is initiated 
                setup: (picker) => {
                    // on.preselect runs when first date is selected
                    picker.on('preselect', (date1, date2) => {
                        if (date1 && !date2) {
                            @this.lockCheckoutDates();
                        }
                    });
                    // on.selected runs when 2 dates are selected
                    picker.on('selected', (date1, date2) => {
                        // update the dates on the backend
                        @this.updateDates([date1.dateInstance, date2.dateInstance])
                    });
                    // on.error:range runs when users selected a date range with "booked / locked" dates in the range
                    picker.on('error:range', (b) => {
                        calendar.clearSelection() // clear the user's selected dates
                        @this.clearDates() // clears the backend dates
                        Toast.danger('You\'ve selected dates that are already booked.') // notifies user that dates in range are already booked
                    });
                },

            });
        })

        window.addEventListener('calendarUpdateMinNights', event => {
            min_nights = event.detail.min_nights;
            calendar.setOptions({
                minDays: min_nights + 1
            })
        })

        window.addEventListener('calendarLockDays', event => {
            dateRangesToLock = event.detail.dateRangesToLock;
            calendar.setLockDays(dateRangesToLock);
            console.log(dateRangesToLock);
        })
    </script>

    {{-- Photo Slider --}}
    <script>
        window.addEventListener('sliderLoad', event => {
            var main = new Splide('#main-slider', {
                type: 'loop',
                mediaQuery: 'min',
                pagination: false,
                arrows: true,
                isNavigation: true,
                updateOnMove: true,
                breakpoints: {
                    786: {
                        padding: '20%',
                        gap: 10,
                    },
                },
            });

            var thumbnails = new Splide('#thumbnail-slider', {
                fixedWidth: 150,
                fixedHeight: 100,
                gap: 10,
                padding: 20,
                pagination: false,
                updateOnMove: true,
                arrows: false,
                focus: 'center',
                isNavigation: true,
                breakpoints: {
                    600: {
                        fixedWidth: 80,
                        fixedHeight: 55,
                    },
                },
            });

            main.sync(thumbnails);
            main.mount();
            thumbnails.mount();
        });
    </script>
@endpush
