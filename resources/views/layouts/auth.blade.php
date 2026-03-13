<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login Admin - E-Fulus')</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon.png') }}">
<link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">

    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex font-jakarta h-screen">

    <div class="bg-white shadow-lg w-full flex flex-col md:flex-row overflow-hidden relative">

        <!-- Kiri: Gambar / Ilustrasi -->
        <div class="w-full md:w-1/2 flex flex-col items-center justify-center p-6 relative"
             style="background: linear-gradient(203.18deg, #01AB14 11.82%, #085410 85.47%);">
            @yield('left')
        </div>

        <!-- Kanan: Form / Konten -->
        <div class="w-full md:w-1/2 p-6 md:p-10 flex flex-col justify-center 
                    absolute inset-0 md:static bg-white z-10 rounded-t-xl md:rounded-none shadow-lg md:shadow-none">
            @yield('right')
        </div>
    </div>

</body>
</html>
