<div x-data="{
        open: true,
        pinned: true,
        isMobile: window.innerWidth < 768,
        toggleSidebar() {
            if (this.isMobile) {
                this.open = !this.open;
                this.pinned = false;
            } else {
                this.pinned = !this.pinned;
                this.open = this.pinned;
            }
        }
    }"
    x-init="window.addEventListener('resize', () => isMobile = window.innerWidth < 768)"
    class="flex flex-col md:flex-row">

    <!-- Sidebar -->
<aside
  @mouseenter="if (!pinned && !isMobile) open = true"
  @mouseleave="if (!pinned && !isMobile) open = false"
  :class="[open || pinned ? 'w-64' : 'w-20', isMobile && !open ? 'hidden' : '']"
  class="fixed top-0 left-0 h-screen bg-white border-r flex flex-col transition-all duration-300 z-50 overflow-hidden">

        <!-- Header -->
        <div class="flex items-center justify-between h-30 border-b px-4 py-4">
            <a href="{{ route('dashboard') }}" class="flex items-center mx-auto">
                <img src="{{ asset('images/logo-ecoride-home.png') }}" 
                     alt="Logo Ecoride" 
                     class="mx-auto mt-6 mb-4"
                     style="width: 80px;"
                     x-show="open" x-transition />
                <img src="{{ asset('images/logo-ecoride-home.png') }}" 
                     alt="Logo Ecoride Mini"
                     class="w-4 mx-auto mt-6 mb-4"
                     x-show="!open" x-transition />
            </a>

            <!-- Toggle -->

            <!-- Toggle Sidebar Mobile -->
<button 
    x-show="isMobile" 
    @click.stop="toggleSidebar()" 
    class="p-2 rounded hover:bg-gray-100 ml-2 fixed top-4 z-50 md:hidden" style="margin-left:180px;"
>
    <svg width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M5 10h10M10 5v10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    </svg>
</button>

        </div>

        <!-- Menu -->
        <nav class="flex-1 px-2 py-6 space-y-2 overflow-auto">

            <!-- Beranda -->
            <a href="{{ route('dashboard') }}"
               class="flex items-center px-4 py-2 rounded-lg hover:bg-orange-50 hover:text-orange-500 
               {{ request()->routeIs('dashboard') ? 'bg-orange-500 text-white' : 'text-gray-600' }}">
                <span class="material-icons mr-3">
                    <svg width="20" height="17" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.6667 15.6667C16.6667 16.1269 16.2936 16.5 15.8334 16.5H4.16671C3.70647 16.5 3.33337 16.1269 3.33337 15.6667V8.16669H0.833374L9.43946 0.342939C9.75729 0.0539811 10.2428 0.0539811 10.5606 0.342939L19.1667 8.16669H16.6667V15.6667ZM7.16011 10.5067L6.3342 10.9835L7.16812 12.4278L7.99529 11.9502C8.32301 12.2597 8.72254 12.4942 9.16621 12.626V13.5797H10.834V12.626C11.2776 12.4941 11.6771 12.2596 12.0048 11.9501L12.832 12.4277L13.6659 10.9834L12.84 10.5065C12.8914 10.2899 12.9185 10.0639 12.9185 9.83152C12.9185 9.59911 12.8914 9.37311 12.8399 9.15644L13.6659 8.67952L12.832 7.23523L12.0047 7.71286C11.677 7.40336 11.2775 7.16889 10.8339 7.03699V6.08334H9.16612V7.03699C8.72246 7.1689 8.32293 7.40336 7.99522 7.71286L7.16807 7.23531L6.3342 8.67961L7.16008 9.15644C7.10866 9.37311 7.08144 9.59911 7.08144 9.83152C7.08144 10.0639 7.10867 10.2899 7.16011 10.5067ZM10 11.0809C9.30921 11.0809 8.74921 10.5215 8.74921 9.83152C8.74921 9.14152 9.30921 8.58211 10 8.58211C10.6908 8.58211 11.2508 9.14152 11.2508 9.83152C11.2508 10.5215 10.6908 11.0809 10 11.0809Z"/>
                    </svg>
                </span>
                <span x-show="open" class="transition-all">Beranda</span>
            </a>

            <!-- Profil Motor Dropdown -->
           <div x-data="{ openDropdown: false }" class="relative">
    <button 
        @click="openDropdown = !openDropdown"
        class="flex items-center justify-between w-full px-4 py-2 rounded-lg hover:bg-orange-50 hover:text-orange-500
               {{ request()->routeIs('laporan.*') ? 'bg-orange-500 text-white' : 'text-gray-600' }}">
        <div class="flex items-center">
            <span class="material-icons mr-3">
