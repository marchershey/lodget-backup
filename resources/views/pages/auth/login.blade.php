<div class="minimal-section-spacing">
    <div class="text-center">
        <h1 class="section-heading font-bold">Sign into your account</h1>
        <span class="text-muted text-xs">Enter your email address and password to continue</span>
    </div>
    <form wire:submit.prevent="login" class="minimal-section">
        <x-forms.text wireId="email" label="Email address" />
        <x-forms.text wireId="password" label="Password" inputType="password" />
        <div class="flex items-center justify-between">
            <div class="relative flex items-start">
                <label for="remember" class="relative flex items-start">
                    <div class="flex h-5 items-center">
                        <input checked id="remember" aria-describedby="remember-description" name="remember" type="checkbox" class="text-primary h-4 w-4 rounded border-gray-300">
                    </div>
                    <div class="ml-3 text-sm font-medium text-gray-700">
                        <span id="remember-description">Remember me</span>
                    </div>
                </label>
            </div>
            <div>
                <span class="text-link text-sm">Forgot your password?</span>
            </div>
        </div>
        <div class="flex flex-col space-y-5">
            <button type="submit" class="button button-blue w-full">Create account</button>
            <a href="{{ route('register') }}" class="button button-link w-full text-center">I don't have an account</a>
        </div>
    </form>
</div>
