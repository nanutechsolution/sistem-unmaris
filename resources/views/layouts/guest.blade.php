<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'UNMARIS') }} - Auth</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center py-6 sm:pt-12">

        <!-- Logo -->
        <a href="/" class="mb-6 flex items-center">
            <img src="{{ asset('logo.png') }}" alt="UNMARIS Logo" class="w-24 h-24">
            <span class="ml-3 text-3xl font-bold text-unmaris-blue">UNMARIS</span>
        </a>

        <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-lg rounded-xl">
            {{-- <h2 class="text-2xl font-bold text-unmaris-blue mb-6 text-center">Selamat Datang</h2> --}}
            {{ $slot }}
        </div>

        <p class="mt-6 text-sm text-gray-500">
            &copy; {{ date('Y') }} Universitas Stela Maris Sumba. All rights reserved.
        </p>
    </div>
</body>
</html>
