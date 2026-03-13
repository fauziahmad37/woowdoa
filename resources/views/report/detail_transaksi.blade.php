@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="container mx-auto">

        <!-- Header -->
        <h2 class="text-xl font-semibold text-gray-600">Detail Transaksi</h2>
        <p class="text-gray-500 mb-6">Informasi transaksi santri</p>

        <div class="bg-white shadow rounded-lg p-6">

            <!-- Data Santri -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Data Santri</h3>

                <div class="grid grid-cols-2 gap-4 text-sm">

                    <div>
                        <p class="text-gray-500">Nama Santri</p>
                        <p class="font-semibold">
                            {{ $transaction->student->student_name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500">NIS</p>
                        <p class="font-semibold">
                            {{ $transaction->student->nis ?? '-' }}
                        </p>
                    </div>

                </div>
            </div>

            <!-- Data Transaksi -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Informasi Transaksi</h3>

                <div class="grid grid-cols-2 gap-4 text-sm">

                    <div>
                        <p class="text-gray-500">Kode Transaksi</p>
                        <p class="font-semibold">
                            {{ $transaction->transaction_code }}
                        </p>
                    </div>

                   
                    <div>
                        <p class="text-gray-500">Merchant</p>
                        <p class="font-semibold">
                            {{ $transaction->merchant->merchant_name ?? '-' }}
                        </p>
                    </div>

               @php
$detail = $transaction->details->first();
@endphp

 <div>
    <p class="text-gray-500">Jenis Transaksi</p>
    <p class="font-semibold">
        {{ $wallet->type ?? '-' }}
    </p>
</div>

<div>
    <p class="text-gray-500">Jumlah Transaksi</p>
    <p class="font-semibold text-green-600">
        {{ $wallet ? 'Rp '.number_format($wallet->amount,0,',','.') : '-' }}
    </p>
</div>

<div>
    <p class="text-gray-500">Saldo Sebelum</p>
    <p class="font-semibold">
        {{ $wallet ? 'Rp '.number_format($wallet->balance_before,0,',','.') : '-' }}
    </p>
</div>

<div>
    <p class="text-gray-500">Saldo Sesudah</p>
    <p class="font-semibold">
        {{ $wallet ? 'Rp '.number_format($wallet->balance_after,0,',','.') : '-' }}
    </p>
</div>

 <div>
                        <p class="text-gray-500">Keterangan</p>
                        <p class="font-semibold">
                           {{ $detail->description }}
                        </p>
                    </div>


                </div>
            </div>

            <!-- Tombol Kembali -->
            <div class="mt-6">
                <a href="{{ route('report.transaksi_santri') }}"
                   class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-gray-300">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection