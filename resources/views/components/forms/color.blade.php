<div {{ $attributes->class(['']) }}>
    <label for="{{ $wireId }}" class="block">
        <div class="flex items-center space-x-5">
            <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
            <div class="mt-1">
                {{-- <div class="flex items-baseline w-full border border-gray-300 px-3 py-1.5 rounded-md focus-within:ring-1 focus-within:ring-primary focus-within:border-primary sm:text-sm @error($wireId) border-red-500 @enderror"> --}}
                <input class="" wire:loading.attr="disabled" wire:target="submit" type="color" name="{{ $wireId }}" id="{{ $wireId }}" wire:model="{{ $wireId }}" aria-describedby="{{ $wireId }}-description" value="{{ old($wireId) }}">
                {{-- </div> --}}
            </div>
        </div>
        @error($wireId)
            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
        @else
            @if (isset($description))
                <p class="text-muted mt-2 text-sm" id="{{ $wireId }}-description">{{ $description }}</p>
            @endif
        @enderror
    </label>
</div>
