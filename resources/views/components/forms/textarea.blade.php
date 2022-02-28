<div {{ $attributes->class(['']) }}>
    <label for="{{ $wireId }}" class="block">
        <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
        <div class="mt-1">
            <textarea rows="{{ $rows }}" cols="{{ $cols }}" name="{{ $wireId }}" id="{{ $wireId }}" wire:model="{{ $wireId }}" class="w-full border border-gray-300 px-3 py-1.5 rounded-md focus:ring-1 focus:ring-primary focus:border-primary sm:text-sm placeholder-muted-lighter @error($wireId) border-red-500 @enderror {{ $inputClass }}" placeholder="{{ $placeholder }}" aria-describedby="{{ $wireId }}-description" value="{{ old($wireId) }}"></textarea>
        </div>
        @error($wireId)
        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
        @else
        @if(isset($description))
        <p class="mt-2 text-sm text-muted" id="{{ $wireId }}-description">{{ $description }}</p>
        @endif
        @endif
    </label>
</div>