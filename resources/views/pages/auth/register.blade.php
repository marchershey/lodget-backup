<div class="minimal-section-spacing">
    <div class="text-center">
        <h1 class="section-heading font-bold">Create an account</h1>
        <span class="text-muted text-xs">Complete the form below to create your new account</span>
    </div>
    <form wire:submit.prevent="register" class="minimal-section">

        {{-- Email --}}
        <x-forms.text wireId="email" label="Email address" />

        {{-- Password --}}
        <div class="grid grid-cols-2 gap-3">
            <x-forms.text wireId="password" label="Password" inputType="password" />
            <x-forms.text wireId="password_confirmation" class="no-label" inputType="password" description="" placeholder="Password again " />
        </div>

        <hr>

        {{-- Name --}}
        <x-forms.text wireId="name" label="Full name" placeholder="First and last name" inputClass="capitalize placeholder:normal-case" />

        {{-- Phone and Birthdate --}}
        <div class="grid grid-cols-2 gap-3">
            <x-forms.text wireId="phone" label="Phone" placeholder="Phone number" inputClass="capitalize placeholder:normal-case phone" />
            <x-forms.text wireId="birthdate" label="Birth date" inputType="text" placeholder="mm/dd/yyyy" inputClass="date" />
        </div>

        {{-- Terms --}}
        <div class="flex items-center justify-between">
            <div class="relative flex items-start">
                <label for="terms" class="relative flex items-center">
                    <div class="flex h-4 items-center">
                        <input required checked wire:model="terms" id="terms" aria-describedby="terms-description" name="terms" type="checkbox" class="text-primary h-4 w-4 rounded border-gray-300">
                    </div>
                    <div class="ml-3">
                        <div id="terms-description" class="text-sm font-medium @error('terms') text-red-500 @else text-gray-700 @enderror">I have read and agree to the <span class="text-link">Terms</span> and <span class="text-link">Privacy Policy</span></div>
                    </div>
                </label>
            </div>
        </div>

        {{-- Disclaimer --}}
        <div>
            <p class="text-muted mt-2 text-xs">We get it, your privacy is very important to you, that's why we will never share your personal information with any third parties, <strong>whatsoever</strong>.</p>
        </div>

        {{-- Buttons --}}
        <div class="flex flex-col space-y-5">
            <button type="submit" class="button button-blue w-full">Create account</button>
            <a href="{{ route('login') }}" class="button button-link w-full py-0 text-center">I already have an account</a>
        </div>
    </form>
</div>
