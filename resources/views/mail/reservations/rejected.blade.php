<x-layouts.email>

    <p><strong>Hello {{ $user->firstName() }},</strong></p>

    <p>Your request to reserve <strong>{{ $property->name }}</strong> from <strong>{{ Carbon\Carbon::parse($reservation->checkin_date)->format('l, F jS') }}</strong> through <strong>{{ Carbon\Carbon::parse($reservation->checkout_date)->format('l, F jS') }}</strong> has been <strong>rejected</strong>.</p>

    <p>Rest assured, your payment has been cancelled. Your funds will be returned to you by {{ Carbon\Carbon::today()->addDays(7)->format('F jS') }}. If you have any questions, please feel free to reply to this email.</p>

    <p>Thank you and ave a wonderful rest of your day,</p>

    <p>- <em>{{ config('app.name') }} Team</em></p>

    <x-slot name="pretext">We're sorry to inform you that your reservation has been rejected.</x-slot>
    <x-slot name="footer">
        <p>
            {{ config('app.name') }}
        </p>
        <p>
            REFERENCE CODE: <strong>RES#{{ $reservation->id }}</strong>
        </p>
    </x-slot>
</x-layouts.email>
