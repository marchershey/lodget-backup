<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-200">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @hasSection('browserTitle')
        <title>{{ $title }} - {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?{{ rand() }}">
    @livewireStyles
    <script src="{{ asset('js/app.js') }}?{{ rand() }}" defer></script>
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }

        // Whenever the user explicitly chooses light mode
        localStorage.theme = 'light'

        // Whenever the user explicitly chooses dark mode
        localStorage.theme = 'dark'

        // Whenever the user explicitly chooses to respect the OS preference
        localStorage.removeItem('theme')
    </script>
</head>

<body class="h-full text-gray-800">
    <livewire:toasts />
    <div class="fixed bottom-0 right-0 z-50 bg-red-500 px-1 text-xs text-white">
        <div class="sm:hidden">xs</div>
        <div class="hidden sm:block md:hidden">sm</div>
        <div class="hidden md:block lg:hidden">md</div>
        <div class="hidden lg:block xl:hidden">lg</div>
        <div class="hidden xl:block 2xl:hidden">xl</div>
        <div class="hidden 2xl:block">2xl</div>
    </div>

    {{ $slot }}

    @livewireScripts
    @toastScripts
    @stack('scripts')

    @if (app()->isLocal())
        <script src="{{ config('app.url') }}:3000/browser-sync/browser-sync-client.js"></script>
    @endif

    <script>
        // First we get the viewport height and we multiple it by 1% to get a value for a vh unit
        let vh = window.innerHeight * 0.01;
        // Then we set the value in the --vh custom property to the root of the document
        document.documentElement.style.setProperty('--vh', `${vh}px`);
    </script>
</body>

</html>
