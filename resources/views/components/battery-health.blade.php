{{-- resources/views/components/battery-health.blade.php --}}
<div class="bg-white rounded-xl shadow p-6 w-full max-w-md">
    {{-- Judul --}}
    <h2 class="text-base font-semibold text-gray-800">Rata-Rata Kesehatan Baterai</h2>
    <p class="text-sm text-gray-500 mb-6">Indikasi kesehatan baterai keseluruhan</p>

    <div class="flex items-center justify-between">
        {{-- Icon Baterai --}}
        <div class="relative w-28 h-44 border-4 border-gray-200 rounded-2xl flex items-end justify-center">
            {{-- Kepala baterai --}}
            <div class="absolute -top-4 left-1/2 -translate-x-1/2 w-12 h-4 rounded-md bg-gray-200"></div>
            
            {{-- Isi baterai dinamis (contoh 80%) --}}
            <div 
                class="w-full bg-green-500 rounded-b-lg flex items-center justify-center text-white font-bold text-xl"
                style="height: 80%;">
                80%
            </div>
        </div>

        {{-- Legend --}}
        <div class="space-y-3 ml-6">
            <div class="flex items-center gap-2">
                <span class="w-4 h-4 rounded-full bg-green-500"></span>
                <span class="text-gray-700 text-sm">Baik</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-4 h-4 rounded-full bg-yellow-400"></span>
                <span class="text-gray-700 text-sm">Butuh Pengecekan</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-4 h-4 rounded-full bg-red-500"></span>
                <span class="text-gray-700 text-sm">Buruk</span>
            </div>
        </div>
    </div>
</div>
