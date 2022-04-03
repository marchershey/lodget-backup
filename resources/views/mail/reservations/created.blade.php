<x-layouts.email>

    <p><strong>Hello {{ $user->firstName() }},</strong></p>

    <p>Your request to reserve <strong>{{ $property->name }}</strong> from <strong>{{ Carbon\Carbon::parse($reservation->checkin_date)->format('l, F jS') }}</strong> through <strong>{{ Carbon\Carbon::parse($reservation->checkout_date)->format('l, F jS') }}</strong> has been received.</p>

    <p>Within the next 48 hours, you will receive another email with the status of your reservation.</p>

    <p>If you have any questions, please feel free to responed to this email. </p>

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
