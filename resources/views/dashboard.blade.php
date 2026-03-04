@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="container mx-auto w-full px-4">

        {{-- Card Jumlah Mitra --}}

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">



  <!-- Card 1 -->
<div class="rounded-xl bg-white text-gray-800 p-6 shadow-md w-full">
  <div class="flex items-center justify-between">
    <!-- Angka besar -->
   <h1 class="text-4xl font-bold">10</h1>


    <!-- Icon -->
      <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect width="36" height="36" rx="8" fill="#FDE2D3"/>
        <path d="M18 16C20.2091 16 22 14.2091 22 12C22 9.79086 20.2091 8 18 8C15.7909 8 14 9.79086 14 12C14 14.2091 15.7909 16 18 16ZM11.5 19C12.8807 19 14 17.8807 14 16.5C14 15.1193 12.8807 14 11.5 14C10.1193 14 9 15.1193 9 16.5C9 17.8807 10.1193 19 11.5 19ZM27 16.5C27 17.8807 25.8807 19 24.5 19C23.1193 19 22 17.8807 22 16.5C22 15.1193 23.1193 14 24.5 14C25.8807 14 27 15.1193 27 16.5ZM18 17C20.7614 17 23 19.2386 23 22V28H13V22C13 19.2386 15.2386 17 18 17ZM11 21.9999C11 21.307 11.1007 20.6376 11.2882 20.0056L11.1186 20.0204C9.36503 20.2104 8 21.6958 8 23.4999V27.9999H11V21.9999ZM28 27.9999V23.4999C28 21.6378 26.5459 20.1153 24.7118 20.0056C24.8993 20.6376 25 21.307 25 21.9999V27.9999H28Z" fill="url(#paint0_linear_1635_14640)"/>
        <defs>
          <linearGradient id="paint0_linear_1635_14640" x1="20.1111" y1="8" x2="12.5" y2="25.7778" gradientUnits="userSpaceOnUse">
            <stop stop-color="#FF8F00"/>
            <stop offset="1" stop-color="#FF6200"/>
          </linearGradient>
        </defs>
      </svg>
  </div>

  <!-- Label bawah -->
      <h1 class="text-1xl font-bold">Jumlah Mitra</h1>
  <p class="text-sm font-medium text-gray-500 mt-2">Data Mitra Saat Ini</p>
</div>

<!-- card 2 -->

<div class="rounded-xl bg-white text-gray-800 p-6 shadow-md w-full">
  <div class="flex items-center justify-between">
    <!-- Angka besar -->
   <h1 class="text-4xl font-bold">11</h1>


    <!-- Icon -->
     <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="36" height="36" rx="8" fill="#FDE2D3"/>
