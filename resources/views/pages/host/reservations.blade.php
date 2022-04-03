    <div class="flex flex-col space-y-5" wire:init="load">
        {{-- Recent Reservations --}}
        <div class="section">
            <div class="panel hidden sm:block md:hidden lg:block" wire:ignore>
                <div id="calendar-container" class=""></div>
            </div>
            <div class="lg:hidden">
                <div class="bg-primary flex items-center justify-center space-x-5 rounded-lg p-5 text-center text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <circle cx="12" cy="12" r="9"></circle>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        <polyline points="11 12 12 12 12 16 13 16"></polyline>
                    </svg>
                    <span>View this page on a larger device to view the calendar!</span>
                </div>
            </div>
        </div>

        <div class="section">
            <x-heading>Reservations</x-heading>
            <div class="tables">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">Guest</th>
                            <th scope="col">Property</th>
                            <th scope="col">Dates</th>
                            <th scope="col">Status</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($reservations)

                            {{-- Pending Reservations --}}
                            <tr>
                                <th colspan="5" class="border-b !bg-gray-100">
                                    <span>Pending Reservations</span>
                                </th>
                            </tr>
                            @foreach ($reservations->where('status', 'pending') as $reservation)
                                <tr class="border-b border-gray-200 !bg-yellow-50">
                                    <td><span class="text-link">{{ $reservation->user->name }}</span></td>
                                    <td><a href="/host/properties/edit/{{ $reservation->property->id }}" class="text-link">{{ $reservation->property->name }}</span></td>
                                    <td>
                                        <div class="flex space-x-1">
                                            <span class="text-bold">{{ \Carbon\Carbon::parse($reservation->checkin_date)->format('M jS') }}</span>
                                            <span>to</span>
                                            <span class="text-bold">{{ \Carbon\Carbon::parse($reservation->checkout_date)->format('M jS') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-yellow">Pending</span>
                                    </td>
                                    <td class="w-[250px]">
                                        <div class="flex justify-end space-x-5" wire:loading.remove wire:target="approvePendingReservation({{ $reservation->id }}), rejectPendingReservation">
                                            <span class="text-link" wire:click="approvePendingReservation({{ $reservation->id }})">Approve</span>
                                            <span class="text-link" wire:click="rejectPendingReservation({{ $reservation->id }})">Reject</span>
                                            <span class="text-link">View</span>
                                        </div>
                                        <div wire:loading.flex class="items-center justify-end" wire:target="approvePendingReservation({{ $reservation->id }}), rejectPendingReservation">
                                            <svg class="h-[23px] w-[23px] animate-spin text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            {{-- Active Reservations --}}
                            <tr>
                                <th colspan="5" class="border-b !bg-gray-100">
                                    <span>Active Reservations</span>
                                </th>
                            </tr>
                            @foreach ($reservations->where('status', 'active') as $reservation)
                                <tr class="border-b border-gray-200">
                                    <td><span class="text-link">{{ $reservation->user->name }}</span></td>
                                    <td><span class="text-link">{{ $reservation->property->name }}</span></td>
                                    <td>
                                        <div class="flex space-x-1">
                                            <span class="text-bold">{{ \Carbon\Carbon::parse($reservation->checkin_date)->format('M jS') }}</span>
                                            <span>to</span>
                                            <span class="text-bold">{{ \Carbon\Carbon::parse($reservation->checkout_date)->format('M jS') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-green">Active</span>
                                    </td>
                                    <td class="flex justify-end space-x-7">
                                        <span class="text-link">View</span>
                                        <span class="text-link" wire:click="resetReservation({{ $reservation->id }})">Cancel</span>
                                    </td>
                                </tr>
                            @endforeach

                            {{-- Completed Reservations --}}
                            <tr>
                                <th colspan="5" class="border-b !bg-gray-100">
                                    <span>Other Reservations</span>
                                </th>
                            </tr>
                            @foreach ($reservations->where('status', '!=', 'pending')->where('status', '!=', 'active') as $reservation)
                                <tr class="border-b border-gray-200">
                                    <td><span class="text-link">{{ $reservation->user->name }}</span></td>
                                    <td><span class="text-link">{{ $reservation->property->name }}</span></td>
                                    <td>
                                        <div class="flex space-x-1">
                                            <span class="text-bold">{{ \Carbon\Carbon::parse($reservation->checkin_date)->format('M jS') }}</span>
                                            <span>to</span>
                                            <span class="text-bold">{{ \Carbon\Carbon::parse($reservation->checkout_date)->format('M jS') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($reservation->status == 'rejected')
                                            <span class="badge badge-gray">Rejected</span>
                                        @elseif($reservation->status == 'completed')
                                            <span class="badge badge-blue">Completed</span>
                                        @elseif($reservation->status == 'cancelled')
                                            <span class="badge badge-gray">Cancelled</span>
                                        @endif

                                    </td>
                                    <td class="flex justify-end space-x-7">
                                        <span class="text-link" wire:click="resetReservation({{ $reservation->id }})">View</span>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="animate-pulse">
                                <td>
                                    <div class="h-5 w-[100px] rounded bg-gray-200">
                                </td>
                                <td>
                                    <div class="h-5 w-[100px] rounded bg-gray-200">
                                </td>
                                <td>
                                    <div class="h-5 w-[100px] rounded bg-gray-200">
                                </td>
                                <td>
                                    <div class="h-5 w-[75px] rounded bg-gray-200">
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            window.onload = function() {
                let calendarEl = document.getElementById('calendar-container')
                window.calendar = new Calendar(calendarEl, {
                    ...defaultCalendarOptions,
                });

                calendar.render();
            }

            window.addEventListener('add-reservations-to-calendar', event => {
                var reservations = event.detail.reservations

                reservations.forEach(reservation => {
                    calendar.addEvent({
                        title: reservation.title,
                        start: reservation.start,
                        end: reservation.end,
                        color: reservation.color,
                        url: reservation.url,
                        allDay: true
                    });
                    console.log(reservation.end);
                });

            })
        </script>
    @endpush
