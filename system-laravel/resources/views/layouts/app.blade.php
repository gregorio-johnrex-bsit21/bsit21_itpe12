<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'OJT Manager')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="bg-gray-50" x-data="{ sidebarOpen: false, activeTab: 'dashboard', taskModal: false }">

<div class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    @include('partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- Header --}}
        @include('partials.header')

        {{-- Main Content --}}
        <main class="flex-1 overflow-y-auto p-4 lg:p-6">
            <div class="space-y-6">
                @yield('content')
            </div>
        </main>

    </div>

</div>

@stack('scripts')
</body>
</html>