<g clip-path="url(#clip0_1635_14650)">
<path d="M16.5596 18.1646C19.9391 18.1644 21.1551 14.7807 21.4734 12.0011C21.8655 8.57706 20.2463 6 16.5596 6C12.8735 6 11.2534 8.57686 11.6458 12.0011C11.9645 14.7807 13.1801 18.1649 16.5596 18.1646Z" fill="url(#paint0_linear_1635_14650)"/>
<path d="M23.9493 19.5746C24.058 19.5746 24.1661 19.5778 24.2734 19.5838C24.1125 19.3544 23.9264 19.152 23.7085 18.9894C23.0592 18.5047 22.2181 18.3457 21.4746 18.0535C21.1127 17.9114 20.7886 17.7702 20.4844 17.6094C19.4576 18.7355 18.1186 19.3245 16.5593 19.3247C15.0005 19.3247 13.6616 18.7356 12.6349 17.6094C12.3306 17.7702 12.0065 17.9114 11.6446 18.0535C10.9012 18.3457 10.0602 18.5047 9.41076 18.9894C8.2877 19.8276 7.99747 21.7133 7.76943 22.9996C7.58123 24.0614 7.4548 25.1449 7.4179 26.2235C7.38931 27.0589 7.80178 27.176 8.50068 27.4282C9.37578 27.7438 10.2794 27.9781 11.189 28.1702C12.9457 28.5412 14.7566 28.8262 16.5596 28.839C17.4332 28.8327 18.3086 28.7623 19.1789 28.6495C18.5345 27.7158 18.1566 26.5849 18.1566 25.3673C18.1566 22.1731 20.7552 19.5746 23.9493 19.5746Z" fill="url(#paint1_linear_1635_14650)"/>
<path d="M23.9493 20.7324C21.39 20.7324 19.3151 22.8073 19.3151 25.3666C19.3151 27.9259 21.3899 30.0007 23.9493 30.0007C26.5086 30.0007 28.5835 27.9259 28.5835 25.3666C28.5834 22.8072 26.5086 20.7324 23.9493 20.7324ZM25.9767 26.1616H24.7444V27.394C24.7444 27.8331 24.3884 28.1891 23.9493 28.1891C23.5102 28.1891 23.1542 27.8331 23.1542 27.394V26.1616H21.9219C21.4827 26.1616 21.1267 25.8057 21.1267 25.3665C21.1267 24.9274 21.4827 24.5714 21.9219 24.5714H23.1542V23.3391C23.1542 22.8999 23.5102 22.5439 23.9493 22.5439C24.3885 22.5439 24.7444 22.8999 24.7444 23.3391V24.5714H25.9767C26.4159 24.5714 26.7719 24.9274 26.7719 25.3665C26.7718 25.8057 26.4159 26.1616 25.9767 26.1616Z" fill="url(#paint2_linear_1635_14650)"/>
</g>
<defs>
<linearGradient id="paint0_linear_1635_14650" x1="17.6091" y1="6" x2="12.3498" y2="16.04" gradientUnits="userSpaceOnUse">
<stop stop-color="#FF8F00"/>
<stop offset="1" stop-color="#FF6200"/>
</linearGradient>
<linearGradient id="paint1_linear_1635_14650" x1="17.6243" y1="17.6094" x2="14.509" y2="28.5323" gradientUnits="userSpaceOnUse">
<stop stop-color="#FF8F00"/>
<stop offset="1" stop-color="#FF6200"/>
</linearGradient>
<linearGradient id="paint2_linear_1635_14650" x1="24.9276" y1="20.7324" x2="21.4005" y2="28.9709" gradientUnits="userSpaceOnUse">
<stop stop-color="#FF8F00"/>
<stop offset="1" stop-color="#FF6200"/>
</linearGradient>
<clipPath id="clip0_1635_14650">
<rect width="24" height="24" fill="white" transform="translate(6 6)"/>
</clipPath>
</defs>
</svg>

  </div>

  <!-- Label bawah -->
      <h1 class="text-1xl font-bold">Mitra Baru</h1>
  <p class="text-sm font-medium text-gray-500 mt-2">Baru Bergabung Hari Ini</p>
</div>


<!-- card 3 -->

<div class="rounded-xl bg-white text-gray-800 p-6 shadow-md w-full">
  <div class="flex items-center justify-between">
    <!-- Angka besar -->
   <h1 class="text-4xl font-bold">99</h1>


    <!-- Icon -->
     <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="36" height="36" rx="8" fill="#FDE2D3"/>
