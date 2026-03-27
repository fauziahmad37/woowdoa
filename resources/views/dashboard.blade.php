@extends('layouts.app')

@section('content')
<div class="py-6">
<div class="container mx-auto w-full px-4">
<div x-data="{
    tab: new URLSearchParams(window.location.search).get('tab') || 'transaksi'
}">
    
<div class="container mx-auto w-full px-4 ">

<!-- TAB MENU -->
<div class="flex flex-wrap gap-2 mb-6 pb-2 mb-4">

<button 
@click="
    tab='transaksi';
    window.history.replaceState(null, '', '?tab=transaksi')
"
:class="tab==='transaksi' ? 'bg-green-600 text-white' : 'bg-gray-100'"
class="px-4 py-2 rounded-lg text-sm font-semibold">
Dashboard Transaksi
</button>

<button 
@click="
    tab='pesantren';
    window.history.replaceState(null, '', '?tab=pesantren')
"
:class="tab==='pesantren' ? 'bg-green-600 text-white' : 'bg-gray-100'"
class="px-4 py-2 rounded-lg text-sm font-semibold">
Dashboard Pesantren
</button>

<button 
@click="
    tab='merchant';
    window.history.replaceState(null, '', '?tab=merchant')
"
:class="tab==='merchant' ? 'bg-green-600 text-white' : 'bg-gray-100'"
class="px-4 py-2 rounded-lg text-sm font-semibold">
Dashboard Merchant
</button>

</div>

<!-- dashboard transaksi -->
<div x-show="tab === 'transaksi'">

<form method="GET" class="flex flex-wrap gap-2 items-end mt-6">

<input type="hidden" name="tab" value="transaksi">

<div>
<input type="date" name="start_date"
value="{{ request('start_date') }}"
class="border rounded px-3 py-2">
</div>

<div>
<label class="text-sm">End Date</label>
<input type="date" name="end_date"
value="{{ request('end_date') }}"
class="border rounded px-3 py-2">
</div>

<button type="submit"
class="bg-green-600 text-white px-4 py-2 rounded">
Filter
</button>

<a href="{{ url('/dashboard?tab=transaksi') }}"
class="bg-gray-200 text-gray-700 px-4 py-2 rounded">
Reset
</a>

</form>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

<!-- Total Transaksi -->
<div class="rounded-xl  text-gray-800 p-6 shadow-md w-full" style="background-color: #dcfce7;">
<div class="flex items-center justify-between">

<h1 class="text-4xl font-bold">
{{ number_format($totalTransaksi) }}
</h1>

<div class="w-10 h-10 flex items-center justify-center rounded-lg bg-green-600 p-2">
  <svg xmlns="http://www.w3.org/2000/svg" fill="#dcfce7" viewBox="0 0 576 512"><path d="M271.06,144.3l54.27,14.3a8.59,8.59,0,0,1,6.63,8.1c0,4.6-4.09,8.4-9.12,8.4h-35.6a30,30,0,0,1-11.19-2.2c-5.24-2.2-11.28-1.7-15.3,2l-19,17.5a11.68,11.68,0,0,0-2.25,2.66,11.42,11.42,0,0,0,3.88,15.74,83.77,83.77,0,0,0,34.51,11.5V240c0,8.8,7.83,16,17.37,16h17.37c9.55,0,17.38-7.2,17.38-16V222.4c32.93-3.6,57.84-31,53.5-63-3.15-23-22.46-41.3-46.56-47.7L282.68,97.4a8.59,8.59,0,0,1-6.63-8.1c0-4.6,4.09-8.4,9.12-8.4h35.6A30,30,0,0,1,332,83.1c5.23,2.2,11.28,1.7,15.3-2l19-17.5A11.31,11.31,0,0,0,368.47,61a11.43,11.43,0,0,0-3.84-15.78,83.82,83.82,0,0,0-34.52-11.5V16c0-8.8-7.82-16-17.37-16H295.37C285.82,0,278,7.2,278,16V33.6c-32.89,3.6-57.85,31-53.51,63C227.63,119.6,247,137.9,271.06,144.3ZM565.27,328.1c-11.8-10.7-30.2-10-42.6,0L430.27,402a63.64,63.64,0,0,1-40,14H272a16,16,0,0,1,0-32h78.29c15.9,0,30.71-10.9,33.25-26.6a31.2,31.2,0,0,0,.46-5.46A32,32,0,0,0,352,320H192a117.66,117.66,0,0,0-74.1,26.29L71.4,384H16A16,16,0,0,0,0,400v96a16,16,0,0,0,16,16H372.77a64,64,0,0,0,40-14L564,377a32,32,0,0,0,1.28-48.9Z"/></svg>

</div>


</div>

<h1 class="text-md font-bold mt-2">Jumlah Transaksi</h1>
<p class="text-sm text-gray-500 mt-1">Total transaksi seluruh waktu</p>
</div>


