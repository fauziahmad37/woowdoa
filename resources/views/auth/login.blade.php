@extends('layouts.auth')

@section('left')
@section('left')
<!-- <img src="{{ asset('images/login-ecoride.png') }}"
     alt="Electric Motorcycle"
     class="w-full mb-6"> -->

<!-- <h2 class="text-white text-2xl font-bold mb-2">Electric Motorcycle Technology</h2>
<p class="text-white text-center">
    Transforming electric motorcycles that redefine riding sport design for all lifestyles.
</p> -->
@endsection
<!--  -->
@section('right')
<img src="{{ asset('images/logo-ecoride-login.png') }}" alt="Logo Ecoride" class="mx-auto mb-10">
<h2 class="text-3xl font-medium text-gray-800 mb-6">Masuk Akun Admin</h2>
<p class="text-gray-500 mb-6">Kelola segala aktivitas yang terdapat pada WooWEcoRide dan lihat perkembangannya</p>

<form action="{{ route('login') }}" method="POST" class="space-y-4">
    @csrf
    <div>
        <label for="login" class="block text-gray-700 mb-2">
            Username  <span class="text-red-500">*</span>
        </label>
        <!-- <input id="login" class="block mt-1 w-full rounded-lg border @error('login') border-red-500 @enderror"
               type="text" name="login" value="{{ old('login') }}" required autofocus placeholder="Email atau Nomor HP" /> -->
<input id="username"
       class="block mt-1 w-full rounded-lg border @error('username') border-red-500 @enderror"
       type="text"
       name="username"
       value="{{ old('username') }}"
       required
       autofocus
       placeholder="Username" />

@error('username')
<div class="mt-2 p-2 bg-red-100 border border-red-400 text-red-700 rounded">
    {{ $message }}
</div>
@enderror

    </div>


    <div>
        <label for="login" class="block text-gray-700 mb-2">
            Password  <span class="text-red-500">*</span>
        </label>

<input id="password"
       class="block mt-1 w-full rounded-lg border @error('password') border-red-500 @enderror"
       type="password"
       name="password"
       required
       placeholder="Password" />

@error('password')
<div class="mt-2 p-2 bg-red-100 border border-red-400 text-red-700 rounded">
    {{ $message }}
</div>
@enderror

    </div>

    <button type="submit"
            class="w-full text-white py-2 rounded-lg transition hover:brightness-90"
            style="background: linear-gradient(203.18deg, #01AB14 11.82%,#085410 85.47%);">
        Masuk
    </button>
</form>


<div class="my-4 flex items-center text-gray-400">
    <div class="flex-grow border-t border-gray-300"></div>
    <span class="px-3 text-sm">Atau masuk dengan</span>
    <div class="flex-grow border-t border-gray-300"></div>
</div>


<button class="w-full rounded-lg border border-gray-300  py-2 flex items-center justify-center  hover:bg-gray-100 transition">
    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5 mr-2">
    Akun Google
</button>

<!-- <p class="mt-6 text-center text-gray-500">
    Belum memiliki akun? <a href="{{ route('register') }}" class="text-orange-500 hover:underline">Daftar Akun</a>
</p> -->

<p class="mt-16 text-center text-gray-400 text-sm">
    <a href="#" class="inline-flex items-center gap-2 hover:underline" style="color:#F37022;">
        <img src="{{ asset('images/hubungi-kami.png') }}" alt="Bantuan" class="w-5 h-5">
        Bantuan WooWEcoRide
    </a>
</p>

@endsection