<g clip-path="url(#clip0_1635_14664)">
<path fill-rule="evenodd" clip-rule="evenodd" d="M22.0482 9.75C23.6556 9.75 25.4117 11.1359 27.0136 13.2321C27.6255 14.0328 28.1554 14.876 28.4807 15.5547C28.6523 15.9126 28.765 16.2191 28.8088 16.4742C28.9068 17.0451 28.6901 17.625 27.9622 17.625L27.7355 17.6197C27.6235 17.6137 27.4764 17.6011 27.1834 17.5752C26.4216 17.508 25.8493 17.5115 25.2618 17.6414L25.467 18.0819C25.7195 18.0282 25.9815 18 26.25 18C28.3211 18 30 19.6789 30 21.75C30 23.8211 28.3211 25.5 26.25 25.5C24.1789 25.5 22.5 23.8211 22.5 21.75C22.5 20.4821 23.1292 19.3612 24.0925 18.6824L23.8737 18.2133C23.5608 18.4517 23.1979 18.8286 22.6772 19.4371L22.0142 20.2277L21.7007 20.5961C20.5873 21.881 19.8515 22.4498 18.9032 22.4968L18.7725 22.5L13.4248 22.5009C13.077 24.2121 11.5639 25.5 9.75 25.5C7.67893 25.5 6 23.8211 6 21.75C6 19.6789 7.67893 18 9.75 18C11.5642 18 13.0775 19.2882 13.425 20.9999L14.0895 21L14.0892 20.9782C14.0519 20.3542 13.7783 19.6766 13.0958 18.9052L12.9538 18.7497C12.864 18.6543 12.7737 18.5642 12.6826 18.4793C11.6459 17.512 10.7935 17.2708 9.213 17.2591L8.78125 17.2596C7.23082 17.2596 6.07129 15.1171 6.32823 13.9974C6.46228 13.4131 6.89904 13.2546 7.4658 13.2513C7.68066 13.25 7.91506 13.2733 8.23101 13.3211L9.09447 13.4605C9.1861 13.4735 9.24173 13.479 9.28339 13.4801L9.30688 13.4802C10.8313 13.4551 12.0043 13.6555 13.0824 14.0382L13.3411 14.1358C13.6448 14.2541 14.0438 14.417 14.1783 14.4671L14.2808 14.5035C14.2942 14.5092 14.2996 14.5132 14.3006 14.5162L14.2995 14.5177L14.4886 14.3566C15.5373 13.4726 16.2392 13.0969 17.0233 12.9363L17.1626 12.9101C18.1698 12.7374 19.1904 12.7656 20.2121 12.9379L20.4127 12.9742L19.4479 11.4721C19.3587 11.3311 19.294 11.2262 19.2412 11.1372L19.1582 10.9916C19.1347 10.9481 19.115 10.9087 19.0983 10.8716C19.0619 10.7905 19.0369 10.7181 19.0232 10.6203C18.9707 10.2454 19.1684 9.80853 19.6696 9.75538L19.7739 9.75L22.0482 9.75ZM20.25 15.75H17.25C16.8358 15.75 16.5 16.0858 16.5 16.5C16.5 16.9142 16.8358 17.25 17.25 17.25H20.25C20.6642 17.25 21 16.9142 21 16.5C21 16.0858 20.6642 15.75 20.25 15.75Z" fill="url(#paint0_linear_1635_14664)"/>
</g>
<defs>
<linearGradient id="paint0_linear_1635_14664" x1="20.5333" y1="9.75" x2="16.2195" y2="25.1041" gradientUnits="userSpaceOnUse">
<stop stop-color="#FF8F00"/>
<stop offset="1" stop-color="#FF6200"/>
</linearGradient>
<clipPath id="clip0_1635_14664">
<rect width="24" height="24" fill="white" transform="translate(6 6)"/>
</clipPath>
</defs>
</svg>

  </div>

  <!-- Label bawah -->
      <h1 class="text-1xl font-bold">Stok Motor</h1>
  <p class="text-sm font-medium text-gray-500 mt-2">Ketersediaan Unit Motor</p>
</div>

<!-- card 4 -->


<div class="rounded-xl bg-white text-gray-800 p-6 shadow-md w-full">
  <div class="flex items-center justify-between">
    <!-- Angka besar -->
   <h1 class="text-4xl font-bold">99</h1>


    <!-- Icon -->
   <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="36" height="36" rx="8" fill="#FDE2D3"/>
<path d="M21.8892 23.1074C21.3789 23.1074 20.9791 23.5267 20.9791 24.0619C20.9791 24.593 21.3822 25.009 21.8966 25.009C22.4196 25.009 22.7992 24.6107 22.7992 24.0619C22.7993 23.5088 22.4166 23.1074 21.8892 23.1074Z" fill="url(#paint0_linear_1635_14676)"/>
<path d="M21.1052 21.8613C21.123 22.2033 21.4161 22.473 21.7586 22.473H22.0195C22.3613 22.473 22.6548 22.2038 22.6737 21.8626L22.7606 20.308C22.7702 20.1367 22.7086 19.9592 22.5918 19.8356C22.4749 19.7121 22.3095 19.6328 22.1379 19.6328H21.6477C21.4763 19.6328 21.3109 19.714 21.194 19.8372C21.077 19.9605 21.015 20.1304 21.0239 20.3015L21.1052 21.8613Z" fill="url(#paint1_linear_1635_14676)"/>
<path d="M27.8751 22.2886C27.8751 19.2321 25.5719 16.705 22.6102 16.3476V10.1022C22.6102 9.13228 21.8141 8.3432 20.8356 8.3432H19.1309V6.71006C19.1309 6.31853 18.8123 6 18.4208 6H12.2433C11.8518 6 11.5332 6.31853 11.5332 6.71006V8.3432H9.87418C8.8933 8.3432 8.12488 9.11581 8.12488 10.1022V28.1991C8.12488 29.1921 8.90964 30 9.87418 30H20.8356C21.8039 30 22.593 29.2086 22.6093 28.2298C25.5715 27.8727 27.8751 25.3454 27.8751 22.2886ZM21.8891 25.8138C19.9453 25.8138 18.3639 24.2324 18.3639 22.2886C18.3639 20.3448 19.9453 18.7635 21.8891 18.7635C23.8329 18.7635 25.4142 20.3448 25.4142 22.2886C25.4142 24.2324 23.8329 25.8138 21.8891 25.8138ZM20.48 10.4734V16.4717C17.9511 17.0844 16.044 19.3062 15.9107 21.9883C13.7392 21.9904 11.5219 21.996 10.2551 21.9996V10.4734H20.48Z" fill="url(#paint2_linear_1635_14676)"/>
<defs>
<linearGradient id="paint0_linear_1635_14676" x1="22.0813" y1="23.1074" x2="21.3358" y2="24.7741" gradientUnits="userSpaceOnUse">
<stop stop-color="#FF8F00"/>
<stop offset="1" stop-color="#FF6200"/>
</linearGradient>
<linearGradient id="paint1_linear_1635_14676" x1="22.0758" y1="19.6328" x2="20.6727" y2="21.6388" gradientUnits="userSpaceOnUse">
<stop stop-color="#FF8F00"/>
<stop offset="1" stop-color="#FF6200"/>
</linearGradient>
<linearGradient id="paint2_linear_1635_14676" x1="20.0847" y1="6" x2="9.74924" y2="25.8665" gradientUnits="userSpaceOnUse">
<stop stop-color="#FF8F00"/>
<stop offset="1" stop-color="#FF6200"/>
</linearGradient>
</defs>
</svg>


  </div>

  <!-- Label bawah -->
      <h1 class="text-1xl font-bold">Motor Baterai Rendah</h1>
  <p class="text-sm font-medium text-gray-500 mt-2">Baterai Dibawah 5%</p>