<!-- Value Transaksi -->
<div class="rounded-xl  text-gray-800 p-6 shadow-md w-full" style="background-color: #dcfce7;">
<div class="flex items-center justify-between">

<h1 class="text-4xl font-bold">
Rp {{ number_format($totalValue) }}
</h1>

<div class="w-10 h-10 flex items-center justify-center rounded-lg bg-green-600 p-2">
<svg xmlns="http://www.w3.org/2000/svg" fill="#dcfce7" viewBox="0 0 640 512"><path d="M608 64H32C14.33 64 0 78.33 0 96v320c0 17.67 14.33 32 32 32h576c17.67 0 32-14.33 32-32V96c0-17.67-14.33-32-32-32zM48 400v-64c35.35 0 64 28.65 64 64H48zm0-224v-64h64c0 35.35-28.65 64-64 64zm272 176c-44.19 0-80-42.99-80-96 0-53.02 35.82-96 80-96s80 42.98 80 96c0 53.03-35.83 96-80 96zm272 48h-64c0-35.35 28.65-64 64-64v64zm0-224c-35.35 0-64-28.65-64-64h64v64z"/></svg>
</div>


</div>

<h1 class="text-md font-bold mt-2">Value Transaksi</h1>
<p class="text-sm text-gray-500 mt-1">Total nilai transaksi</p>
</div>


<!-- Transaksi Bulan Ini -->
<div class="rounded-xl  text-gray-800 p-6 shadow-md w-full" style="background-color: #dcfce7;">
<div class="flex items-center justify-between">

<h1 class="text-4xl font-bold">
{{ number_format($transaksiBulanIni) }}
</h1>

<div class="w-10 h-10 flex items-center justify-center rounded-lg bg-green-600 p-2">
  <svg xmlns="http://www.w3.org/2000/svg" fill="#dcfce7" viewBox="0 0 448 512"><path d="M0 464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V192H0v272zm320-196c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12h-40c-6.6 0-12-5.4-12-12v-40zm0 128c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12h-40c-6.6 0-12-5.4-12-12v-40zM192 268c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12h-40c-6.6 0-12-5.4-12-12v-40zm0 128c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12h-40c-6.6 0-12-5.4-12-12v-40zM64 268c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12H76c-6.6 0-12-5.4-12-12v-40zm0 128c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12H76c-6.6 0-12-5.4-12-12v-40zM400 64h-48V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H160V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H48C21.5 64 0 85.5 0 112v48h448v-48c0-26.5-21.5-48-48-48z"/></svg>
</div>


</div>

<h1 class="text-md font-bold mt-2">Transaksi Bulan Ini</h1>
<p class="text-sm text-gray-500 mt-1">Jumlah transaksi bulan berjalan</p>
</div>


<!-- Value Bulan Ini -->
<div class="rounded-xl  text-gray-800 p-6 shadow-md w-full" style="background-color: #dcfce7;">
<div class="flex items-center justify-between">

<h1 class="text-4xl font-bold">
Rp {{ number_format($valueBulanIni) }}
</h1>

<div class="w-10 h-10 flex items-center justify-center rounded-lg bg-green-600 p-2">
<svg xmlns="http://www.w3.org/2000/svg" fill="#dcfce7" viewBox="0 0 448 512"><path d="M436 160H12c-6.627 0-12-5.373-12-12v-36c0-26.51 21.49-48 48-48h48V12c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v52h128V12c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v52h48c26.51 0 48 21.49 48 48v36c0 6.627-5.373 12-12 12zM12 192h424c6.627 0 12 5.373 12 12v260c0 26.51-21.49 48-48 48H48c-26.51 0-48-21.49-48-48V204c0-6.627 5.373-12 12-12zm333.296 95.947l-28.169-28.398c-4.667-4.705-12.265-4.736-16.97-.068L194.12 364.665l-45.98-46.352c-4.667-4.705-12.266-4.736-16.971-.068l-28.397 28.17c-4.705 4.667-4.736 12.265-.068 16.97l82.601 83.269c4.667 4.705 12.265 4.736 16.97.068l142.953-141.805c4.705-4.667 4.736-12.265.068-16.97z"/></svg>
</div>

</div>

<h1 class="text-md font-bold mt-2">Value Bulan Ini</h1>
<p class="text-sm text-gray-500 mt-1">Total nilai transaksi bulan berjalan</p>
</div>

</div>

<!-- chart -->
<div class="bg-white rounded-xl p-4 shadow mt-6">

<h4 class="font-bold text-gray-700 mb-4">
Grafik Transaksi Bulanan
</h4>

<div id="chart-transaksi" class="w-full h-[350px]"></div>


