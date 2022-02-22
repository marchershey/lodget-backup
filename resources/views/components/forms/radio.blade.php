<div class="flex items-center">
    <input wire:model="{{ $wireId }}" id="{{ $wireId }}-{{ $value }}" name="{{ $wireId }}" value="{{ $value }}" type="radio" class="w-4 h-4 border-gray-300 text-primary focus:ring-prmary">
    <label for="{{ $wireId }}-{{ $value }}" class="block ml-3 text-sm font-medium text-gray-700">
        {{ $label }}
    </label>
</div>