</div>

<!-- card 5 -->


<div class="rounded-xl bg-white text-gray-800 p-6 shadow-md w-full">
  <div class="flex items-center justify-between">
    <!-- Angka besar -->
   <h1 class="text-4xl font-bold">99</h1>


    <!-- Icon -->
  <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="36" height="36" rx="8" fill="#FDE2D3"/>
<g clip-path="url(#clip0_1635_14689)">
<path d="M9 25V10C9 9.73478 9.10536 9.48043 9.29289 9.29289C9.48043 9.10536 9.73478 9 10 9H19C19.2652 9 19.5196 9.10536 19.7071 9.29289C19.8946 9.48043 20 9.73478 20 10V18H22C22.5304 18 23.0391 18.2107 23.4142 18.5858C23.7893 18.9609 24 19.4696 24 20V24C24 24.2652 24.1054 24.5196 24.2929 24.7071C24.4804 24.8946 24.7348 25 25 25C25.2652 25 25.5196 24.8946 25.7071 24.7071C25.8946 24.5196 26 24.2652 26 24V17H24C23.7348 17 23.4804 16.8946 23.2929 16.7071C23.1054 16.5196 23 16.2652 23 16V12.414L21.343 10.757L22.757 9.343L27.707 14.293C27.8 14.3857 27.8738 14.4959 27.924 14.6173C27.9743 14.7386 28.0001 14.8687 28 15V24C28 24.7956 27.6839 25.5587 27.1213 26.1213C26.5587 26.6839 25.7956 27 25 27C24.2043 27 23.4413 26.6839 22.8787 26.1213C22.3161 25.5587 22 24.7956 22 24V20H20V25H21V27H8V25H9ZM15 17V13L11 19H14V23L18 17H15Z" fill="url(#paint0_linear_1635_14689)"/>
</g>
<defs>
<linearGradient id="paint0_linear_1635_14689" x1="20.1111" y1="9" x2="13.7592" y2="25.4852" gradientUnits="userSpaceOnUse">
<stop stop-color="#FF8F00"/>
<stop offset="1" stop-color="#FF6200"/>
</linearGradient>
<clipPath id="clip0_1635_14689">
<rect width="24" height="24" fill="white" transform="translate(6 6)"/>
</clipPath>
</defs>
</svg>

  </div>

  <!-- Label bawah -->
      <h1 class="text-1xl font-bold">Charging Station</h1>
  <p class="text-sm font-medium text-gray-500 mt-2">Total Lokasi Charging Station</p>
</div>


</div>


<div class="mt-4">
Untuk Maps
</div>

<div class="card bg-white p-4 rounded-xl font-bold">
<h6>Kinerja Motor</h6>
</div>