</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

    <!-- kiri -->
    <div class="bg-white rounded-xl p-4 shadow">
        <h4 class="font-bold mb-3">Top 10 Saldo Santri</h4>
        <div id="chart-top-saldo" class="h-[350px]"></div>
    </div>

    <!-- kanan -->
    <div class="bg-white rounded-xl p-4 shadow">
        <h4 class="font-bold mb-3">Top 10 Belanja Santri</h4>
        <div id="chart-top-belanja" class="h-[350px]"></div>
    </div>

</div>

<div class="bg-white rounded-xl p-4 shadow mt-6">

<h4 class="font-bold text-gray-700 mb-4">
Persentase Siswa Topup Bulan Ini
</h4>

<div id="chart-siswa-topup" class="w-full h-[350px]"></div>

</div>

</div>
<!-- end dashboard transaksi -->

<!-- dashboard pesantren -->
<div x-show="tab === 'pesantren'">
    
  
<!-- grid santri -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">

<!-- Total Santri -->
<div class="rounded-xl bg-white text-gray-800 p-6 shadow-md w-full">
<div class="flex items-center justify-between">

<h1 class="text-4xl font-bold">
{{ number_format($totalSantri) }}
</h1>

<div class="w-10 h-10 flex items-center justify-center rounded-lg bg-green-100 p-2">

<svg xmlns="http://www.w3.org/2000/svg" fill="#029e13" class="w-8 h-8" viewBox="0 0 640 512"><path d="M96 224c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm448 0c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm32 32h-64c-17.6 0-33.5 7.1-45.1 18.6 40.3 22.1 68.9 62 75.1 109.4h66c17.7 0 32-14.3 32-32v-32c0-35.3-28.7-64-64-64zm-256 0c61.9 0 112-50.1 112-112S381.9 32 320 32 208 82.1 208 144s50.1 112 112 112zm76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C179.6 288 128 339.6 128 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2zm-223.7-13.4C161.5 263.1 145.6 256 128 256H64c-35.3 0-64 28.7-64 64v32c0 17.7 14.3 32 32 32h65.9c6.3-47.4 34.9-87.3 75.2-109.4z"/></svg>
</div>

</div>

<h1 class="text-md font-bold mt-2">Total Santri</h1>
<p class="text-sm text-gray-500 mt-1">Jumlah seluruh santri</p>
</div>


<!-- Santri Laki -->
<div class="rounded-xl bg-white text-gray-800 p-6 shadow-md w-full">
<div class="flex items-center justify-between">

<h1 class="text-4xl font-bold">
{{ number_format($santriLaki) }}
</h1>

<div class="w-10 h-10 flex items-center justify-center rounded-lg bg-green-100 p-2">

<svg xmlns="http://www.w3.org/2000/svg" fill="#029e13" class="w-8 h-8"  viewBox="0 0 192 512"><path d="M96 0c35.346 0 64 28.654 64 64s-28.654 64-64 64-64-28.654-64-64S60.654 0 96 0m48 144h-11.36c-22.711 10.443-49.59 10.894-73.28 0H48c-26.51 0-48 21.49-48 48v136c0 13.255 10.745 24 24 24h16v136c0 13.255 10.745 24 24 24h64c13.255 0 24-10.745 24-24V352h16c13.255 0 24-10.745 24-24V192c0-26.51-21.49-48-48-48z"/></svg>
</div>

</div>

<h1 class="text-md font-bold mt-2">Santri Laki-laki</h1>
<p class="text-sm text-gray-500 mt-1">Jumlah santri laki-laki</p>
</div>


<!-- Santri Perempuan -->
<div class="rounded-xl bg-white text-gray-800 p-6 shadow-md w-full">
<div class="flex items-center justify-between">

<h1 class="text-4xl font-bold">
{{ number_format($santriPerempuan) }}
</h1>

<div class="w-10 h-10 flex items-center justify-center rounded-lg bg-green-100 p-2">

<svg xmlns="http://www.w3.org/2000/svg" fill="#029e13" class="w-8 h-8"  viewBox="0 0 256 512">
  <path d="M128 0c35.346 0 64 28.654 64 64s-28.654 64-64 64c-35.346 0-64-28.654-64-64S92.654 0 128 0m119.283 354.179l-48-192A24 24 0 0 0 176 144h-11.36c-22.711 10.443-49.59 10.894-73.28 0H80a24 24 0 0 0-23.283 18.179l-48 192C4.935 369.305 16.383 384 32 384h56v104c0 13.255 10.745 24 24 24h32c13.255 0 24-10.745 24-24V384h56c15.591 0 27.071-14.671 23.283-29.821z"/></svg>
</svg>
</div>

</div>

<h1 class="text-md font-bold mt-2">Santri Perempuan</h1>
<p class="text-sm text-gray-500 mt-1">Jumlah santri perempuan</p>
</div>


