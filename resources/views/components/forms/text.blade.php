<div {{ $attributes->class(['']) }}>
    <label for="{{ $wireId }}" class="block">
        <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
        <div class="mt-1">
            <div class="flex items-baseline w-full border border-gray-300 px-3 py-1.5 rounded-md focus-within:ring-1 focus-within:ring-primary focus-within:border-primary sm:text-sm @error($wireId) border-red-500 @enderror">
                @if (isset($before))
                    <div {{ $before->attributes->class(['mr-2 flex items-baseline self-center']) }}>
                        {{ $before ?? null }}
                    </div>
                @endif
                <div class="w-full">
                    <input wire:model.debounce.500ms="{{ $wireId }}" wire:loading.class="opacity-20" wire:loading.attr="readonly" wire:target="{{ $wireTarget }}" type="{{ $inputType }}" name="{{ $wireId }}" id="{{ $wireId }}" class="w-full p-0 border-none focus:ring-0 placeholder-muted-lighter {{ $inputClass }}" placeholder="{{ $placeholder }}" aria-describedby="{{ $wireId }}-description" value="{{ old($wireId) }}">
                </div>
                @if (isset($after))
                    <div {{ $after->attributes->class(['ml-2 flex items-baseline self-center']) }}>
                        {{ $after ?? null }}
                    </div>
                @endif
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