<div class="grid grid-cols-12 gap-4 mt-4">
  <!-- Kolom 4 -->
  <div class="col-span-4">
    <div class="card bg-white rounded-xl  p-4 shadow" >
      <div class="card-body">
        <h4 class="card-title font-bold text-gray-700">Distribusi Motor</h4>
        <h6 class="text-sm text-gray-500 mb-2">Data Jumlah Distribusi Motor</h6>

       <div id="chart-motor" style="width: 100%; height: 300px; position: relative;"></div>
        <div id="chart-legend-dashboard"  class="legend-wrapper mt-2"></div>
      </div>
    </div>
  </div>

  <!-- Kolom 8 -->
<div class="col-span-8">
  <div class="card bg-white rounded-xl p-4 shadow">
    <div class="card-body" style="display:flex; justify-content:space-between; align-items:center;">
      <h4 class="card-title font-bold text-gray-700">Status Motor</h4>

      <!-- Tombol Filter -->
      <div style="position: relative;">

      </div>
    </div>

    <div id="status-motor" style="width: 100%; position: relative; margin-top: 16px;"></div>
  </div>
</div>

</div>

<div class="grid grid-cols-12 gap-4 mt-4">

  <div class="col-span-12 md:col-span-6">
    <div class="bg-white rounded-xl p-4 shadow">
        <h4 class="font-bold text-gray-700">Distribusi Motor Wilayah Jakarta</h4>

      <div id="distribusi-motor-jakarta" class="w-full relative mt-4"></div>
    </div>
  </div>

  <div class="col-span-12 md:col-span-6">
    <div class="bg-white rounded-xl p-4 shadow">
        <h4 class="font-bold text-gray-700">Disrtibusi Motor Wilayah Luar Jakarta</h4>

      <div id="distribusi-motor-luar-jakarta" class="w-full relative mt-4"></div>
    </div>
  </div>

</div>


<div class="grid grid-cols-12 gap-4 mt-4">
  <!-- Kolom 1 -->
 <div class="col-span-12 md:col-span-6 lg:col-span-4">
  <div class="relative rounded-xl overflow-hidden w-full min-h-[200px] sm:min-h-[250px] lg:min-h-[200px]">
    <img src="{{ asset('images/mybaterai.png') }}"
         class="w-full h-full object-cover"
         alt="Card Motor" style="margin-left:-20px;margin-top:-30px;">

    <div class="absolute inset-0 flex flex-col items-start justify-center px-6 py-6">
      <h5 class="text-lg text-white mt-3">Jumlah baterai Saat Ini</h5>
      <h1 class="text-5xl font-bold text-white mt-3">700</h1>
      <h5 class="text-lg text-white">September 2025</h5>
    </div>
  </div>
</div>

  <!-- Kolom 2 -->
  <div class="col-span-12 md:col-span-6 lg:col-span-4">
    <div class="bg-white rounded-xl p-4 shadow h-64">
      <h4 class="font-bold text-gray-700">Distribusi Motor Wilayah Luar Jakarta 1</h4>
    </div>
  </div>

  <!-- Kolom 3 -->
  <div class="col-span-12 md:col-span-6 lg:col-span-4">
    <div class="bg-white rounded-xl p-4 shadow min-h-[230px]">
      <h4 class="font-bold text-gray-700 mb-2">Detail Keseluruhan Kesehatan Baterai</h4>
      <div id="kesehatan-baterai" class="w-full h-[200px]"></div>
      <div id="keterangan-baterai" class="mt-4"></div>
    </div>
  </div>
</div>





</div>


<div class="grid grid-cols-12 gap-4 mt-4">
  <!-- Kolom kiri -->
  <div class="col-span-12 md:col-span-6 lg:col-span-4">
    <div class="relative rounded-xl overflow-hidden w-full min-h-[250px] sm:min-h-[280px] lg:min-h-[300px]">
      <img src="{{ asset('images/mymitra.png') }}"
           class="w-full h-full object-cover"
           alt="Card Motor" style="margin-left:-20px;margin-top:-30px;">

      <div class="absolute inset-0 flex flex-col items-start justify-center px-6 py-6">
        <h5 class="text-lg text-white mt-3">Jumlah Pendaftaran Saat Ini</h5>
        <h1 class="text-5xl font-bold text-white mt-3">700</h1>
        <h5 class="text-lg text-white">September 2025</h5>
      </div>
    </div>
  </div>

  <!-- Kolom kanan -->