<!-- Santri Aktif -->
<div class="rounded-xl bg-white text-gray-800 p-6 shadow-md w-full">
<div class="flex items-center justify-between">

<h1 class="text-4xl font-bold">
{{ number_format($santriAktif) }}
</h1>

<div class="w-10 h-10 flex items-center justify-center rounded-lg bg-green-100 p-2">
<svg xmlns="http://www.w3.org/2000/svg" fill="#029e13" class="w-8 h-8" viewBox="0 0 640 512"><path d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4zm323-128.4l-27.8-28.1c-4.6-4.7-12.1-4.7-16.8-.1l-104.8 104-45.5-45.8c-4.6-4.7-12.1-4.7-16.8-.1l-28.1 27.9c-4.7 4.6-4.7 12.1-.1 16.8l81.7 82.3c4.6 4.7 12.1 4.7 16.8.1l141.3-140.2c4.6-4.7 4.7-12.2.1-16.8z"/></svg>
</div>

</div>

<h1 class="text-md font-bold mt-2">Santri Aktif</h1>
<p class="text-sm text-gray-500 mt-1">Santri yang masih aktif</p>
</div>

</div>

<form method="GET" class="mb-4 flex gap-2 mt-4">
    
    <input type="hidden" name="tab" value="pesantren"> 

    <select name="tahun_ajaran_id" id="angkatan" class="border p-2 rounded">
        <option value="">Pilih Angkatan</option>
        @foreach($angkatan as $a)
            <option value="{{ $a->id }}" {{ $tahunAjaranId == $a->id ? 'selected' : '' }}>
                {{ $a->tahun_ajaran }}
            </option>
        @endforeach
    </select>

    <select name="class_id" id="kelas" class="border p-2 rounded">
        <option value="">Pilih Kelas</option>
    </select>

    <button class="bg-green-600 text-white px-4 rounded">Filter</button>
</form>


<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">

<!-- Total -->
<div class="rounded-xl bg-blue-50 p-6 shadow-md">
    <h1 class="text-3xl font-bold">
        {{ number_format($tahunAjaranId ? $filterTotalSantri : $totalSantri) }}
    </h1>
    <p class="text-sm mt-2">
        {{ $tahunAjaranId ? 'Total Santri (Filter)' : 'Total Santri' }}
    </p>
</div>

<!-- Laki -->
<div class="rounded-xl bg-blue-50 p-6 shadow-md">
    <h1 class="text-3xl font-bold">
        {{ number_format($tahunAjaranId ? $filterSantriLaki : $santriLaki) }}
    </h1>
    <p class="text-sm mt-2">Laki-laki</p>
</div>

<!-- Perempuan -->
<div class="rounded-xl bg-blue-50 p-6 shadow-md">
    <h1 class="text-3xl font-bold">
        {{ number_format($tahunAjaranId ? $filterSantriPerempuan : $santriPerempuan) }}
    </h1>
    <p class="text-sm mt-2">Perempuan</p>
</div>

<!-- Aktif -->
<div class="rounded-xl bg-blue-50 p-6 shadow-md">
    <h1 class="text-3xl font-bold">
        {{ number_format($tahunAjaranId ? $filterSantriAktif : $santriAktif) }}
    </h1>
    <p class="text-sm mt-2">Aktif</p>
</div>

</div>
<!-- end grid santri -->

<!-- grid ustad -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">


<!-- Total ustad dan ustazah -->
<!-- <div class="rounded-xl bg-white text-gray-800 p-6 shadow-md w-full">
<div class="flex items-center justify-between">

<h1 class="text-4xl font-bold">
{{ number_format($totalTeacher ) }}
</h1>

<div class="w-10 h-10 flex items-center justify-center rounded-lg bg-green-100 p-2">

<svg xmlns="http://www.w3.org/2000/svg" fill="#029e13" class="w-8 h-8" viewBox="0 0 640 512"><path d="M96 224c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm448 0c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm32 32h-64c-17.6 0-33.5 7.1-45.1 18.6 40.3 22.1 68.9 62 75.1 109.4h66c17.7 0 32-14.3 32-32v-32c0-35.3-28.7-64-64-64zm-256 0c61.9 0 112-50.1 112-112S381.9 32 320 32 208 82.1 208 144s50.1 112 112 112zm76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C179.6 288 128 339.6 128 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2zm-223.7-13.4C161.5 263.1 145.6 256 128 256H64c-35.3 0-64 28.7-64 64v32c0 17.7 14.3 32 32 32h65.9c6.3-47.4 34.9-87.3 75.2-109.4z"/></svg>
</div>

</div>

<h1 class="text-md font-bold mt-2">Total Ustadzh & Ustadzah</h1>
<p class="text-sm text-gray-500 mt-1">Jumlah seluruh santri</p>
</div> -->


<!-- Ustadzh -->
<!-- <div class="rounded-xl bg-white text-gray-800 p-6 shadow-md w-full">
<div class="flex items-center justify-between">

