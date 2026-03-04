<!-- <nav x-data="{ open: false }" class="bg-white border-b border-gray-200 w-full"> -->
<nav class="bg-white border-b border-gray-200 w-full">
   <div class="w-full px-6">
        <div class="flex justify-between h-16 items-center">

            <!-- ===== KIRI ===== -->
            <div class="flex items-center gap-4">

                <!-- Hamburger -->
              <button @click="open = !open" class="p-2">

                    
             <i class="fa-solid fa-lock"></i>
                </button>

                <!-- Greeting -->
                <div class="hidden sm:flex items-center gap-3">
                    <div>
                        <p class="text-lg font-semibold">
                            Hallo {{ session('complete_name') }}
                        </p>
                        <p class="text-sm text-gray-500">
                            Selamat Datang di Halaman {{ session('hak_akses') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- ===== KANAN ===== -->
           <div class="flex items-center ml-auto">

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-white rounded-md hover:text-gray-800 focus:outline-none transition">
                            
                            <img src="{{ session('url_photo') 
                                ? asset('storage/' . session('url_photo')) 
                                : asset('users/admin.png') }}"
                                 class="w-8 h-8 rounded-full mr-2">

                            <div>{{ session('nama_user') }}</div>

                            <div class="ml-2">
                                <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                         this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>

            </div>
        </div>
    </div>

</nav>