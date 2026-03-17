@extends('layouts.app')

@section('content')
<div class="py-6">
<div class="container mx-auto w-full">

<!-- Header -->
<h2 class="text-xl font-semibold text-gray-600">Report Reconcile Merchant vs Santri</h2>
<p class="text-gray-500 mb-10">Pencocokan transaksi merchant dengan pembayaran santri</p>

<!-- Filter -->
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4 w-full">

<form 
x-data="{ 
    filterType: '{{ request('filter_type', 'merchant_name') }}',
    search: '{{ request('search') }}',
    start_date: '{{ request('start_date') }}',
    end_date: '{{ request('end_date') }}'
}" 
method="GET" 
class="flex flex-col sm:flex-row items-center gap-2 w-full sm:w-auto"
>

<!-- DROPDOWN FILTER -->
<select 
    name="filter_type"
    x-model="filterType"
    class="border border-gray-300 rounded-md px-3 py-2"
>
    <option value="merchant_name">Merchant Name</option>
    <option value="merchant_code">Merchant Code</option>
</select>

<!-- INPUT DINAMIS -->
<input 
    type="text"
    name="search"
    x-model="search"
    :placeholder="filterType === 'merchant_name' 
        ? 'Cari Nama Merchant' 
        : 'Cari Kode Merchant'"
    class="w-full sm:w-64 border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-green-500"
/>

<!-- DATE -->
<input type="date" name="start_date" x-model="start_date"
class="border border-gray-300 rounded-md px-3 py-2">

<input type="date" name="end_date" x-model="end_date"
class="border border-gray-300 rounded-md px-3 py-2">

<!-- BUTTON -->
<button type="submit"
:disabled="search.trim() === '' && !start_date && !end_date"
class="bg-green-600 text-white px-4 py-2 rounded-md">
Cari
</button>

<a href="{{ url()->current() }}"
class="text-green-600 border border-green-600 px-4 py-2 rounded-md">
Reset
</a>

</form>

<!-- export -->

<div x-data="{ open: false }" class="relative inline-block text-left">

<button
@click="open = !open"
class="px-4 py-2 rounded-lg text-white"
style="background: linear-gradient(203.18deg, #01AB14 11.82%, #085410 85.47%);">
Export Excel/PDF
</button>

<div 
x-show="open"
@click.outside="open = false"
class="absolute mt-2 w-40 bg-white border rounded-lg shadow z-50">

<a href="{{ route('reconcile.export.excel', request()->query()) }}"
class="block px-4 py-2 text-sm hover:bg-gray-100">
Export Excel
</a>

<a href="{{ route('reconcile.export.pdf', request()->query()) }}"
class="block px-4 py-2 text-sm hover:bg-gray-100">
Export PDF
</a>

</div>

</div>
<!-- end export -->


</div>

<!-- Table -->
<div class="overflow-x-auto">

@if($reconcile->count() > 0)

@php
$grouped = $reconcile->groupBy('merchant_name');
$no = 1;
@endphp

<table class="min-w-full bg-white border border-gray-200 divide-y divide-gray-200 table-auto">

<thead class="text-xs text-gray-700 bg-gray-50">
<tr>
<th class="px-4 py-2 border">No</th>
<th class="px-4 py-2 border">Merchant</th>
<th class="px-4 py-2 border">Waktu Bayar</th>
<th class="px-4 py-2 border">Kode VA</th>
<th class="px-4 py-2 border">Nama Santri</th>
<th class="px-4 py-2 border">Total Tagihan</th>
<th class="px-4 py-2 border">Total Dibayar</th>
<!-- <th class="px-4 py-2 border">Biaya Admin</th> -->
<th class="px-4 py-2 border">Status Transaksi</th>
<!-- <th class="px-4 py-2 border">Status Settlement</th> -->
<th class="px-4 py-2 border">Rekonsiliasi</th>
<th class="px-4 py-2 border">Action</th>
</tr>
</thead>

<tbody>

@foreach($grouped as $merchant => $rows)

@php
$rowspan = $rows->count();
@endphp

@foreach($rows as $index => $row)

@php
$tagihan = $row->total_amount;
$dibayar = $row->wallet_paid_amount;
@endphp

<tr class="border-b hover:bg-gray-50">