<h1 class="text-4xl font-bold">
{{ number_format($teacherLaki ) }}
</h1>

<div class="w-10 h-10 flex items-center justify-center rounded-lg bg-green-100 p-2">

<svg xmlns="http://www.w3.org/2000/svg" fill="#029e13" class="w-8 h-8"  viewBox="0 0 192 512"><path d="M96 0c35.346 0 64 28.654 64 64s-28.654 64-64 64-64-28.654-64-64S60.654 0 96 0m48 144h-11.36c-22.711 10.443-49.59 10.894-73.28 0H48c-26.51 0-48 21.49-48 48v136c0 13.255 10.745 24 24 24h16v136c0 13.255 10.745 24 24 24h64c13.255 0 24-10.745 24-24V352h16c13.255 0 24-10.745 24-24V192c0-26.51-21.49-48-48-48z"/></svg>
</div>

</div>

<h1 class="text-md font-bold mt-2">Ustadzh</h1>
<p class="text-sm text-gray-500 mt-1">Jumlah Ustadzh</p>
</div> -->


<!-- Ustadzah -->
<!-- <div class="rounded-xl bg-white text-gray-800 p-6 shadow-md w-full">
<div class="flex items-center justify-between">

<h1 class="text-4xl font-bold">
{{ number_format($teacherPerempuan ) }}
</h1>

<div class="w-10 h-10 flex items-center justify-center rounded-lg bg-green-100 p-2">

<svg xmlns="http://www.w3.org/2000/svg" fill="#029e13" class="w-8 h-8"  viewBox="0 0 256 512">
  <path d="M128 0c35.346 0 64 28.654 64 64s-28.654 64-64 64c-35.346 0-64-28.654-64-64S92.654 0 128 0m119.283 354.179l-48-192A24 24 0 0 0 176 144h-11.36c-22.711 10.443-49.59 10.894-73.28 0H80a24 24 0 0 0-23.283 18.179l-48 192C4.935 369.305 16.383 384 32 384h56v104c0 13.255 10.745 24 24 24h32c13.255 0 24-10.745 24-24V384h56c15.591 0 27.071-14.671 23.283-29.821z"/></svg>
</svg>
</div>

</div>

<h1 class="text-md font-bold mt-2">Ustadzah</h1>
<p class="text-sm text-gray-500 mt-1">Jumlah Ustadzah</p>
</div> -->


<!-- Ustadzh aktif -->
<!-- <div class="rounded-xl bg-white text-gray-800 p-6 shadow-md w-full">
<div class="flex items-center justify-between">

<h1 class="text-4xl font-bold">
{{ number_format($teacherAktif ) }}
</h1>

<div class="w-10 h-10 flex items-center justify-center rounded-lg bg-green-100 p-2">
<svg xmlns="http://www.w3.org/2000/svg" fill="#029e13" class="w-8 h-8" viewBox="0 0 640 512"><path d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4zm323-128.4l-27.8-28.1c-4.6-4.7-12.1-4.7-16.8-.1l-104.8 104-45.5-45.8c-4.6-4.7-12.1-4.7-16.8-.1l-28.1 27.9c-4.7 4.6-4.7 12.1-.1 16.8l81.7 82.3c4.6 4.7 12.1 4.7 16.8.1l141.3-140.2c4.6-4.7 4.7-12.2.1-16.8z"/></svg>
</div>

</div>

<h1 class="text-md font-bold mt-2">Ustadzh & Ustadzah Aktif</h1>
<p class="text-sm text-gray-500 mt-1">Ustadzh & Ustadzah yang masih aktif</p>
</div> -->

</div>
<!-- end grid ustad -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

<div class="bg-white rounded-xl shadow p-4">
<h5 class="font-semibold mb-3">Gender Santri</h5>
<div id="chartSantri"></div>
</div>

<!-- <div class="bg-white rounded-xl shadow p-4">
<h5 class="font-semibold mb-3">Gender Teacher</h5>
<div id="chartTeacher"></div>
</div> -->


<div class="bg-white rounded-xl shadow p-4">
<h5 class="font-semibold mb-3">Angkatan dan Kelas</h5>
<div id="chart-angkatan"></div>
</div> 

</div>


</div>

<!-- end dashboard pesantren -->

<!-- dashboard merchant -->

<div x-show="tab === 'merchant'">
  
<form method="GET" class="flex flex-wrap gap-2 items-end mt-6">

<input type="hidden" name="tab" value="merchant">

<div>
<input type="date" name="start_date"
value="{{ request('start_date') }}"
class="border rounded px-3 py-2">
</div>

<div>
<input type="date" name="end_date"
value="{{ request('end_date') }}"
class="border rounded px-3 py-2">
</div>