<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M13.3735 3.125C14.713 3.125 16.1764 4.27994 17.5113 6.02675C18.0213 6.694 18.4628 7.39663 18.7339 7.96229C18.8769 8.26054 18.9708 8.51588 19.0073 8.72847C19.089 9.20425 18.9084 9.6875 18.3018 9.6875L18.1129 9.68312C18.0196 9.6781 17.897 9.66757 17.6528 9.64602C17.018 9.58999 16.5411 9.59293 16.0515 9.70116L16.2225 10.0682C16.4329 10.0235 16.6512 10 16.875 10C18.6009 10 20 11.3991 20 13.125C20 14.8509 18.6009 16.25 16.875 16.25C15.1491 16.25 13.75 14.8509 13.75 13.125C13.75 12.0684 14.2744 11.1343 15.0771 10.5687L14.8948 10.1777C14.634 10.3764 14.3316 10.6905 13.8977 11.1976L13.3452 11.8564L13.0839 12.1634C12.156 13.2342 11.5429 13.7081 10.7527 13.7473L10.6438 13.75L6.18734 13.7507C5.89751 15.1768 4.63659 16.25 3.125 16.25C1.39911 16.25 0 14.8509 0 13.125C0 11.3991 1.39911 10 3.125 10C4.63681 10 5.89788 11.0735 6.18746 12.4999L6.74125 12.5L6.74103 12.4819C6.70991 11.9619 6.4819 11.3972 5.91316 10.7543L5.79483 10.6247C5.72004 10.5453 5.64471 10.4702 5.56882 10.3994C4.70488 9.59331 3.99462 9.39231 2.6775 9.38261L2.31771 9.38303C1.02568 9.38303 0.0594109 7.59758 0.273523 6.66446C0.385235 6.17762 0.749199 6.04553 1.2215 6.04272C1.40055 6.04165 1.59588 6.06109 1.85918 6.10095L2.57873 6.21709C2.65508 6.22792 2.70145 6.23251 2.73616 6.23339L2.75574 6.23349C4.02604 6.21258 5.00354 6.37958 5.90198 6.69846L6.11755 6.77982C6.37067 6.87842 6.70314 7.0142 6.81526 7.05588L6.90063 7.08621C6.91181 7.09104 6.91631 7.09429 6.91715 7.09684L6.91625 7.09812L7.07379 6.96387C7.94774 6.22716 8.53268 5.91406 9.1861 5.78021L9.30219 5.7584C10.1415 5.61452 10.992 5.63802 11.8435 5.78155L12.0106 5.81187L11.2066 4.56007C11.1323 4.44255 11.0784 4.35518 11.0344 4.28097L10.9652 4.1597C10.9456 4.12339 10.9292 4.09062 10.9153 4.0597C10.8849 3.99205 10.8641 3.93179 10.8526 3.85028C10.8089 3.53787 10.9737 3.17378 11.3913 3.12948L11.4783 3.125L13.3735 3.125ZM11.875 8.125H9.375C9.02982 8.125 8.75 8.40482 8.75 8.75C8.75 9.09518 9.02982 9.375 9.375 9.375H11.875C12.2202 9.375 12.5 9.09518 12.5 8.75C12.5 8.40482 12.2202 8.125 11.875 8.125Z" fill="currentColor"/>
</svg>
</span>

            <span x-show="open" class="transition-all">Profil Motor</span>
        </div>
        <svg :class="{ 'rotate-90': openDropdown }" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    <!-- Dropdown Content -->
    <div 
        x-show="openDropdown"
        @click.away="openDropdown = false"
        x-transition
        class="mt-2 space-y-1 px-4"
    >
     
        <a href="{{route('jenis_asuransi.index')}}"
           class="block px-4 py-2 rounded-lg hover:bg-orange-50 hover:text-orange-500
                  {{ request()->routeIs('jenis_asuransi.index') ? 'bg-orange-500 text-white' : 'text-gray-600' }}">
           Master Jenis Asuransi
        </a>
        <a href="{{ route('motor.index') }}"
           class="block px-4 py-2 rounded-lg hover:bg-orange-50 hover:text-orange-500
                  {{ request()->routeIs('motor.index') ? 'bg-orange-500 text-white' : 'text-gray-600' }}">
            Profil Motor
        </a>
    </div>
