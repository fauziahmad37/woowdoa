<div class="grid grid-cols-3 gap-6">

    <div class="bg-white shadow rounded-lg p-5">
        <p class="text-gray-500">Jumlah Transaksi</p>
        <p class="text-2xl font-bold">
            {{ number_format($jumlahTransaksi) }}
        </p>
    </div>

    <div class="bg-white shadow rounded-lg p-5">
        <p class="text-gray-500">Value Transaksi</p>
        <p class="text-2xl font-bold text-green-600">
            Rp {{ number_format($valueTransaksi,0,',','.') }}
        </p>
    </div>

    <div class="bg-white shadow rounded-lg p-5">
        <p class="text-gray-500">Transaksi Bulan Ini</p>
        <p class="text-2xl font-bold">
            {{ number_format($jumlahTransaksiBulanIni) }}
        </p>
    </div>

</div>