<button type="submit"
class="bg-green-600 text-white px-4 py-2 rounded">
Filter
</button>

<!-- ✅ tombol reset -->
<a href="{{ url('/dashboard?tab=merchant') }}"
class="bg-gray-200 text-gray-700 px-4 py-2 rounded">
Reset
</a>

</form>

<!-- grid santri -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">

<!-- Total merchant -->
<div class="rounded-xl bg-white text-gray-800 p-6 shadow-md w-full">
<div class="flex items-center justify-between">

<h1 class="text-4xl font-bold">
{{ number_format($totalMerchant) }}
</h1>

<div class="w-10 h-10 flex items-center justify-center rounded-lg bg-green-100 p-2">

<svg xmlns="http://www.w3.org/2000/svg" fill="#029e13" viewBox="0 0 616 512"><path d="M602 118.6L537.1 15C531.3 5.7 521 0 510 0H106C95 0 84.7 5.7 78.9 15L14 118.6c-33.5 53.5-3.8 127.9 58.8 136.4 4.5.6 9.1.9 13.7.9 29.6 0 55.8-13 73.8-33.1 18 20.1 44.3 33.1 73.8 33.1 29.6 0 55.8-13 73.8-33.1 18 20.1 44.3 33.1 73.8 33.1 29.6 0 55.8-13 73.8-33.1 18.1 20.1 44.3 33.1 73.8 33.1 4.7 0 9.2-.3 13.7-.9 62.8-8.4 92.6-82.8 59-136.4zM529.5 288c-10 0-19.9-1.5-29.5-3.8V384H116v-99.8c-9.6 2.2-19.5 3.8-29.5 3.8-6 0-12.1-.4-18-1.2-5.6-.8-11.1-2.1-16.4-3.6V480c0 17.7 14.3 32 32 32h448c17.7 0 32-14.3 32-32V283.2c-5.4 1.6-10.8 2.9-16.4 3.6-6.1.8-12.1 1.2-18.2 1.2z"/></svg>
</div>

</div>

<h1 class="text-md font-bold mt-2">Total Merchant</h1>
<p class="text-sm text-gray-500 mt-1">Jumlah Seluruh Merchant</p>
</div>


<!-- merchant hari ini  -->
<div class="rounded-xl bg-white text-gray-800 p-6 shadow-md w-full">
<div class="flex items-center justify-between">

<h1 class="text-4xl font-bold">
{{ number_format($merchantHariIni) }}
</h1>

<div class="w-10 h-10 flex items-center justify-center rounded-lg bg-green-100 p-2">

<svg xmlns="http://www.w3.org/2000/svg" fill="#029e13" viewBox="0 0 448 512"><path d="M0 464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V192H0v272zm64-192c0-8.8 7.2-16 16-16h96c8.8 0 16 7.2 16 16v96c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16v-96zM400 64h-48V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H160V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H48C21.5 64 0 85.5 0 112v48h448v-48c0-26.5-21.5-48-48-48z"/></svg>
</div>

</div>

<h1 class="text-md font-bold mt-2">Merchant Hari ini </h1>
<p class="text-sm text-gray-500 mt-1">Jumlah Merchant Hari ini</p>
</div>


<!-- merchant aktif -->
<div class="rounded-xl bg-white text-gray-800 p-6 shadow-md w-full">
<div class="flex items-center justify-between">

<h1 class="text-4xl font-bold">
{{ number_format($merchantAktif) }}
</h1>

<div class="w-10 h-10 flex items-center justify-center rounded-lg bg-green-100 p-2">


<svg xmlns="http://www.w3.org/2000/svg" fill="#029e13" viewBox="0 0 640 512"><path d="M320 384H128V224H64v256c0 17.7 14.3 32 32 32h256c17.7 0 32-14.3 32-32V224h-64v160zm314.6-241.8l-85.3-128c-6-8.9-16-14.2-26.7-14.2H117.4c-10.7 0-20.7 5.3-26.6 14.2l-85.3 128c-14.2 21.3 1 49.8 26.6 49.8H608c25.5 0 40.7-28.5 26.6-49.8zM512 496c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16V224h-64v272z"/></svg>

</div>

</div>

<h1 class="text-md font-bold mt-2">Merchant Aktif</h1>
<p class="text-sm text-gray-500 mt-1">Jumlah Merchant Aktif</p>
</div>



</div>
<!-- end data -->


<!-- chart -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

<div class="bg-white rounded-xl shadow p-4">
<h4 class="font-bold mb-3">Jumlah Merchant</h4>
<div id="chart-merchant-total" class="h-[300px]"></div>
</div>

<div class="bg-white rounded-xl shadow p-4">
<h4 class="font-bold mb-3">Merchant Harian</h4>
<div id="chart-merchant-harian" class="h-[300px]"></div>
</div>

