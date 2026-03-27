<nav x-data="{ open: false }" class="bg-white border-gray-200 w-full">
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
                            Selamat Datang di Halaman {{ Auth::user()->level->user_level_name }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- ===== KANAN ===== -->
            {{-- UBAH: tambah gap-3 agar lonceng dan profile tidak rapat/overlap --}}
            <div class="flex items-center gap-3 ml-auto">

                {{-- TAMBAH: Komponen lonceng notifikasi WebSocket --}}
                <div x-data="{
                    openNotif: false,
                    notifications: [],
                    unreadCount: 0,
                    ws: null,
                
                    init() {
                        this.connectWebSocket();
                    },
                
                    connectWebSocket() {
                        const userID = 'e1a0a517-872f-4da2-8eb0-6687eb2f3f51';
                        const ws = new WebSocket('wss://erunex.com/ws/?user_id=' + userID);
                        this.ws = ws;
                
                        ws.onopen = () => {
                            console.log('WS Connected');
                        };
                
                        ws.onmessage = (event) => {
                            const data = JSON.parse(event.data);
                
                            if (data.type === 'initial_notifications') {
                                this.notifications = data.data.map(n => ({
                                    id: n.id,
                                    type: n.type,
                                    title: n.title,
                                    message: n.message,
                                    time: n.created_at,
                                    isRead: n.is_read,
                                }));
                            }
                
                            if (data.type === 'unread_count') {
                                this.unreadCount = Number(data.count);
                            }
                
                            if (data.type === 'new_notification') {
                                const notif = {
                                    id: data.data.id,
                                    type: data.data.type,
                                    title: data.data.title,
                                    message: data.data.message,
                                    time: data.data.created_at,
                                    isRead: data.data.is_read,
                                };
                                this.notifications.unshift(notif);
                                this.unreadCount += 1;
                            }
                        };
                
                        ws.onclose = () => {
                            console.log('WS Closed');
                            setTimeout(() => this.connectWebSocket(), 3000);
                        };
                
                        ws.onerror = () => {
                            ws.close();
                        };
                    }
                }" x-init="init()" class="relative flex items-center">
                    <!-- Tombol Lonceng -->
                    <button type="button" @click.stop="openNotif = !openNotif"
                        class="relative p-2 text-gray-500 hover:text-gray-700 focus:outline-none transition">
                        <i class="fa-solid fa-bell text-xl"></i>

                        <!-- Badge Merah -->
                        <span x-show="unreadCount > 0" x-text="unreadCount > 99 ? '99+' : unreadCount"
                            class="absolute top-0.5 right-0.5 inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 text-xs font-bold text-white bg-red-500 rounded-full"></span>
                    </button>

                    <!-- Dropdown Panel -->
                    <div x-show="openNotif" @click.outside="openNotif = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="fixed sm:absolute left-2 right-2 sm:left-auto sm:right-0 sm:w-80 top-16 sm:top-10 bg-white rounded-xl shadow-xl border border-gray-200 z-50 sm:origin-top-right"
                        style="display:none">
                        <!-- Header -->
                        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-semibold text-gray-800">Notifikasi</h3>
                                <span x-show="unreadCount > 0" x-text="unreadCount + ' baru'"
                                    class="text-xs bg-red-100 text-red-600 font-medium px-2 py-0.5 rounded-full"></span>
                            </div>
                        </div>

                        <!-- List -->
                        <ul class="max-h-72 overflow-y-auto divide-y divide-gray-100">
                            <template x-for="notif in notifications" :key="notif.id">
                                <li :class="notif.isRead ? 'bg-white' : 'bg-blue-50'"
                                    class="hover:bg-gray-50 transition cursor-pointer">
                                    <div class="flex items-start gap-3 px-4 py-3">
                                        <div
                                            class="w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <i class="fa-solid fa-circle-info text-blue-400 text-sm"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-800" x-text="notif.title"></p>
                                            <p class="text-xs text-gray-500 mt-0.5" x-text="notif.message"></p>
                                            <p class="text-xs text-gray-400 mt-1" x-text="notif.time"></p>
                                        </div>
                                        <span x-show="!notif.isRead"
                                            class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></span>
                                    </div>
                                </li>
                            </template>

                            <!-- Empty -->
                            <li x-show="notifications.length === 0" class="px-4 py-8 text-center text-sm text-gray-400">
                                <i class="fa-solid fa-bell-slash text-2xl mb-2 block"></i>
                                Tidak ada notifikasi
                            </li>
                        </ul>

                        <!-- Footer -->
                        <div class="px-4 py-2.5 border-t border-gray-100 text-center">
                            <a href="{{ route('notifications.index') }}"
                                class="text-xs text-blue-500 hover:underline">Lihat semua notifikasi →</a>
                        </div>
                    </div>
                </div>
                {{-- END TAMBAH: lonceng notifikasi --}}

                <!-- Dropdown Profile — tidak ada perubahan sama sekali -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-white rounded-md hover:text-gray-800 focus:outline-none transition">

                            <img src="{{ session('profile_photo') ? asset('storage/' . session('profile_photo')) : asset('images/user-icon.png') }}"
                                class="w-8 h-8 rounded-full mr-2">

                            <div>{{ session('nama_user') }}</div>

                            <div class="ml-2">
                                <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- komen profile.edit dibiarkan sama persis --}}
                        <!-- <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link> -->

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
