<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Archives') }}</title>

        <!-- Favicons -->
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/favicon.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">
        <meta name="theme-color" content="#ffffff">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        {{-- Full-screen background --}}
        <div class="min-h-screen bg-no-repeat bg-cover bg-center"
             style="background-image:url('{{ asset('images/backgrounds/authBG.jpg') }}');">

            {{-- Slight backdrop blur overlay --}}
            <div class="min-h-screen bg-white/5 backdrop-blur-sm flex items-center justify-center px-4">
                
                {{-- Apply login-style card for forgot & reset password --}}
                @if (request()->routeIs('password.request') || request()->routeIs('password.reset'))
                    <div class="w-full sm:max-w-md px-6 py-8 bg-[#fdfaf6] dark:bg-gray-800 shadow-lg rounded-xl border border-[#d9c7b8]">
                        {{ $slot }}
                    </div>
                @else
                    {{ $slot }}
                @endif

            </div>
        </div>
    </body>
</html>
