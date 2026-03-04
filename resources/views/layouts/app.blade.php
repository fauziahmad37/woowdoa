<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WooWDoa</title>

    {{-- PWA --}}
    {{-- <link rel="manifest" href="{{ asset('pwa.json') }}">
    <meta name="theme-color" content="#0d6efd">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192x192.png') }}"> --}}

    <script src="//unpkg.com/alpinejs" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Mobile View Body */
        @media (max-width: 425px) {
            body {
                display: block !important;
            }
        }
    </style>

     @yield('styles')
</head>

{{-- <body class="min-h-screen grid grid-cols-[250px_1fr]"> --}}

<body
    x-data="{
        open: true,
        isMobile: window.innerWidth < 768,
        toggleSidebar() {
            this.open = !this.open
        }
    }"
    x-init="window.addEventListener('resize', () => isMobile = window.innerWidth < 768)"
    class="min-h-screen flex "
>
    <!-- Sidebar Menu (full height) -->
  <aside
    class="hidden md:block bg-white shadow-md transition-all duration-300 overflow-hidden transition-transform duration-300 ease-in-out"
    :class="open ? 'w-[250px]' : 'w-0'"
>
    <div x-show="open" class="w-[250px] h-full">
        @include('layouts.sidebar')
    </div>
</aside>

    <!-- Sidebar (Mobile) -->
    <div class="fixed inset-0 z-40 flex md:hidden" x-show="open"
        x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-black bg-opacity-50" @click="sidebarOpen = false"></div>

        <!-- Sidebar Content -->
       <aside
    class="bg-white shadow-md transition-all duration-300 overflow-hidden"
    :class="open ? 'w-[250px]' : 'w-0'"
>
    <div x-show="open" class="w-[250px]">
        @include('layouts.sidebar')
    </div>
</aside>
    </div>

    <!-- Konten Wrapper (kolom konten + header + footer) -->
    <div class="flex-1 flex flex-col">

        <!-- Header -->
        <header class="bg-white text-gray-800 p-4 sticky top-0  shadow flex justify-between items-center">

           @include('layouts.navigation')

        </header>

        <!-- Konten Tengah -->
        <main class="bg-white p-6 flex-1 overflow-y-auto">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white text-gray-800 text-center p-4">
            <p>&copy; 2025 Semua Hak Dilindungi</p>
        </footer>

    </div>

    @yield('scripts')


    {{-- PWA --}}
    <script>
        // if ("serviceWorker" in navigator) {
        //     window.addEventListener("load", function() {
        //         navigator.serviceWorker.register("/sw.js")
        //             .then(reg => console.log("Service Worker registered", reg))
        //             .catch(err => console.log("Service Worker failed", err));
        //     });
        // }
    </script>
</body>

</html>