@if($index == 0)

<td class="px-4 py-3 text-center border" rowspan="{{ $rowspan }}">
{{ $no++ }}
</td>

<td class="px-4 py-3 border" rowspan="{{ $rowspan }}">
{{ $merchant }}
</td>

@endif

<td class="px-4 py-3 border">
{{ $row->paid_at }}
</td>

<td class="px-4 py-3 border">
{{ $row->card_number }}
</td>

<td class="px-4 py-3 border">
{{ $row->student_name }}
</td>

<td class="px-4 py-3 border text-right">
Rp {{ number_format($tagihan,0,',','.') }}
</td>

<td class="px-4 py-3 border text-right">
@if($dibayar)
Rp {{ number_format($dibayar,0,',','.') }}
@endif
</td>

<!-- <td class="px-4 py-3 border text-right">
Rp {{ number_format($row->admin_fee,0,',','.') }}
</td> -->

<td class="px-4 py-3 border text-center">

@if(!$row->wallet_id)
<span class="text-yellow-600 font-semibold">Pending</span>

@elseif($row->status == 'paid')
<span class="text-green-600 font-semibold">Success</span>

@else
<span class="text-red-600 font-semibold">Expired</span>
@endif

</td>

<!-- <td class="px-4 py-3 border text-center">
@if($row->status == 'paid')
Settled
@else
Pending
@endif
</td> -->

<td class="px-4 py-3 border text-center">

@if(!$row->wallet_id)

<span class="px-3 py-1 text-xs text-red-600 bg-red-200 rounded-full">
Not Match
</span>

@elseif($tagihan == $dibayar)

<span class="px-3 py-1 text-xs text-green-600 bg-green-200 rounded-full">
Match
</span>

@elseif($dibayar < $tagihan)

<span class="px-3 py-1 text-xs text-yellow-600 bg-yellow-200 rounded-full">
Kurang Bayar
</span>

@else

<span class="px-3 py-1 text-xs text-blue-600 bg-blue-200 rounded-full">
Lebih Bayar
</span>

@endif

</td>

 <td class="px-4 py-4 text-center">
    <details class="inline-block text-left">

        <summary
            class="list-none bg-green-600 hover:bg-green-700 
            text-white cursor-pointer marker:content-none
            w-8 h-8 flex items-center justify-center rounded-full">

            <svg width="13" height="4" viewBox="0 0 13 4" fill="none">
                <path d="M1.83333 0.666016C1.1 0.666016 0.5 1.26602 0.5 1.99935C0.5 2.73268 1.1 3.33268 1.83333 3.33268C2.56667 3.33268 3.16667 2.73268 3.16667 1.99935C3.16667 1.26602 2.56667 0.666016 1.83333 0.666016ZM11.1667 0.666016C10.4333 0.666016 9.83333 1.26602 9.83333 1.99935C9.83333 2.73268 10.4333 3.33268 11.1667 3.33268C11.9 3.33268 12.5 2.73268 12.5 1.99935C12.5 1.26602 11.9 0.666016 11.1667 0.666016ZM6.5 0.666016C5.76667 0.666016 5.16667 1.26602 5.16667 1.99935C5.16667 2.73268 5.76667 3.33268 6.5 3.33268C7.23333 3.33268 7.83333 2.73268 7.83333 1.99935C7.83333 1.26602 7.23333 0.666016 6.5 0.666016Z" fill="white"></path>
            </svg>

        </summary>

        <div class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-xl shadow-lg z-50 overflow-hidden">

            <!-- Detail -->
           <a href="{{ route('report.reconcile.detail', $row->merchant_id) }}"
               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                Detail 
            </a>

        </div>

    </details>
</td>

</tr>

@endforeach
@endforeach

</tbody>
</table>

@else

<div class="text-center py-10 text-gray-500">
Data reconcile belum tersedia.
</div>

@endif

</div>

</div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const allDetails = document.querySelectorAll("details");

    allDetails.forEach((detail) => {

        detail.addEventListener("toggle", function () {

            if (detail.open) {

                allDetails.forEach((otherDetail) => {

                    if (otherDetail !== detail) {
                        otherDetail.removeAttribute("open");
                    }

                });

            }

        });

    });

});
</script>
@endsection