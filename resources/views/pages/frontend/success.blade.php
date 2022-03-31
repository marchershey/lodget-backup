<div class="minimal-container">
    <div class="minimal-panel">
        <div class="flex flex-col space-y-5">
            <div>
                <h1 class="text-center text-xl font-semibold">Success!</h1>
                <p class="text-center">You have successfully reserved <span class="font-medium">{{ $reservation->property->name }}</span> for <span class="font-medium">{{ $reservation->nights }} nights</span>.</p>
            </div>
            <hr>
            <p class="text-muted text-sm">You will be receiving an email shortly with your receipt, as well as details about your reservation. You may also view your reservation on the <span class="text-link">Guest Portal</span>.</p>
            <p class="text-muted text-sm">Thank you for choosing {{ $reservation->property->name }}, have a wonderful day!</p>
        </div>
    </div>
</div>
