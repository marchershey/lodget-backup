<div {{ $attributes->class(['']) }}>
    <label for="{{ $wireId }}" class="block">
        <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
        <div class="mt-1">
            <select wire:model="{{ $wireId }}" wire:loading.class="opacity-20" wire:loading.attr="readonly" wire:target="{{ $wireTarget }}" name="{{ $wireId }}" id="{{ $wireId }}" class="px-3 py-1.5 focus-within:ring-primary border-gray-300 focus-within:border-primary flex w-full items-baseline rounded-md border focus-within:ring-1  @error($wireId) border-red-500 @enderror {{ $inputClass }}" placeholder="{{ $placeholder }}" aria-describedby="{{ $wireId }}-description" value="{{ old($wireId) }}">
                <option value="" hidden>Select a {{ $label }}...</option>
                @foreach ($options as $key => $value)
                    <option class="px-5" {{ old($wireId) == $key ? 'selected' : '' }} value="{{ $key }}"> {{ $value }} </option>
                @endforeach
            </select>
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