</div>

            <!-- Profil Mitra Dropdown -->
        <div x-data="{ openDropdown: false }" class="relative">
    <button 
        @click="openDropdown = !openDropdown"
        class="flex items-center justify-between w-full px-4 py-2 rounded-lg hover:bg-orange-50 hover:text-orange-500
               {{ request()->routeIs('mitra.*') ? 'bg-orange-500 text-white' : 'text-gray-600' }}">
        <div class="flex items-center">
        <svg class="material-icons mr-3" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M8.99996 8.16669C11.3011 8.16669 13.1666 10.0322 13.1666 12.3334V17.3334H11.5V12.3334C11.5 11.0019 10.4592 9.9136 9.14688 9.8376L8.99996 9.83335C7.66854 9.83335 6.58024 10.8741 6.5042 12.1864L6.49996 12.3334V17.3334H4.83329V12.3334C4.83329 10.0322 6.69878 8.16669 8.99996 8.16669ZM3.58329 10.6667C3.81567 10.6667 4.0417 10.6939 4.25838 10.7452C4.11831 11.1617 4.03223 11.6017 4.00743 12.0578L3.99996 12.3334L4.00054 12.4047C3.90627 12.3714 3.8068 12.3489 3.70368 12.3391L3.58329 12.3334C2.93354 12.3334 2.39958 12.8291 2.33902 13.4629L2.33329 13.5834V17.3334H0.666626V13.5834C0.666626 11.9725 1.97246 10.6667 3.58329 10.6667ZM14.4166 10.6667C16.0275 10.6667 17.3333 11.9725 17.3333 13.5834V17.3334H15.6666V13.5834C15.6666 12.9336 15.1709 12.3997 14.537 12.3391L14.4166 12.3334C14.2706 12.3334 14.1305 12.3584 14.0002 12.4044L14 12.3334C14 11.7786 13.9096 11.245 13.7429 10.7464C13.9582 10.6939 14.1842 10.6667 14.4166 10.6667ZM3.58329 5.66669C4.73388 5.66669 5.66663 6.59943 5.66663 7.75002C5.66663 8.9006 4.73388 9.83335 3.58329 9.83335C2.4327 9.83335 1.49996 8.9006 1.49996 7.75002C1.49996 6.59943 2.4327 5.66669 3.58329 5.66669ZM14.4166 5.66669C15.5672 5.66669 16.5 6.59943 16.5 7.75002C16.5 8.9006 15.5672 9.83335 14.4166 9.83335C13.266 9.83335 12.3333 8.9006 12.3333 7.75002C12.3333 6.59943 13.266 5.66669 14.4166 5.66669ZM3.58329 7.33335C3.35318 7.33335 3.16663 7.51994 3.16663 7.75002C3.16663 7.9801 3.35318 8.16669 3.58329 8.16669C3.81341 8.16669 3.99996 7.9801 3.99996 7.75002C3.99996 7.51994 3.81341 7.33335 3.58329 7.33335ZM14.4166 7.33335C14.1865 7.33335 14 7.51994 14 7.75002C14 7.9801 14.1865 8.16669 14.4166 8.16669C14.6467 8.16669 14.8333 7.9801 14.8333 7.75002C14.8333 7.51994 14.6467 7.33335 14.4166 7.33335ZM8.99996 0.666687C10.8409 0.666687 12.3333 2.15907 12.3333 4.00002C12.3333 5.84097 10.8409 7.33335 8.99996 7.33335C7.15901 7.33335 5.66663 5.84097 5.66663 4.00002C5.66663 2.15907 7.15901 0.666687 8.99996 0.666687ZM8.99996 2.33335C8.07946 2.33335 7.33329 3.07955 7.33329 4.00002C7.33329 4.9205 8.07946 5.66669 8.99996 5.66669C9.92046 5.66669 10.6666 4.9205 10.6666 4.00002C10.6666 3.07955 9.92046 2.33335 8.99996 2.33335Z" fill="currentColor">
