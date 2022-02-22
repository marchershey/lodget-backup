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
    {{ $slot }}

    @livewireScripts
    @stack('scripts')
</body>

</html>