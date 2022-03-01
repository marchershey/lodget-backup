<div {{ $attributes->class(['']) }} x-data="{{ $wireId }}_number()">
    <label for="{{ $wireId }}">
        <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
        <div class="mt-1 flex w-full rounded-md overflow-hidden sm:text-sm focus-within:ring-1 focus-within:ring-primary focus-within:border-primary border border-gray-300 @error($wireId) border-red-500 @enderror">
            <button x-on:click="subtract()" x-bind:disabled="subtractDisabled" class="mr-px border-r border-gray-300 bg-gray-100 px-3 text-gray-600 focus-within:ring-1 focus:ring-0 focus-visible:border-blue-600 focus-visible:bg-blue-600 focus-visible:text-white focus-visible:outline-none focus-visible:ring-blue-600 active:bg-blue-600 active:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon h-5 w-5" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
            </button>
            <input x-model.value="value" wire:loading.class="opacity-20" wire:loading.attr="readonly" wire:target="{{ $wireTarget }}" type="text" name="{{ $wireId }}" id="{{ $wireId }}" class="border-none text-center focus:outline-none focus:ring-0 w-full px-3 py-1.5 {{ $inputClass }}" tabindex="-1" readonly />
            <button x-on:click="add()" x-bind:disabled="addDisabled" class="border-l border-gray-300 bg-gray-100 px-3 text-gray-600 focus-within:ring-1 focus:ring-0 focus-visible:border-blue-600 focus-visible:bg-blue-600 focus-visible:text-white focus-visible:outline-none focus-visible:ring-blue-600 active:bg-blue-600 active:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon h-5 w-5" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
            </button>
        </div>
    </label>
</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('{{ $wireId }}_number', (config) => ({
                value: @entangle($wireId),
                step: {{ $step }},
                min: {{ $min }},
                max: {{ $max }},
                add() {
                    this.value = (this.addDisabled) ? this.value + this.step : this.value
                },
                subtract() {
                    this.value = (this.subtractDisabled) ? this.value - this.step : this.value
                },
                addDisabled() {
                    return this.value >= this.max
                },
                subtractDisabled() {
                    return this.value <= this.min
                },
            }))
        })
    </script>
@endpush