</svg>
            <span x-show="open" class="transition-all">Profil Mitra</span>
        </div>
        <svg :class="{ 'rotate-90': openDropdown }" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    <!-- Dropdown Content -->
    <div 
        x-show="openDropdown"
        @click.away="openDropdown = false"
        x-transition
        class="mt-2 space-y-1 px-4"
    >
     
        <a href="{{ route('pekerjaan.index') }}"
           class="block px-4 py-2 rounded-lg hover:bg-orange-50 hover:text-orange-500
                  {{ request()->routeIs('pekerjaan.index') ? 'bg-orange-500 text-white' : 'text-gray-600' }}">
           Master Pekerjaan
        </a>
        <a href="{{ route('mitra.index') }}"
           class="block px-4 py-2 rounded-lg hover:bg-orange-50 hover:text-orange-500
                  {{ request()->routeIs('mitra.index') ? 'bg-orange-500 text-white' : 'text-gray-600' }}">
            Profil Mitra
        </a>
    </div>
</div>

            <!-- Pembayaran -->
         


<a href="{{route('pembayaran.index')}}"
   class="flex items-center px-4 py-2 rounded-lg hover:bg-orange-50 hover:text-orange-500 
   {{ request()->routeIs('pembayaran.index') ? 'bg-orange-500 text-white' : 'text-gray-600' }}">
<svg  class="material-icons mr-3" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M18.3375 5.83315H19.1708V14.1665H18.3375V16.6665C18.3375 17.1267 17.9644 17.4998 17.5041 17.4998H2.50411C2.04388 17.4998 1.67078 17.1267 1.67078 16.6665V3.33315C1.67078 2.87291 2.04388 2.49982 2.50411 2.49982H17.5041C17.9644 2.49982 18.3375 2.87291 18.3375 3.33315V5.83315ZM16.6708 14.1665H11.6708C9.36963 14.1665 7.50411 12.301 7.50411 9.99982C7.50411 7.69862 9.36963 5.83315 11.6708 5.83315H16.6708V4.16648H3.33744V15.8332H16.6708V14.1665ZM17.5041 12.4998V7.49982H11.6708C10.29 7.49982 9.17079 8.61907 9.17079 9.99982C9.17079 11.3805 10.29 12.4998 11.6708 12.4998H17.5041ZM11.6708 9.16649H14.1708V10.8332H11.6708V9.16649Z" fill="currentColor">
</svg>
    </span>
    <span x-show="open" class="transition-all">Pembayaran</span>
</a>


<!-- <a href="#"
   class="flex items-center px-4 py-2 rounded-lg hover:bg-orange-50 hover:text-orange-500 
   {{ request()->routeIs('') ? 'bg-orange-500 text-white' : 'text-gray-600' }}">
<svg class="material-icons mr-3" width="16" height="19" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M8 16.4163L12.1248 12.2914C14.4028 10.0134 14.4028 6.31995 12.1248 4.0419C9.84675 1.76384 6.15327 1.76384 3.87521 4.0419C1.59715 6.31995 1.59715 10.0134 3.87521 12.2914L8 16.4163ZM8 18.7733L2.6967 13.47C-0.232233 10.541 -0.232233 5.79232 2.6967 2.86339C5.62563 -0.0655463 10.3743 -0.0655463 13.3033 2.86339C16.2323 5.79232 16.2323 10.541 13.3033 13.47L8 18.7733ZM7.16667 7.33335V4.83335H8.83333V7.33335H11.3333V9.00002H8.83333V11.5H7.16667V9.00002H4.66667V7.33335H7.16667Z" fill="currentColor">
</svg>
    </span>
    <span x-show="open" class="transition-all">Lokasi Motor</span>
</a> -->

            <!-- Bantuan SOS -->



          <a href="{{ route('sos.index') }}"
   class="flex items-center px-4 py-2 rounded-lg hover:bg-orange-50 hover:text-orange-500 
   {{ request()->routeIs('sos.index') ? 'bg-orange-500 text-white' : 'text-gray-600' }}">
<svg class="material-icons mr-3" width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M1.33338 15.6667V10.6667C1.33338 6.98479 4.31815 4.00002 8.00004 4.00002C11.682 4.00002 14.6667 6.98479 14.6667 10.6667V15.6667H15.5V17.3334H0.500047V15.6667H1.33338ZM3.00005 15.6667H13V10.6667C13 7.90527 10.7615 5.66669 8.00004 5.66669C5.23862 5.66669 3.00005 7.90527 3.00005 10.6667V15.6667ZM7.16671 0.666687H8.83337V3.16669H7.16671V0.666687ZM14.4819 3.00636L15.6604 4.18488L13.8926 5.95265L12.7141 4.77413L14.4819 3.00636ZM0.339722 4.18488L1.51823 3.00636L3.286 4.77413L2.10749 5.95265L0.339722 4.18488ZM3.83338 10.6667C3.83338 8.36552 5.69886 6.50002 8.00004 6.50002V8.16669C6.61937 8.16669 5.50005 9.28594 5.50005 10.6667H3.83338Z" fill="currentColor">
</svg>
    </span>
    <span x-show="open" class="transition-all">Bantuan SOS</span>
