

    <!-- Sidebar -->
<aside
    @mouseenter="if (!pinned && !isMobile) open = true"
    @mouseleave="if (!pinned && !isMobile) open = false"
    :class="[open || pinned ? 'w-64' : 'w-20', isMobile && !open ? 'hidden' : '']"
    class="fixed top-0 left-0 h-screen bg-white border-r flex flex-col transition-all duration-300 overflow-hidden"
    style="z-index: 100;"
>

    <!-- HEADER -->
    <div class="flex items-center justify-between h-30 border-b px-4 py-4">
        <a href="{{ route('dashboard') }}" class="flex items-center mx-auto">
            <img src="{{ asset('images/logo-woowdoa.png') }}" 
                 alt="Logo" class="mx-auto mt-6 mb-4"
                 style="width: 80px;"
                 x-show="open" x-transition />

            <img src="{{ asset('images/logo-woowdoa.png') }}" 
                 alt="Logo Mini"
                 class="w-4 mx-auto mt-6 mb-4"
                 x-show="!open" x-transition />
        </a>

        <!-- Toggle Mobile -->
        <button 
            x-show="isMobile" 
            @click.stop="toggleSidebar()" 
            class="p-2 rounded hover:bg-gray-100 ml-2 fixed top-4 z-50 md:hidden"
            style="margin-left:180px;"
        >
            <svg width="20" height="20"><path d="M5 10h10M10 5v10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        </button>
    </div>

    <!-- MENU -->
    <nav class="flex-1 px-2 py-6 space-y-2 overflow-auto">

    @foreach (($menus[0] ?? $menus[null] ?? []) as $parent)

            @php
                $hasChild = isset($menus[$parent->menu_id]);
                $activeParent = $hasChild && collect($menus[$parent->menu_id])
                    ->pluck('menu_link')
                    ->contains(request()->route()->getName());
            @endphp

            {{-- MENU TANPA CHILD --}}
            @if (!$hasChild)
                <a href="{{ Route::has($parent->menu_link) ? route($parent->menu_link) : '#' }}"
                   class="flex items-center px-4 py-2 rounded-lg hover:bg-green-50 hover:text-green-500
                   {{ request()->routeIs($parent->menu_link) ? 'bg-green-600 text-white' : 'text-gray-600' }}">
                   
                    <span class="material-icons mr-3">
                        <i class="{{ $parent->menu_icon }}"></i>
                    </span>

                    <span x-show="open" class="transition-all">
                        {{ $parent->menu_label }}
                    </span>
                </a>
            
            {{-- MENU DENGAN CHILD --}}
            @else
            
           <div x-data="{ openDropdown: {{ $activeParent ? 'true' : 'false' }} }"
     class="flex flex-col">

    <!-- PARENT -->
<button 
    @click="openDropdown = !openDropdown"
    class="flex items-center justify-between w-full px-4 py-2 rounded-lg transition
    {{ $activeParent 
        ? 'bg-green-600 text-white' 
        : 'text-gray-600 hover:bg-green-50 hover:text-green-500' }}"
>
        <div class="flex items-center">
            <span class="material-icons mr-3">
                <i class="{{ $parent->menu_icon }}"></i>
            </span>

            <span x-show="open" class="transition-all">
                {{ $parent->menu_label }}
            </span>
        </div>

        <svg :class="{ 'rotate-90': openDropdown }"
             class="w-4 h-4 transition-transform"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 5l7 7-7 7" />
        </svg>
    </button>

    <!-- CHILD -->
    <div x-show="openDropdown"
         x-transition
         class="mt-2 space-y-1 px-4">

        @foreach ($menus[$parent->menu_id] as $child)
            <a href="{{ Route::has($child->menu_link) ? route($child->menu_link) : '#' }}"
               class="block px-4 py-2 rounded-lg hover:bg-green-50 hover:text-green-500 text-sm
               {{ request()->routeIs($child->menu_link) ? 'bg-green-600 text-white' : 'text-gray-600' }}">
                {{ $child->menu_label }}
            </a>
        @endforeach

    </div>

</div>
            @endif

        @endforeach

    </nav>
 <div class="p-4 mb-10 border-t">
            <!-- <div class="text-white p-3 rounded-lg text-center" style="background: linear-gradient(203.18deg, #01AB14 11.82%, #085410 85.47%);">
                <template x-if="open">
                    <div>
                       <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg" class="mx-auto w-8 mb-2">
<rect width="30" height="30" rx="8" fill="white"/>
<g clip-path="url(#clip0_1922_646)">
<path d="M21.75 12C22.5785 12 23.25 12.6716 23.25 13.5V16.5C23.25 17.3285 22.5785 18 21.75 18H20.9536C20.5845 20.9597 18.0597 23.25 15 23.25V21.75C17.4853 21.75 19.5 19.7353 19.5 17.25V12.75C19.5 10.2647 17.4853 8.25 15 8.25C12.5147 8.25 10.5 10.2647 10.5 12.75V18H8.25C7.42157 18 6.75 17.3285 6.75 16.5V13.5C6.75 12.6716 7.42157 12 8.25 12H9.04642C9.41549 9.04027 11.9403 6.75 15 6.75C18.0597 6.75 20.5845 9.04027 20.9536 12H21.75ZM11.8196 17.8387L12.6147 16.5665C13.3062 16.9997 14.1238 17.25 15 17.25C15.8762 17.25 16.6938 16.9997 17.3853 16.5665L18.1805 17.8387C17.2584 18.4162 16.1682 18.75 15 18.75C13.8318 18.75 12.7416 18.4162 11.8196 17.8387Z" fill="url(#paint0_linear_1922_646)"/>
</g>
<defs>
<linearGradient id="paint0_linear_1922_646" x1="16.7417" y1="6.75" x2="10.4625" y2="21.4167" gradientUnits="userSpaceOnUse">
<stop stop-color="#01AB14"/>
<stop offset="1" stop-color="#085410"/>
</linearGradient>
<clipPath id="clip0_1922_646">
<rect width="18" height="18" fill="white" transform="translate(6 6)"/>
</clipPath>
</defs>
</svg>

                        <p>Ada kendala dalam proses anda?</p>
                    <a href="https://wa.me/628998808839" target="_blank" class="mt-2 bg-white text-green-600 w-full py-2 rounded-lg border border-green-600 hover:bg-green-50 text-center block">
    Hubungi Kami
</a>
                    </div>
                </template>
                <template x-if="!open">
                    <button class="text-white w-full py-2 rounded-lg" style="background: linear-gradient(203.18deg, #FF8F00 11.82%, #FF6200 85.47%);">?</button>
                </template>
            </div> -->
</aside>


    
 <!-- KONTEN UTAMA -->
<div 
  class="flex-1 flex flex-col transition-all duration-300 min-h-screen"
  :style="{
      marginLeft: isMobile 
                  ? '0px' 
                  : (open || pinned ? '256px' : '80px') 
      /* 256px = w-64, 80px = w-20 */
  }"
>
   
</div>

