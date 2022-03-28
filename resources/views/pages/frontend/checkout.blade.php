<div>
    <div class="minimal-container" wire:init="load" x-data="{ loading: @entangle('loading') }">
        @if ($property)
            <div class="minimal-panel">
                <div class="flex items-center space-x-5">
                    <div class="aspect-video h-28 w-28">
                        <div class="image" style="background-image:url(/storage/{{ $photo->path ?? '' }})"></div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-medium">{{ $property->name ?? '' }}</h1>
                        <span class="text-muted capitalize">{{ $property->address_city }}, {{ $property->address_state }}</span>
                    </div>
                </div>
            </div>

            <div class="minimal-panel">
                <div class="flex items-center justify-between">
                    <h1 class="text-xl font-medium">Your trip</h1>
                    <button type="button" class="button button-link px-0 text-sm" wire:click="cancel">Change Dates</button>
                </div>
                <div class="flex justify-between">
                    <div class="flex flex-col text-left">
                        <span class="text-muted text-sm">Check-in</span>
                        <span class="text-base font-semibold">{{ $checkin_date }}</span>
                    </div>
                    <div class="flex flex-col text-right">
                        <span class="text-muted text-sm">Check-out</span>
                        <span class="text-base font-semibold">{{ $checkout_date }}</span>

                    </div>
                </div>

                <hr>

                <div class="flex items-center justify-between">
                    <h1 class="text-xl font-medium">Pricing details</h1>
                </div>
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
                <div x-data="{ discount: false }">
                    <hr class="mb-3">
                    <span x-on:click="discount = !discount" class="text-link">Enter discount code</span>
                    <div x-show="discount" x-cloak class="mt-3 rounded-lg bg-gray-100 p-3 text-center text-xs">
                        Sorry, there are no discount codes active at this time.
                    </div>
                </div>
            </div>

            <form wire:submit.prevent="submit" class="minimal-panel">
                <h1 class="text-xl font-medium">Payment details</h1>
                <div class="grid grid-cols-12 gap-3">
                    <x-forms.text wireId="address" label="Address" class="col-span-9" />
                    <x-forms.text wireId="unit" label="Unit" class="col-span-3" />
                    <x-forms.text wireId="city" label="City" class="col-span-full" />
                    <x-forms.select wireId="state" label="State" class="col-span-8" :options="['AL'=>'Alabama','AK'=>'Alaska','AZ'=>'Arizona','AR'=>'Arkansas','CA'=>'California','CO'=>'Colorado','CT'=>'Connecticut','DE'=>'Delaware','DC'=>'District of Columbia','FL'=>'Florida','GA'=>'Georgia','HI'=>'Hawaii','ID'=>'Idaho','IL'=>'Illinois','IN'=>'Indiana','IA'=>'Iowa','KS'=>'Kansas','KY'=>'Kentucky','LA'=>'Louisiana','ME'=>'Maine','MD'=>'Maryland','MA'=>'Massachusetts','MI'=>'Michigan','MN'=>'Minnesota','MS'=>'Mississippi','MO'=>'Missouri','MT'=>'Montana','NE'=>'Nebraska','NV'=>'Nevada','NH'=>'New Hampshire','NJ'=>'New Jersey','NM'=>'New Mexico','NY'=>'New York','NC'=>'North Carolina','ND'=>'North Dakota','OH'=>'Ohio','OK'=>'Oklahoma','OR'=>'Oregon','PA'=>'Pennsylvania','RI'=>'Rhode Island','SC'=>'South Carolina','SD'=>'South Dakota','TN'=>'Tennessee','TX'=>'Texas','UT'=>'Utah','VT'=>'Vermont','VA'=>'Virginia','WA'=>'Washington','WV'=>'West Virginia','WI'=>'Wisconsin','WY'=>'Wyoming']" />
                    <x-forms.text wireId="zip" label="Zip" inputType="tel" inputClass="zip-code" class="col-span-4" />
                </div>
                <div x-show="!loading">
                    <span class="label">Card details</span>
                    <div wire:ignore id="card-element" class="font-base rounded-md border border-gray-300 px-3 py-2 font-sans"></div>
                </div>
                <div>
                    <button type="submit" class="button button-primary w-full">Confirm Reservation</button>
                </div>
                <p class="text-muted mt-2 text-xs italic"><strong>Please note:</strong> To help us keep you 100% safe online and to maintain PCI compliance, your billing details are handled by <strong>Stripe.com</strong>. We never see your billing details, nor will our servers ever save your billing details. Check out our <span class="text-link">Privacy Policy</span> for more information.</p>
            </form>
        @else
            <div class="minimal-panel">
                <div class="flex animate-pulse items-center space-x-5">
                    <div class="h-28 w-28 flex-none rounded-lg bg-gray-200"></div>
                    <div class="flex w-full flex-col space-y-2">
                        <div class="h-5 w-full rounded bg-gray-200"></div>
                        <div class="h-5 w-1/3 rounded bg-gray-200"></div>
                    </div>
                </div>
            </div>
        @endif
    </div>

</div>

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        window.addEventListener('setupStripeCardElement', event => {
            window.stripe = Stripe('{{ env('STRIPE_KEY') }}');
            window.cardElement = stripe.elements().create('card', {
                style: {
                    base: {
                        fontSize: "16px",
                        color: "#374151",
                        "::placeholder": {
                            color: "#d1d5db"
                        }
                    }
                }
            });
            cardElement.mount('#card-element');
        });
        window.addEventListener('submitStripe', async (event) => {
            const {
                setupIntent,
                error
            } = await stripe.confirmCardSetup(
                @this.stripe_client_secret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: @this.name,
                            email: @this.email,
                            phone: @this.phone,
                            address: {
                                line1: @this.address,
                                line2: @this.unit,
                                city: @this.city,
                                state: @this.state,
                                postal_code: @this.zip,
                            }
                        }
                    }
                }
            );
            if (error) {
                Toast.danger(error.message).push()
            } else {
                @this.finalize(setupIntent);
            }
        });
    </script>
@endpush