</a>
            <!-- Serah Terima -->
          <a href="{{ route('serah_terima.index') }}"
   class="flex items-center px-4 py-2 rounded-lg hover:bg-orange-50 hover:text-orange-500 
   {{ request()->routeIs('serah_terima.index') ? 'bg-orange-500 text-white' : 'text-gray-600' }}">
<svg  class="material-icons mr-3" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M17.5 6.66669V10H15.8333V7.50002H11.6667V3.33335H4.16667V16.6667H9.16667V18.3334H3.32783C2.87079 18.3334 2.5 17.9634 2.5 17.5069V2.49319C2.5 2.04611 2.87392 1.66669 3.33518 1.66669H12.4973L17.5 6.66669ZM11.4881 12.7724C11.5205 12.1664 11.9882 11.6736 12.5917 11.6094L13.3172 11.5324C13.4034 11.5233 13.4846 11.4871 13.5491 11.4292L14.0918 10.9416C14.5433 10.5359 15.2224 10.5182 15.6945 10.8996L16.2621 11.3582C16.3295 11.4126 16.4124 11.4444 16.499 11.4491L17.2276 11.4881C17.8336 11.5205 18.3264 11.9882 18.3906 12.5917L18.4676 13.3173C18.4768 13.4034 18.5129 13.4846 18.5708 13.5491L19.0584 14.0919C19.4641 14.5433 19.4818 15.2224 19.1004 15.6945L18.6418 16.2621C18.5874 16.3295 18.5556 16.4124 18.5509 16.499L18.5119 17.2276C18.4795 17.8336 18.0118 18.3264 17.4083 18.3906L16.6827 18.4676C16.5966 18.4768 16.5154 18.5129 16.4509 18.5709L15.9082 19.0584C15.4567 19.4641 14.7776 19.4819 14.3055 19.1004L13.7379 18.6419C13.6705 18.5874 13.5876 18.5556 13.501 18.5509L12.7724 18.5119C12.1664 18.4795 11.6736 18.0119 11.6094 17.4084L11.5324 16.6828C11.5232 16.5966 11.4871 16.5154 11.4292 16.4509L10.9416 15.9082C10.5359 15.4568 10.5182 14.7775 10.8996 14.3055L11.3582 13.7379C11.4126 13.6705 11.4444 13.5876 11.4491 13.501L11.4881 12.7724ZM17.5252 14.1919L16.6414 13.3081L14.5833 15.3661L13.3586 14.1414L12.4747 15.0253L14.5833 17.1339L17.5252 14.1919Z" fill="currentColor">
</svg>

    </span>
    <span x-show="open" class="transition-all">Serah Terima</span>
</a>


<!-- station -->


          <a href="{{ route('station.index') }}"
   class="flex items-center px-4 py-2 rounded-lg hover:bg-orange-50 hover:text-orange-500 
   {{ request()->routeIs('station.index') ? 'bg-orange-500 text-white' : 'text-gray-600' }}">
