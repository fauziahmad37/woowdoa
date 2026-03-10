

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

