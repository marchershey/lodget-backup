<div {{ $attributes->class(['']) }}>
    <label for="{{ $inputId }}" class="block">
        <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
        <select id="{{ $inputId }}" name="{{ $inputId }}" class="block w-full py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary sm:text-sm" aria-describedby="{{ $inputId }}-description">
            @foreach($options as $key => $value)
            <option {{ old($inputId)==$key ? "selected" : "" }} value="{{ $key }}"> {{ $value }} </option>
            @endforeach
        </select>
        @if(isset($description))
        <p class="mt-2 text-sm text-muted" id="{{ $inputId }}-description">We'll only use this for spam.</p>
        @endif
    </label>
</div>