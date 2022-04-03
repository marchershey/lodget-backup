<x-layouts.email>

    <p><strong>Hello {{ $user->firstName() }},</strong></p>

    <p>Your request to reserve <strong>{{ $property->name }}</strong> from <strong>{{ Carbon\Carbon::parse($reservation->checkin_date)->format('l, F jS') }}</strong> through <strong>{{ Carbon\Carbon::parse($reservation->checkout_date)->format('l, F jS') }}</strong> has been <strong>approved!</strong></p>

    <p>Below are the details you will need for your trip. You can also find your receipt below as well. If you have any questions, comments, or concerns during your stay with us, please feel free to reply to this email!</p>

    <hr>

    {{-- Details --}}
    <table class="mb">
        <tr>
            <td>Property:</td>
            <td><strong>{{ $property->name }}</strong></td>
        </tr>
        <tr>
            <td>Address:</td>
            <td><strong>{{ ucwords($property->address_street) }}, {{ ucwords($property->address_city) }}, {{ ucwords($property->address_state) }}, {{ $property->address_zip }}</strong></td>
        </tr>
        <tr>
            <td>Check In:</td>
            <td><strong><strong>{{ Carbon\Carbon::parse($reservation->checkin_date)->format('l, F jS Y') }}</strong></strong> at <strong>4:00 PM</strong></td>
        </tr>
        <tr>
            <td>Check Out:</td>
            <td><strong><strong>{{ Carbon\Carbon::parse($reservation->checkout_date)->format('l, F jS Y') }}</strong></strong> at <strong>11:00 AM</strong></td>
        </tr>
        <tr>
            <td>Instructions:</td>
            <td>
                <p></p>
            </td>
        </tr>
    </table>

    <hr>

    {{-- Receipt --}}
    <table class="mb">
        <tr>
            <td>${{ number_format($property->rate, 2) }} x {{ $reservation->nights }} nights</td>
            <td>${{ number_format($pricing_base ?? '0', 2) }}</td>
        </tr>
        @if ($pricing_fees)
            @foreach ($pricing_fees as $fee)
                <tr>
                    <td>{{ $fee['name'] }}</td>
                    <td>${{ number_format($fee['amount'], 2) }}</td>
                </tr>
            @endforeach
        @endif
        @if ($pricing_tax)
            <tr>
                <td>Taxes</td>
                <td>${{ number_format($pricing_tax, 2) }}</td>
            </tr>
        @endif
        <tr>
            <td><strong>Total</strong></td>
            <td><strong>${{ number_format($pricing_total, 2) }}</strong></td>
        </tr>
    </table>

    <hr>

    <p>
        Thank you for choosing {{ $property->name }},<br>
        Have a wonderful day!
    </p>

    <p>- <em>{{ config('app.name') }} Team</em></p>

    <x-slot name="pretext">We have received your reservation request!</x-slot>
    <x-slot name="footer">
        <p>
            {{ config('app.name') }}
        </p>
        <p>
            REFERENCE CODE: <strong>RES#{{ $reservation->id }}</strong>
        </p>
    </x-slot>
</x-layouts.email>