<div class="col-span-12 md:col-span-6 lg:col-span-8">
  <div class="card bg-white rounded-xl p-4 shadow h-[320px]">
    <div class="card-body flex justify-between items-center">
      <h4 class="card-title font-bold text-gray-700">Pendaftaran Mitra Baru</h4>
      <!-- Tombol Filter -->
      <div style="position: relative;"></div>
    </div>
    <!-- Chart container fix height -->
    <div id="pendaftaran-mitra-baru" class="w-full h-[300px] mt-2"></div>
  </div>

</div>





</div>

  <div class="grid grid-cols-12 gap-4 mt-4">
  <!-- Kolom kiri -->
  <div class="col-span-12 md:col-span-6 lg:col-span-4">
    <div class="relative rounded-xl overflow-hidden w-full min-h-[250px] sm:min-h-[280px] lg:min-h-[300px]">
      <img src="{{ asset('images/mitra-berenti.png') }}"
           class="w-full h-full object-cover"
           alt="Card Motor" style="margin-left:-20px;margin-top:-30px;">

      <div class="absolute inset-0 flex flex-col items-start justify-center px-6 py-6">
        <h5 class="text-lg text-white mt-3">Jumlah Mitra Berhenti</h5>
        <h1 class="text-5xl font-bold text-white mt-3">700</h1>
        <h5 class="text-lg text-white">September 2025</h5>
      </div>
    </div>
  </div>

  <!-- Kolom kanan -->
<div class="col-span-12 md:col-span-6 lg:col-span-8">
  <div class="card bg-white rounded-xl p-4 shadow h-[320px]">
    <div class="card-body flex justify-between items-center">
      <h4 class="card-title font-bold text-gray-700">Pendaftaran Mitra Baru</h4>
      <!-- Tombol Filter -->
      <div style="position: relative;"></div>
    </div>
    <!-- Chart container fix height -->
    <div id="jumlah-mitra-berenti" class="w-full h-[300px] mt-2"></div>
  </div>

</div>

</div>
@endsection

@push('scripts')
<script>


// chart motor
document.addEventListener("DOMContentLoaded", function () {
    const mitra = 65;
    const bengkel = 25;
    const stok = 10;
    const total = mitra + bengkel + stok;

    const seriesData = [
        { name: "Mitra", y: mitra, color: "#F86624" },   // oren
        { name: "Bengkel", y: bengkel, color: "#000000" }, // hitam
        { name: "Stok", y: stok, color: "#B0B0B0" },     // abu-abu
    ].map(point => ({
        ...point,
        y: point.y === 0 ? 0.1 : point.y,
        color: point.y === 0 ? "rgba(211, 211, 211, 0.5)" : point.color
    }));

    Highcharts.chart("chart-motor", {
        chart: {
            type: "pie",
            height: 250,
            marginBottom: 0,
            events: {
                render() {
                    const chart = this;
                    const centerX = chart.plotLeft + chart.plotWidth / 2;
                    const centerY = chart.plotTop + chart.plotHeight / 2;

                    if (!chart.customLabel) {
                        chart.customLabel = chart.renderer.text(
                            `${total}<br>Total`,
                            centerX,
                            centerY
                        ).attr({ align: "center" })
                        .css({
                            color: "#000",
                            fontSize: "16px",
                            fontWeight: "bold",
                            textAlign: "center"
                        }).add();
                    }

                    chart.customLabel.attr({
                        text: `${total}<br>Total`,
                        x: centerX,
                        y: centerY,
                        align: "center"
                    }).css({ textAlign: "center" });
                },
                redraw() {
                    const chart = this;
                    if (chart.customLabel) {
                        const centerX = chart.plotLeft + chart.plotWidth / 2;
                        const centerY = chart.plotTop + chart.plotHeight / 2;
                        chart.customLabel.attr({ x: centerX, y: centerY });
                    }
                }
            }
        },
        title: { text: "" },
        credits: { enabled: false }, // <<< menghilangkan Highcharts.com watermark
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">\u25CF</span> {point.name}: <b>{point.y}</b> Unit ({point.percentage:.1f}%)<br/>'
        },
        legend: { enabled: false },
        plotOptions: {
            pie: {
                innerSize: "75%",
                dataLabels: { enabled: false }
            }
        },
        series: [{
            name: "Kategori",
            colorByPoint: true,
            data: seriesData
        }]
    });

    // Custom legend kiri-kanan
    const legendContainer = document.getElementById("chart-legend-dashboard");
    if (legendContainer) {
        legendContainer.innerHTML = seriesData.map((point, index) => {
            const percent = ((point.y / total) * 100).toFixed(1);
            const id = `legend-point-${index}`;
            return `
                <div class="legend-item" data-index="${index}" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                    <div class="legend-left" style="display:flex; align-items:center; cursor: pointer;">
                        <span id="${id}" class="legend-color" style="width:10px; height:10px; border-radius:50%; background: ${point.color}; margin-right:8px;"></span>
                        <span class="legend-label" style="font-size:14px;">${point.name}</span>
                    </div>
                    <div class="legend-right" style="display:flex; gap:8px; align-items:center;">
                        <span class="legend-value" style="font-size:14px; color:#333;">${point.y}</span>
                        <span class="legend-value" style="font-size:12px; background: ${point.color}; color: white; padding: 2px 6px; border-radius:4px;">${percent}%</span>
                    </div>
                </div>
            `;
        }).join("");
    }

    // Klik legend untuk show/hide slice
    seriesData.forEach((_, index) => {
        const dot = document.getElementById(`legend-point-${index}`);
        if (dot) {
            dot.addEventListener('click', () => {
                const chart = Highcharts.charts.find(c => c && c.renderTo.id === "chart-motor");
                if (chart) {
                    const point = chart.series[0].data[index];
                    point.setVisible(!point.visible);
                }
            });
        }
    });
});