<svg  class="material-icons mr-3" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M17.5 6.66669V10H15.8333V7.50002H11.6667V3.33335H4.16667V16.6667H9.16667V18.3334H3.32783C2.87079 18.3334 2.5 17.9634 2.5 17.5069V2.49319C2.5 2.04611 2.87392 1.66669 3.33518 1.66669H12.4973L17.5 6.66669ZM11.4881 12.7724C11.5205 12.1664 11.9882 11.6736 12.5917 11.6094L13.3172 11.5324C13.4034 11.5233 13.4846 11.4871 13.5491 11.4292L14.0918 10.9416C14.5433 10.5359 15.2224 10.5182 15.6945 10.8996L16.2621 11.3582C16.3295 11.4126 16.4124 11.4444 16.499 11.4491L17.2276 11.4881C17.8336 11.5205 18.3264 11.9882 18.3906 12.5917L18.4676 13.3173C18.4768 13.4034 18.5129 13.4846 18.5708 13.5491L19.0584 14.0919C19.4641 14.5433 19.4818 15.2224 19.1004 15.6945L18.6418 16.2621C18.5874 16.3295 18.5556 16.4124 18.5509 16.499L18.5119 17.2276C18.4795 17.8336 18.0118 18.3264 17.4083 18.3906L16.6827 18.4676C16.5966 18.4768 16.5154 18.5129 16.4509 18.5709L15.9082 19.0584C15.4567 19.4641 14.7776 19.4819 14.3055 19.1004L13.7379 18.6419C13.6705 18.5874 13.5876 18.5556 13.501 18.5509L12.7724 18.5119C12.1664 18.4795 11.6736 18.0119 11.6094 17.4084L11.5324 16.6828C11.5232 16.5966 11.4871 16.5154 11.4292 16.4509L10.9416 15.9082C10.5359 15.4568 10.5182 14.7775 10.8996 14.3055L11.3582 13.7379C11.4126 13.6705 11.4444 13.5876 11.4491 13.501L11.4881 12.7724ZM17.5252 14.1919L16.6414 13.3081L14.5833 15.3661L13.3586 14.1414L12.4747 15.0253L14.5833 17.1339L17.5252 14.1919Z" fill="currentColor">
</svg>

    </span>
    <span x-show="open" class="transition-all">Station</span>
</a>

        </nav>

        <!-- Tombol Bantuan -->
        <div class="p-4 mb-10 border-t">
            <div class="text-white p-3 rounded-lg text-center" style="background: linear-gradient(203.18deg, #FF8F00 11.82%, #FF6200 85.47%);">
                <template x-if="open">
                    <div>
                       <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg" class="mx-auto w-8 mb-2">
<rect width="30" height="30" rx="8" fill="white"/>
<g clip-path="url(#clip0_1922_646)">
<path d="M21.75 12C22.5785 12 23.25 12.6716 23.25 13.5V16.5C23.25 17.3285 22.5785 18 21.75 18H20.9536C20.5845 20.9597 18.0597 23.25 15 23.25V21.75C17.4853 21.75 19.5 19.7353 19.5 17.25V12.75C19.5 10.2647 17.4853 8.25 15 8.25C12.5147 8.25 10.5 10.2647 10.5 12.75V18H8.25C7.42157 18 6.75 17.3285 6.75 16.5V13.5C6.75 12.6716 7.42157 12 8.25 12H9.04642C9.41549 9.04027 11.9403 6.75 15 6.75C18.0597 6.75 20.5845 9.04027 20.9536 12H21.75ZM11.8196 17.8387L12.6147 16.5665C13.3062 16.9997 14.1238 17.25 15 17.25C15.8762 17.25 16.6938 16.9997 17.3853 16.5665L18.1805 17.8387C17.2584 18.4162 16.1682 18.75 15 18.75C13.8318 18.75 12.7416 18.4162 11.8196 17.8387Z" fill="url(#paint0_linear_1922_646)"/>
</g>
<defs>
<linearGradient id="paint0_linear_1922_646" x1="16.7417" y1="6.75" x2="10.4625" y2="21.4167" gradientUnits="userSpaceOnUse">
<stop stop-color="#FF8F00"/>
<stop offset="1" stop-color="#FF6200"/>
</linearGradient>
<clipPath id="clip0_1922_646">
<rect width="18" height="18" fill="white" transform="translate(6 6)"/>
</clipPath>
</defs>
</svg>

                        <p>Ada kendala dalam proses anda?</p>
                    <a href="https://wa.me/628998808839" target="_blank" class="mt-2 bg-white text-orange-600 w-full py-2 rounded-lg border border-orange-600 hover:bg-orange-50 text-center block">
    Hubungi Kami
</a>


                    </div>
                </template>
                <template x-if="!open">
                    <button class="text-white w-full py-2 rounded-lg" style="background: linear-gradient(203.18deg, #FF8F00 11.82%, #FF6200 85.47%);">?</button>
                </template>
            </div>
        </div>
    </aside>

    <!-- Konten Utama  -->
<div 
  :class="pinned && !isMobile 
           ? (open 
               ? 'ml-64'  <!-- sidebar terbuka -->
               : 'ml-24') <!-- sidebar tertutup tapi tetap ada jarak -->
           : 'ml-6'" 
  class="flex-1 transition-all duration-300">
     @include('layouts.navigation')
    <div class="w-full max-w-full">
        <main class="flex-1 p-4 overflow-auto">
            @yield('content')
        </main>
    </div>
</div>


</div>
