@extends('layouts.app')

@section('content')
<div class="py-6">
<div class="container mx-auto w-full px-4">

<div x-data="{ tab: 'transaksi' }" class="py-6">
<div class="container mx-auto w-full px-4 ">

<!-- TAB MENU -->
<div class="flex flex-wrap gap-2 mb-6 pb-2 mb-4">

<button @click="tab='transaksi'"
:class="tab==='transaksi' ? 'bg-green-600 text-white' : 'bg-gray-100'"
class="px-4 py-2 rounded-lg text-sm font-semibold">
Dashboard Transaksi
</button>

<button @click="tab='pesantren'"
:class="tab==='pesantren' ? 'bg-green-600 text-white' : 'bg-gray-100'"
class="px-4 py-2 rounded-lg text-sm font-semibold">
Pesantren
</button>

<button @click="tab='merchant'"
:class="tab==='merchant' ? 'bg-green-600 text-white' : 'bg-gray-100'"
class="px-4 py-2 rounded-lg text-sm font-semibold">
Dashboard Merchant
</button>


</div>

<!-- dashboard transaksi -->
<div x-show="tab === 'transaksi'">


<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

<!-- Total Transaksi -->
<div class="rounded-xl bg-white text-gray-800 p-6 shadow-md w-full">
<div class="flex items-center justify-between">

<h1 class="text-4xl font-bold">
{{ number_format($totalTransaksi) }}
</h1>

<div class="w-10 h-10 flex items-center justify-center rounded-lg bg-green-100 p-2">
  <svg xmlns="http://www.w3.org/2000/svg" fill="#029e13" viewBox="0 0 576 512"><path d="M271.06,144.3l54.27,14.3a8.59,8.59,0,0,1,6.63,8.1c0,4.6-4.09,8.4-9.12,8.4h-35.6a30,30,0,0,1-11.19-2.2c-5.24-2.2-11.28-1.7-15.3,2l-19,17.5a11.68,11.68,0,0,0-2.25,2.66,11.42,11.42,0,0,0,3.88,15.74,83.77,83.77,0,0,0,34.51,11.5V240c0,8.8,7.83,16,17.37,16h17.37c9.55,0,17.38-7.2,17.38-16V222.4c32.93-3.6,57.84-31,53.5-63-3.15-23-22.46-41.3-46.56-47.7L282.68,97.4a8.59,8.59,0,0,1-6.63-8.1c0-4.6,4.09-8.4,9.12-8.4h35.6A30,30,0,0,1,332,83.1c5.23,2.2,11.28,1.7,15.3-2l19-17.5A11.31,11.31,0,0,0,368.47,61a11.43,11.43,0,0,0-3.84-15.78,83.82,83.82,0,0,0-34.52-11.5V16c0-8.8-7.82-16-17.37-16H295.37C285.82,0,278,7.2,278,16V33.6c-32.89,3.6-57.85,31-53.51,63C227.63,119.6,247,137.9,271.06,144.3ZM565.27,328.1c-11.8-10.7-30.2-10-42.6,0L430.27,402a63.64,63.64,0,0,1-40,14H272a16,16,0,0,1,0-32h78.29c15.9,0,30.71-10.9,33.25-26.6a31.2,31.2,0,0,0,.46-5.46A32,32,0,0,0,352,320H192a117.66,117.66,0,0,0-74.1,26.29L71.4,384H16A16,16,0,0,0,0,400v96a16,16,0,0,0,16,16H372.77a64,64,0,0,0,40-14L564,377a32,32,0,0,0,1.28-48.9Z"/></svg>

</div>


</div>

<h1 class="text-md font-bold mt-2">Jumlah Transaksi</h1>
<p class="text-sm text-gray-500 mt-1">Total transaksi seluruh waktu</p>
</div>


<!-- Value Transaksi -->
<div class="rounded-xl bg-white text-gray-800 p-6 shadow-md w-full">
<div class="flex items-center justify-between">

<h1 class="text-4xl font-bold">
Rp {{ number_format($totalValue) }}
</h1>

<div class="w-10 h-10 flex items-center justify-center rounded-lg bg-green-100 p-2">
<svg xmlns="http://www.w3.org/2000/svg" fill="#029e13" viewBox="0 0 640 512"><path d="M608 64H32C14.33 64 0 78.33 0 96v320c0 17.67 14.33 32 32 32h576c17.67 0 32-14.33 32-32V96c0-17.67-14.33-32-32-32zM48 400v-64c35.35 0 64 28.65 64 64H48zm0-224v-64h64c0 35.35-28.65 64-64 64zm272 176c-44.19 0-80-42.99-80-96 0-53.02 35.82-96 80-96s80 42.98 80 96c0 53.03-35.83 96-80 96zm272 48h-64c0-35.35 28.65-64 64-64v64zm0-224c-35.35 0-64-28.65-64-64h64v64z"/></svg>
</div>