// end chart motor


// chart status motor
function renderChart(targetId, categories, dataOnline, dataOffline) {
  Highcharts.chart(targetId, {
    chart: { type: 'column' },
    title: { text: '' },
    subtitle: { text: '', align: 'left' },
    xAxis: { categories: categories },
    yAxis: { allowDecimals: false, min: 0, title: { text: '' } },
    tooltip: {
      headerFormat: '<b>{point.key}</b><br/>',
      pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
    },
    plotOptions: { column: { stacking: 'normal', pointWidth: 20 } },
    series: [
      { name: 'Motor Online', data: dataOnline, color: '#F86624', stack: 'Motor' },
      { name: 'Motor Offline', data: dataOffline, color: '#B0B0B0', stack: 'Motor' }
    ],
    credits: { enabled: false }
  });
}


// Chart Status Motor
const categoriesStatus = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
renderChart('status-motor', categoriesStatus, [20,25,18,22,24,15,10], [5,3,8,4,6,2,1]);

// Chart Distribusi Motor Jakarta
const categoriesDistribusi = ['Jakarta Selatan','Jakarta Timur','Jakarta Pusat','Jakarta Barat','Jakarta Utara'];
renderChart('distribusi-motor-jakarta', categoriesDistribusi, [10,20,15,25,18], [5,8,6,10,7]);

// Distribusi Motor Luar Jakarta
const categoriesDistribusiLj = ['Semarang','Bandung','Surabaya'];
renderChart('distribusi-motor-luar-jakarta', categoriesDistribusiLj, [10,20,15], [5,8,6]);

// Data default (kalau mau dipakai ulang di kemudian hari)
let defaultOnline = [20, 25, 18, 22, 24, 15, 10];
let defaultOffline = [5, 3, 8, 4, 6, 2, 1];



