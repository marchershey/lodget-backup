<x-layouts.host-dashboard>
    <x-slot:title>
        Dashboard
    </x-slot:title>

    <div class="section-spacing">
        {{-- Recent Reservations --}}
        <div class="section">
            <x-heading>Recent Reservations</x-heading>
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
</x-layouts.host-dashboard>
