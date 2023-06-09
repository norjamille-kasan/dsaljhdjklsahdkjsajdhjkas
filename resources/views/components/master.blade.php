<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @wireUiScripts
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="h-full bg-gray-50 font-sans antialiased">
        <x-notifications />
        <x-dialog />
       {{ $slot }}
       @livewireScripts
       @livewireChartsScripts
       @stack('scripts')
    </body>
</html>