//  kesehatan baterai
document.addEventListener("DOMContentLoaded", function () {
    const baik = 65;
    const butuhPengecekan = 20;
    const buruk = 15;
    const total = baik + butuhPengecekan + buruk;

    const seriesData = [
        { name: 'Baik', y: baik, color: '#27AE60', drilldown: 'Baik' },
        { name: 'Butuh Pengecekan', y: butuhPengecekan, color: '#F2C94C', drilldown: 'Butuh Pengecekan' },
        { name: 'Buruk', y: buruk, color: '#EB5757', drilldown: 'Buruk' }
    ];

    Highcharts.chart('kesehatan-baterai', {
        chart: { type: 'pie' },
        title: { text: '' },
        subtitle: { text: '' },
        credits: { enabled: false }, // hapus watermark Highcharts.com
        accessibility: { announceNewData: { enabled: true }, point: { valueSuffix: '%' } },
  plotOptions: {
    pie: {
        borderRadius: 5,
        allowPointSelect: true,
        dataLabels: [{
            enabled: false
        }, {
            enabled: true,
            distance: '-30%',
            filter: { property: 'percentage', operator: '>', value: 5 },
            format: '{point.percentage:.0f}%',
            style: { fontSize: '0.9em', textOutline: 'none' }
        }]
    }
},
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.percentage:.1f}%</b> of total<br/>'
        },
        series: [{ name: 'Baterai', colorByPoint: true, data: seriesData }],
        drilldown: {
            series: [
                { name: 'Baik', id: 'Baik', data: [['Dept A', 40], ['Dept B', 25]] },
                { name: 'Butuh Pengecekan', id: 'Butuh Pengecekan', data: [['Dept A', 10], ['Dept B', 10]] },
                { name: 'Buruk', id: 'Buruk', data: [['Dept A', 5], ['Dept B', 10]] }
            ]
        },
        navigation: { breadcrumbs: { buttonTheme: { style: { color: '#27AE60' } } } }
    });

    // Keterangan bawah grafik
    const legendContainer = document.getElementById("keterangan-baterai");
    if (legendContainer) {
        legendContainer.innerHTML = seriesData.map((point, index) => {
            const percent = ((point.y / total) * 100).toFixed(0);
            const id = `legend-point-baterai-${index}`;
            return `
                <div class="legend-item" data-index="${index}" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                    <div class="legend-left" style="display:flex; align-items:center; cursor: pointer;">
                        <span id="${id}" class="legend-color" style="width:10px; height:10px; border-radius:50%; background: ${point.color}; margin-right:8px;"></span>
                        <span class="legend-label" style="font-size:14px;">${point.name}</span>
                    </div>
                    <div class="legend-right" style="display:flex; gap:8px; align-items:center;">
                        <span class="legend-value" style="font-size:14px; color:#333;">${point.y} Orang</span>
                        <span class="legend-value" style="font-size:12px; background: ${point.color}; color: white; padding: 2px 6px; border-radius:4px;">${percent}%</span>
                    </div>
                </div>
            `;
        }).join("");
    }

    // Klik legend untuk show/hide slice
    seriesData.forEach((_, index) => {
        const dot = document.getElementById(`legend-point-baterai-${index}`);
        if (dot) {
            dot.addEventListener('click', () => {
                const chart = Highcharts.charts.find(c => c && c.renderTo.id === "kesehatan-baterai");
                if (chart) {
                    const point = chart.series[0].data[index];
                    point.setVisible(!point.visible);
                }
            });
        }
    });
});


// end kesehatan baterai

// pendaftaran mitra baru


(async () => {
    const data = [29, 35, 40, 50, 65, 70, 55, 60, 72, 68, 58, 0];

    Highcharts.chart('pendaftaran-mitra-baru', {
        chart: {
            zooming: {
                type: 'x',
            },
            height: 300 // <= tinggi chart dalam px
        },
        title: { text: '' },
        subtitle: { text: '' },
        xAxis: {
            categories: [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ]
        },
        yAxis: {
            title: { text: 'Jumlah' }
        },
        legend: { enabled: false },
        plotOptions: {
            area: {
                marker: { radius: 2 },
                lineWidth: 1,
                color: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#FF7401CC'],
                        [1, '#FFFFFF']
                    ]
                },
                states: {
                    hover: { lineWidth: 1 }
                },
                threshold: null
            }
        },
        series: [{
            type: 'area',
            name: 'Data',
            data: data
        }]
    });
})();

// end pendaftaran mitra baru



// jumlah mitra berenti

Highcharts.chart('jumlah-mitra-berenti', {
    chart: {
        type: 'bar',
        height: 360
    },
    title: { text: '' },
    subtitle: { text: '' },
    xAxis: {
        categories: ['Tidak Ada Alasan', 'Keluarga', 'Sakit', 'Pekerjaan Lain', 'Tidak Membayar'],
        title: { text: null },
        lineWidth: 0,
        gridLineWidth: 1,
        gridLineDashStyle: 'Dash',
        gridLineColor: '#ccc'
    },
    yAxis: {
        min: 0,
        title: { text: '', align: 'high' },
        labels: { overflow: 'justify' },
        lineWidth: 0,
        gridLineWidth: 1,
        gridLineDashStyle: 'Dash',
        gridLineColor: '#ccc'
    },
    tooltip: {
        valueSuffix: ' millions'
    },
    plotOptions: {
        bar: {
            dataLabels: { enabled: true },
            groupPadding: 0.3,
            pointPadding: 0.4,
            pointWidth: 28,
            showInLegend: false
        }
    },
    legend: {
        enabled: false
    },
    credits: { enabled: false },
    series: [{
        data: [800, 700, 600, 500, 400],
        showInLegend: false,
        color: '#FF6200'   // 🔥 warna baru
    }]
});


// end mitra berenti
</script>
@endpush
