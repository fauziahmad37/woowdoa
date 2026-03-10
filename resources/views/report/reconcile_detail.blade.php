@extends('layouts.app')

@section('content')
<div class="py-6">
<div class="container mx-auto w-full">

<!-- Header -->
<h2 class="text-xl font-semibold text-gray-600">Detail Reconcile Merchant</h2>
<p class="text-gray-500 mb-10">
Daftar transaksi santri pada merchant: 
<span class="font-semibold">{{ $merchant_name ?? '-' }}</span>
</p>

<div class="mb-4">
<a href="{{ route('report.reconcile') }}"
class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
Kembali
</a>
</div>

<!-- Table -->
<div class="overflow-x-auto">

@if($transactions->count() > 0)

<div class="w-full overflow-x-auto p-4">
<table class="min-w-full bg-white border border-gray-200 divide-y divide-gray-200 table-auto">

<thead class="text-xs text-gray-700 bg-gray-50">
<tr>
<th class="px-4 py-2 border">No</th>
<th class="px-4 py-2 border">Kode Transaksi</th>
<th class="px-4 py-2 border">Nama Santri</th>
<th class="px-4 py-2 border">Jumlah</th>
<th class="px-4 py-2 border">Tanggal Transaksi</th>
<th class="px-4 py-2 border">Status</th>
</tr>
</thead>

<tbody>

@foreach($transactions as $i => $trx)
<tr class="border-b hover:bg-gray-50">

<td class="px-4 py-3">
{{ $i + 1 }}
</td>

<td class="px-4 py-3">
{{ $trx->transaction_code }}
</td>

<td class="px-4 py-3">
{{ $trx->student_name }}
</td>

<td class="px-4 py-3 text-right">
Rp {{ number_format($trx->amount,0,',','.') }}
</td>

<td class="px-4 py-3">
{{ \Carbon\Carbon::parse($trx->paid_at)->format('d-m-Y H:i') }}
</td>

<td class="px-4 py-3 text-center">

@if($trx->status == 'pending')
<span class="px-3 py-1 text-sm text-red-600 bg-red-200 rounded-full">
Pending
</span>

@elseif($trx->status == 'paid')
<span class="px-3 py-1 text-sm text-green-600 bg-green-200 rounded-full">
Berhasil
</span>

@else
{{ $trx->status ?? '-' }}
@endif

</td>

</tr>
@endforeach

</tbody>

</table>
</div>

@else

<div class="text-center py-10 text-gray-500">
Tidak ada transaksi untuk merchant ini.
</div>

@endif

</div>

</div>
</div>
@endsection