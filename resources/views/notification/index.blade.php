@extends('layouts.app')

@section('content')
    <div x-data="{
        notifications: [],
        unreadCount: 0,
        visibleCount: 20,
        ws: null,
    
        {{-- dibutuhkan jika notif type lebih dari 1 --}}
        iconConfig: {
            settlement: { icon: 'fa-wallet', bg: 'bg-green-100', color: 'text-green-600' },
            payment: { icon: 'fa-circle-info', bg: 'bg-green-100', color: 'text-green-600' },
            product: { icon: 'fa-book-open', bg: 'bg-green-100', color: 'text-green-600' },
            profile_seen: { icon: 'fa-message', bg: 'bg-green-100', color: 'text-green-600' },
            content: { icon: 'fa-star', bg: 'bg-green-100', color: 'text-green-600' },
        },
    
        getIcon(type) {
            return this.iconConfig[type] || this.iconConfig.settlement;
        },
    
        get visible() {
            return this.notifications.slice(0, this.visibleCount);
        },
    
        loadMore() {
            this.visibleCount += 20;
        },
    
        markRead(id) {
            const notif = this.notifications.find(n => n.id === id);
            if (notif && !notif.isRead) {
                notif.isRead = true;
                if (this.unreadCount > 0) this.unreadCount -= 1;
            }
        },
    
        deleteNotif(id) {
            const notif = this.notifications.find(n => n.id === id);
            if (notif && !notif.isRead && this.unreadCount > 0) this.unreadCount -= 1;
            this.notifications = this.notifications.filter(n => n.id !== id);
        },
    
        formatTimeAgo(dateStr) {
            const date = new Date(dateStr);
            const now = new Date();
            const diff = Math.floor((now - date) / 1000);
            if (diff < 60) return diff + ' detik yang lalu';
            if (diff < 3600) return Math.floor(diff / 60) + ' menit yang lalu';
            if (diff < 86400) return Math.floor(diff / 3600) + ' jam yang lalu';
            if (diff < 2592000) return Math.floor(diff / 86400) + ' hari yang lalu';
            return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        },
    
        init() {
            this.connectWebSocket();
        },
    
        connectWebSocket() {
            const userID = 'e1a0a517-872f-4da2-8eb0-6687eb2f3f51';
            const ws = new WebSocket('wss://erunex.com/ws/?user_id=' + userID);
            this.ws = ws;
    
            let pingInterval;
    
            ws.onopen = () => {
                console.log('WS Connected');
                pingInterval = setInterval(() => {
                    if (ws.readyState === WebSocket.OPEN) {
                        ws.send(JSON.stringify({ type: 'ping' }));
                    }
                }, 20000);
            };
    
            ws.onmessage = (event) => {
                try {
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
                } catch (err) {
                    console.error('WS Parse Error', err);
                }
            };
    
            ws.onclose = () => {
                clearInterval(pingInterval);
                setTimeout(() => this.connectWebSocket(), 3000);
            };
    
            ws.onerror = () => ws.close();
        }
    }" x-init="init()" class="p-6">

{{-- header --}}
        <div class="mb-6">
            <h1 class="text-xl font-bold text-gray-800">Notifikasi Pencairan Dana</h1>
            <p class="text-sm text-gray-400">
                Riwayat notifikasi pencairan dana MErchant
            </p>
        </div>

    {{-- card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
{{-- sub header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-bell text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Semua Notifikasi</p>
                        <p class="text-xs text-gray-400">
                            <span x-show="unreadCount > 0" x-text="unreadCount + ' belum dibaca'"></span>
                            <span x-show="unreadCount === 0">Semua sudah dibaca</span>
                        </p>
                    </div>
                </div>

                {{-- Badge total --}}
                <span class="text-xs bg-green-100 text-green-700 font-semibold px-3 py-1 rounded-full"
                    x-text="notifications.length + ' notifikasi'">
                </span>
            </div>

            {{-- jika kosong --}}
            <div x-show="notifications.length === 0" class="flex flex-col items-center justify-center py-20 text-gray-300">
                <i class="fa-solid fa-bell-slash text-5xl mb-3"></i>
                <p class="text-sm text-gray-400">Belum ada notifikasi pencairan dana</p>
            </div>

            {{-- list notif --}}
            <div x-show="notifications.length > 0" class="divide-y divide-gray-50">
                <template x-for="notif in visible" :key="notif.id">
                    <div :class="!notif.isRead ? 'bg-green-50' : 'hover:bg-gray-50'"
                        class="flex gap-4 px-6 py-4 transition-colors">
                        {{-- Icon --}}
                        <div :class="[getIcon(notif.type).bg, getIcon(notif.type).color]"
                            class="w-11 h-11 rounded-full flex items-center justify-center shrink-0">
                            <i class="fa-solid" :class="getIcon(notif.type).icon"></i>
                        </div>

                        {{-- Konten --}}
                        <div class="flex-1 cursor-pointer" @click="markRead(notif.id)">
                            <div class="flex justify-between items-start">
                                <p :class="!notif.isRead ? 'font-bold text-gray-900' : 'font-medium text-gray-700'"
                                    class="text-sm" x-text="notif.title"></p>

                                {{-- Tombol Hapus --}}
                                <button @click.stop="deleteNotif(notif.id)"
                                    class="text-gray-300 hover:text-red-400 transition-colors ml-3 flex-shrink-0"
                                    title="Hapus notifikasi">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </div>

                            <p class="text-xs text-gray-500 mt-1" x-text="notif.message"></p>
                            <p class="text-xs text-gray-400 mt-1.5" x-text="formatTimeAgo(notif.time)"></p>
                        </div>

                        {{-- Dot unread --}}
                        <div class="flex items-start pt-1">
                            <span x-show="!notif.isRead" class="w-2 h-2 bg-green-500 rounded-full flex-shrink-0"></span>
                        </div>
                    </div>
                </template>
            </div>

            {{-- ===== LOAD MORE ===== --}}
            <div x-show="visibleCount < notifications.length" class="border-t border-gray-50">
                <button @click="loadMore()"
                    class="w-full py-4 text-xs font-bold text-green-600 hover:bg-green-50 transition">
                    Lihat lebih banyak
                </button>
            </div>

        </div>
    </div>
@endsection
