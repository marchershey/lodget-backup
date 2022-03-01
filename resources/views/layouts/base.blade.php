<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @hasSection('browserTitle')
        <title>{{ $title }} - {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?{{ rand() }}">
    @livewireStyles
    <script src="{{ asset('js/app.js') }}?{{ rand() }}" defer></script>
</head>

<body class="h-full">
    <div class="fixed bottom-0 right-0 z-50 bg-white px-1 text-xs">
        <div class="sm:hidden">xs</div>
        <div class="hidden sm:block md:hidden">sm</div>
        <div class="hidden md:block lg:hidden">md</div>
        <div class="hidden lg:block xl:hidden">lg</div>
        <div class="hidden xl:block 2xl:hidden">xl</div>
        <div class="hidden 2xl:block">2xl</div>
    </div>

    {{ $slot }}

    @livewireScripts
    @stack('scripts')
</body>

</html>