<div class="bg-white rounded-xl shadow p-4 mt-6">
<h4 class="font-bold mb-3">Top Merchant</h4>
<div id="chart-top-merchant" class="h-[300px]"></div>


<div class="mt-6 bg-white shadow rounded-xl p-4">
    <h2 class="text-lg font-semibold mb-4">Top 5 Merchant</h2>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">No</th>
                    <th class="p-2 border">Nama Merchant</th>
                    <th class="p-2 border">Total Transaksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topMerchant as $index => $row)
                    <tr>
                        <td class="p-2 border">{{ $index + 1 }}</td>
                        <td class="p-2 border">{{ $row->merchant_name }}</td>
                        <td class="p-2 border">{{ number_format($row->total) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-4 text-center text-gray-500">
                            Tidak ada data
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>

<div class="bg-white rounded-xl p-4 shadow mt-6">

<h4 class="font-bold text-gray-700 mb-4">
Pendapatan per Merchant
</h4>

<div id="chart-merchant-revenue" class="w-full h-[350px]"></div>


<div class="mt-6 bg-white shadow rounded-xl p-4">
    <h2 class="text-lg font-semibold mb-4">Top 5 Merchant (Revenue)</h2>

    <table class="w-full text-sm border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">No</th>
                <th class="p-2 border">Merchant</th>
                <th class="p-2 border">Total Revenue</th>
            </tr>
        </thead>
        <tbody>
            @forelse($merchantRevenue as $i => $row)
                <tr>
                    <td class="p-2 border">{{ $i + 1 }}</td>
                    <td class="p-2 border">{{ $row->merchant_name }}</td>
                    <td class="p-2 border">
                        Rp {{ number_format($row->total_revenue, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center p-4 text-gray-500">
                        Tidak ada data
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>


</div>




<!-- end chart -->
</div>
<!-- end merchant -->
</div>
</div>

@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    // CHART TRANSAKSI
    Highcharts.chart('chart-transaksi', {
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
       xAxis: {
    categories: @json($days),
    title: {
           text: '{{ \Carbon\Carbon::now()->translatedFormat("F Y") }}',
        
        style: {
            fontSize: '12px',
            color: '#666'
        }
    }
},
        yAxis: {
            title: {
                text: 'Jumlah Transaksi'
            }
        },
        
        series: [{
            name: 'Transaksi',
            data: @json($jumlahPerHari),
            color: '#029e13'
        }],
        credits: {
            enabled:false
        }
    });

    // chart topup

Highcharts.chart('chart-siswa-topup', {
    chart: {
        type: 'pie'
    },
    title: {
        text: ''
    },
    tooltip: {
        pointFormat: '<b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '{point.name}: {point.y} siswa'
            }
        }
    },
    series: [{
        name: 'Siswa',
        colorByPoint: true,
        data: [
            {
                name: 'Sudah Topup',
                y: {{ $santriTopup }},
                color: '#22c55e'
            },
            {
                name: 'Belum Topup',
                y: {{ $santriBelumTopup }},
                color: '#ef4444'
            }
        ]
    }],
    credits: {
        enabled:false
    }
});
    // end topup

    // CHART SANTRI
    Highcharts.chart('chartSantri', {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Santri Berdasarkan Gender'
        },
        series: [{
            name: 'Jumlah',
            colorByPoint: true,
            data: [
                {
                    name: 'Laki-Laki',
                    y: {{ $santriLaki }}
                },
                {
                    name: 'Perempuan',
                    y: {{ $santriPerempuan }}
                }
            ]
        }],
        credits: {
            enabled:false
        }
    });


    // chart by angkatan

    Highcharts.chart('chart-angkatan', {
    chart: {
        type: 'pie'
    },
    title: {
        text: 'Santri Berdasarkan Angkatan Dan Kelas'
    },
    series: [{
        name: 'Jumlah',
        colorByPoint: true,
        data: [
            @foreach($chartLabels as $i => $label)
            {
                name: '{{ $label }}',
                y: {{ $chartData[$i] }}
            },
            @endforeach
        ]
    }],
    credits: {
        enabled:false
    }
});

    // CHART TEACHER
    Highcharts.chart('chartTeacher', {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Guru Berdasarkan Gender'
        },
        series: [{
            name: 'Jumlah',
            colorByPoint: true,
            data: [
                {
                    name: 'Ustadzh',
                    y: {{ $teacherLaki }}
                },
                {
                    name: 'Ustadzah',
                    y: {{ $teacherPerempuan }}
                }
            ]
        }],
        credits: {
            enabled:false
        }
    });

});


// merchant
document.addEventListener("DOMContentLoaded", function () {

// chart siswa by angkatan dan kelas


// ======================
// TOTAL MERCHANT
// ======================

Highcharts.chart('chart-merchant-total', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: @json($merchantTotalLabel)
    },
    yAxis: {
        title: {
            text: 'Jumlah Merchant'
        }
    },
    series: [{
        name: 'Merchant',
        data: @json($merchantTotalData),
        color: '#22c55e'
    }],
    credits: { enabled:false }
});


