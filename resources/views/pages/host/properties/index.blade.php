<div>
    <x-slot:title>
        Properties
    </x-slot:title>

    <x-slot:action>
        <a href="{{ route('host.properties.create') }}" class="button button-blue">Add New Property</a>
    </x-slot:action>

    <div class="section-spacing" wire:init="load">
        {{-- Recent Reservations --}}

        <div class="section">
            <ul role="list" class="grid-default gap-5">
                @foreach ($properties as $property)
                    <a href="{{ route('host.properties.edit', $property->id) }}">
                        <li class="panel group fix-image-blur relative overflow-hidden p-0 transition hover:scale-110">
                            <div class="aspect-w-10 aspect-h-7 block w-full overflow-hidden bg-gray-100 focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 focus-within:ring-offset-gray-100">
                                <img src="/storage/{{ $property->photos->first()->path }}" alt="" class="pointer-events-none object-cover">
                                <button type="button" class="absolute inset-0 focus:outline-none">
                                    <span class="sr-only">View details for IMG_4985.HEIC</span>
                                </button>
                            </div>
                            <div class="flex items-center justify-between space-x-5 p-3">
                                <div class="flex flex-col truncate">
                                    <span class="text-link truncate text-base">{{ $property->name }}</span>
                                    <span class="text-muted truncate text-xs">{{ $property->address_street }}, {{ $property->address_city }} {{ $property->address_state }}, {{ $property->address_zip }}</span>
                                </div>
                                <div class="flex flex-none flex-col truncate text-right">
                                    <span class="text-base font-bold text-green-600">${{ $property->rate }}</span>
                                    <span class="text-muted truncate text-xs">per night</span>
                                </div>
                            </div>
                        </li>
                    </a>
                @endforeach
            </ul>
        </div>
    </div>
</div>
