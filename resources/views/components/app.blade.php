<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lumino Logistics 1</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="flex h-screen">
        {{-- Sidebar --}}
        <div>
            @include('components.includes.sidebar')
        </div>

        {{-- Main column --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            @include('components.includes.header')

            <main class="flex-1 overflow-y-auto px-4 py-4">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>