// ======================
// MERCHANT HARIAN
// ======================

Highcharts.chart('chart-merchant-harian', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: @json($merchantDays)
    },
    yAxis: {
        title: {
            text: 'Jumlah Merchant'
        }
    },
    series: [{
        name: 'Merchant',
        data: @json($merchantJumlah),
        color: '#029e13'
    }],
    credits: { enabled:false }
});


// ======================
// TOP MERCHANT
// ======================

Highcharts.chart('chart-top-merchant', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: @json($merchantNames),
        title: {
            text: 'Merchant'
        }
    },
    yAxis: {
        title: {
            text: 'Jumlah Transaksi'
        }
    },
    series: [{
        name: 'Transaksi',
        data: @json($merchantTotals),
        colorByPoint: true
    }],
    credits: {
        enabled:false
    }
});


// pendapatan merchant

Highcharts.chart('chart-merchant-revenue', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: @json($merchantRevenueNames),
        title: {
            text: 'Merchant'
        }
    },
    yAxis: {
        title: {
            text: 'Pendapatan (Rp)'
        }
    },
    series: [{
        name: 'Pendapatan',
        data: @json($merchantRevenueTotals),
        colorByPoint: true
    }],
    tooltip: {
        pointFormat: 'Rp <b>{point.y:,.0f}</b>'
    },
    credits: {
        enabled:false
    }
});

// saldo siswa tertinggi


Highcharts.chart('chart-top-saldo', {
    chart: { type: 'bar' },
    title: { text: '' },
    xAxis: {
        categories: @json($saldoNames),
        title: { text: 'Santri' }
    },
    yAxis: {
        title: { text: 'Saldo (Rp)' }
    },
    series: [{
        name: 'Saldo',
        data: @json($saldoTotals),
        color: '#22c55e'
    }],
    tooltip: {
        pointFormat: 'Rp <b>{point.y:,.0f}</b>'
    },
    credits: { enabled:false }
});


// belanja tertigggi

Highcharts.chart('chart-top-belanja', {
    chart: { type: 'bar' },
    title: { text: '' },
    xAxis: {
        categories: @json($belanjaNames),
        title: { text: 'Santri' }
    },
    yAxis: {
        title: { text: 'Total Belanja (Rp)' }
    },
    series: [{
        name: 'Belanja',
        data: @json($belanjaTotals),
        color: '#16a34a'
    }],
    tooltip: {
        pointFormat: 'Rp <b>{point.y:,.0f}</b>'
    },
    credits: { enabled:false }
});

// chart siswa by angkatan dan kelas

  Highcharts.chart('chart-angkatan', {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Santri Berdasarkan Angkatan dan Kelas'
        },
        tooltip: {
            pointFormat: '<b>{point.y}</b> ({point.percentage:.1f}%)'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '{point.name}: {point.y}'
                }
            }
        },
        series: [{
            name: 'Jumlah',
            colorByPoint: true,
            data: [
                @foreach($chartLabels as $i => $label)
                {
                    name: '{{ $label }}',
                    y: {{ $chartData[$i] }}
                },
                @endforeach
            ]
        }],
        credits: {
            enabled: false
        }
    });

});

// angkatan




// filter santri by angkatan


$('#angkatan').on('change', function() {
    let id = $(this).val();

    $('#kelas').html('<option>Loading...</option>');

    if (id) {
        $.get('/get-kelas/' + id, function(data) {
            let html = '<option value="">Pilih Kelas</option>';
            data.forEach(function(item) {
                html += `<option value="${item.id}">${item.class_name}</option>`;
            });
            $('#kelas').html(html);
        });
    }
});

$(document).ready(function() {

    console.log('JS READY');

    function loadKelas() {
        let angkatanId = $('#angkatan').val();

        console.log('angkatan ID:', angkatanId);

        if (!angkatanId) return;

        fetch('/get-kelas/' + angkatanId)
            .then(res => res.json())
            .then(data => {
                console.log('DATA:', data);

                let html = '<option value="">Pilih Kelas</option>';

                data.forEach(item => {
                    html += `<option value="${item.id}">${item.class_name}</option>`;
                });

                document.getElementById('kelas').innerHTML = html;
            })
            .catch(err => console.log('ERROR:', err));
    }

    loadKelas();

    $('#angkatan').on('change', function() {
        loadKelas();
    });

});

// 🔥 saat pilih angkatan
$('#angkatan').on('change', function() {
    loadKelas();
});

// 🔥 saat halaman load (INI WAJIB)
$(document).ready(function() {
  let selectedKelas = "{{ $classId ?? '' }}";
    loadKelas(selectedKelas);
});
</script>