</div>

<h1 class="text-md font-bold mt-2">Value Transaksi</h1>
<p class="text-sm text-gray-500 mt-1">Total nilai transaksi</p>
</div>


<!-- Transaksi Bulan Ini -->
<div class="rounded-xl bg-white text-gray-800 p-6 shadow-md w-full">
<div class="flex items-center justify-between">

<h1 class="text-4xl font-bold">
{{ number_format($transaksiBulanIni) }}
</h1>

<div class="w-10 h-10 flex items-center justify-center rounded-lg bg-green-100 p-2">
  <svg xmlns="http://www.w3.org/2000/svg" fill="#029e13" viewBox="0 0 448 512"><path d="M0 464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V192H0v272zm320-196c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12h-40c-6.6 0-12-5.4-12-12v-40zm0 128c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12h-40c-6.6 0-12-5.4-12-12v-40zM192 268c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12h-40c-6.6 0-12-5.4-12-12v-40zm0 128c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12h-40c-6.6 0-12-5.4-12-12v-40zM64 268c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12H76c-6.6 0-12-5.4-12-12v-40zm0 128c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12H76c-6.6 0-12-5.4-12-12v-40zM400 64h-48V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H160V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H48C21.5 64 0 85.5 0 112v48h448v-48c0-26.5-21.5-48-48-48z"/></svg>
</div>


</div>

<h1 class="text-md font-bold mt-2">Transaksi Bulan Ini</h1>
<p class="text-sm text-gray-500 mt-1">Jumlah transaksi bulan berjalan</p>
</div>


<!-- Value Bulan Ini -->
<div class="rounded-xl bg-white text-gray-800 p-6 shadow-md w-full">
<div class="flex items-center justify-between">

<h1 class="text-4xl font-bold">
Rp {{ number_format($valueBulanIni) }}
</h1>

<div class="w-10 h-10 flex items-center justify-center rounded-lg bg-green-100 p-2">
<svg xmlns="http://www.w3.org/2000/svg" fill="#029e13" viewBox="0 0 448 512"><path d="M436 160H12c-6.627 0-12-5.373-12-12v-36c0-26.51 21.49-48 48-48h48V12c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v52h128V12c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v52h48c26.51 0 48 21.49 48 48v36c0 6.627-5.373 12-12 12zM12 192h424c6.627 0 12 5.373 12 12v260c0 26.51-21.49 48-48 48H48c-26.51 0-48-21.49-48-48V204c0-6.627 5.373-12 12-12zm333.296 95.947l-28.169-28.398c-4.667-4.705-12.265-4.736-16.97-.068L194.12 364.665l-45.98-46.352c-4.667-4.705-12.266-4.736-16.971-.068l-28.397 28.17c-4.705 4.667-4.736 12.265-.068 16.97l82.601 83.269c4.667 4.705 12.265 4.736 16.97.068l142.953-141.805c4.705-4.667 4.736-12.265.068-16.97z"/></svg>
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
</div>
<!-- end dashboard transaksi -->

<!-- dashboard santri -->
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

<!-- end grid santri -->

<!-- grid ustad -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">

<!-- Total ustad dan ustazah -->
<div class="rounded-xl bg-white text-gray-800 p-6 shadow-md w-full">
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
</div>


<!-- Ustadzh -->
<div class="rounded-xl bg-white text-gray-800 p-6 shadow-md w-full">
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
</div>


<!-- Ustadzah -->
<div class="rounded-xl bg-white text-gray-800 p-6 shadow-md w-full">
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
</div>


<!-- Ustadzh aktif -->
<div class="rounded-xl bg-white text-gray-800 p-6 shadow-md w-full">
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
</div>

</div>
<!-- end grid ustad -->
</div>

<!-- end santri -->

<!-- Chart transaksi -->


</div>
</div>

@endsection
<script>
  // chart transaksi harian 
document.addEventListener("DOMContentLoaded", function () {

Highcharts.chart('chart-transaksi', {
chart: {
type: 'column'
},
title: {
text: ''
},
xAxis: {
categories: @json($days)
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

});

// end chart transaksi harian 


// untuk dashboard santri


Highcharts.chart('chart-santri', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Jumlah Santri per Tingkat'
    },
    xAxis: {
        categories: @json($tingkat)
    },
    yAxis: {
        title: {
            text: 'Jumlah Santri'
        }
    },
    series: [{
        name: 'Laki-laki',
        data: @json($laki),
        color: '#3b82f6'
    },{
        name: 'Perempuan',
        data: @json($perempuan),
        color: '#ec4899'
    }],
    credits: {
        enabled:false
    }
});

// end santri
</script>
