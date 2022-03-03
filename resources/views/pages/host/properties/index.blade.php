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
            <div class="grid grid-cols-1 gap-10 lg:grid-cols-3">
                @foreach ($properties as $property)
                    <a href="{{ route('host.properties.edit', $property->id) }}">
                        <div class="panel group relative overflow-hidden">
                            <div class="-m-5">
                                <img class="aspect-video object-cover object-center" src="/storage/{{ $property->photos->first()->path }}" alt="">
                                <div class="flex items-center justify-between space-x-5 bg-white p-3">
                                    <div class="flex flex-col truncate">
                                        <span class="text-link truncate text-xl">{{ $property->name }}</span>
                                        <span class="text-muted truncate text-sm">{{ $property->address_street }}, {{ $property->address_city }} {{ $property->address_state }}, {{ $property->address_zip }}</span>
                                    </div>
                                    <div class="flex flex-none flex-col truncate text-right">
                                        <span class="text-xl font-bold text-green-600">${{ $property->rate }}</span>
                                        <span class="text-muted truncate text-sm">per night</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
