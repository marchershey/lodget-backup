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
                        <!-- Odd row -->
                        <tr>
                            <td><span class="text-link">John Smith</span></td>
                            <td><span class="text-link">Ohana Burnside</span></td>
                            <td>
                                <div class="flex space-x-1">
                                    <span class="text-bold">Aug 24th</span>
                                    <span>to</span>
                                    <span class="text-bold">Aug 25th</span>
                                </div>
                            </td>
                            <td><span class="badge badge-green">Approved</span></td>
                            <td><span class="text-link">View</span></td>
                        </tr>
                        <tr>
                            <td><span class="text-link">John Smith</span></td>
                            <td><span class="text-link">Ohana Burnside</span></td>
                            <td>
                                <div class="flex space-x-1">
                                    <span class="text-bold">Aug 24th</span>
                                    <span>to</span>
                                    <span class="text-bold">Aug 25th</span>
                                </div>
                            </td>
                            <td><span class="badge badge-green">Approved</span></td>
                            <td><span class="text-link">View</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            window.onload = function() {
                let calendarEl = document.getElementById('calendar-container')
                let calendarEvents = {
                    resourceAreaHeaderContent: 'Properties',
                    resources: [ //
                        {
                            id: 'ohana-burnside',
                            title: 'Ohana Burnside',
                            eventColor: "#2d3748"
                        },
                        {
                            id: 'property 2',
                            title: 'property 2',
                            eventColor: "#2d3748"
                        }
                    ],
                    events: [ //
                        {
                            id: '3',
                            start: '2022-02-28T16:00:00',
                            end: '2022-02-29T11:00:00',
                            title: 'Ohana Burnside: Marc Hershey',
                            url: '/reservations/1',
                            resourceId: 'ohana-burnside',
                        },
                        {
                            id: '4',
                            start: '2022-02-14T16:00:00',
                            end: '2022-02-16T11:00:00',
                            title: 'Marc Hershey 2',
                            url: '/reservations/2',
                        },
                    ],
                }
                window.calendar = new Calendar(calendarEl, {
                    ...defaultCalendarOptions,
                    ...calendarEvents
                });

                calendar.render();
            }

            window.addEventListener('add-reservations-to-calendar', event => {
                var reservations = event.detail.reservations

                reservations.forEach(reservation => {
                    console.log(reservation);
                    calendar.addEvent({
                        title: reservation.property_name + ': ' + reservation.guest_name,
                        start: reservation.checkin_date,
                        end: reservation.checkout_date,
                        color: reservation.color,
                        allDay: true
                    });
                });

            })
        </script>
    @endpush
