@extends('layouts.app')

@section('content')
<div class="py-6">
<div class="container mx-auto w-full">

<!-- Header -->
<h2 class="text-xl font-semibold text-gray-600">Report Reconcile Merchant vs Santri</h2>
<p class="text-gray-500 mb-10">Pencocokan transaksi merchant dengan pembayaran santri</p>

<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4 w-full">

<!-- Form Filter -->
<form 
x-data="{ 
    search: '{{ request('search') }}',
    start_date: '{{ request('start_date') }}',
    end_date: '{{ request('end_date') }}'
}" 
method="GET" 
class="flex flex-col sm:flex-row items-center gap-2 w-full sm:w-auto"
>

<!-- Search -->
<input 
    type="text"
    name="search"
    x-model="search"
    placeholder="Cari Nama Merchant"
    class="w-full sm:w-64 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
/>

<!-- Start Date -->
<input
    type="date"
    name="start_date"
    x-model="start_date"
    class="border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-green-500"
/>

<!-- End Date -->
<input
    type="date"
    name="end_date"
    x-model="end_date"
    class="border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-green-500"
/>

<!-- Button Search -->
<button 
    type="submit"
    :disabled="search.trim() === '' && !start_date && !end_date"
    :class="(search.trim() === '' && !start_date && !end_date)
        ? 'bg-gray-200 text-gray-700 cursor-not-allowed px-4 py-2 rounded-md'
        : 'bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md'"
>
    Cari
</button>

<!-- Reset -->
<a href="{{ route('report.reconcile') }}"
   class="text-green-600 border border-green-600 px-4 py-2 rounded-md hover:bg-green-50 transition">
    Atur Ulang
</a>

</form>

</div>

<!-- Table -->
<div class="overflow-x-auto">

@if($reconcile->count() > 0)

<div class="w-full overflow-x-auto p-4">
<table class="min-w-full bg-white border border-gray-200 divide-y divide-gray-200 table-auto">

<thead class="text-xs text-gray-700 bg-gray-50">
<tr>
<th class="px-4 py-2 border">No</th>
<th class="px-4 py-2 border">Merchant</th>
<th class="px-4 py-2 border">Jumlah Transaksi</th>
<th class="px-4 py-2 border">Total Pendapatan</th>
<th class="px-4 py-2 border">Total Paid</th>
<th class="px-4 py-2 border">Pending</th>
<th class="px-4 py-2 border">Selisih</th>
<th class="px-4 py-2 border">Status</th>
<th class="px-4 py-2 border">Action</th>

</tr>
</thead>

<tbody>

@foreach($reconcile as $i => $row)
<tr class="border-b hover:bg-gray-50">

<td class="px-4 py-3">
{{ $i + 1 }}
</td>

<td class="px-4 py-3">
{{ $row->merchant_name }}
</td>

<td class="px-4 py-3 text-center">
{{ $row->total_transaksi }}
</td>

<td class="px-4 py-3 text-right">
Rp {{ number_format($row->total_amount,0,',','.') }}
</td>

<td class="px-4 py-3 text-right text-green-600">
Rp {{ number_format($row->total_paid,0,',','.') }}
</td>

<td class="px-4 py-3 text-right text-orange-600">
Rp {{ number_format($row->total_pending,0,',','.') }}
</td>

<td class="px-4 py-3 text-right">
Rp {{ number_format($row->total_amount - $row->total_paid,0,',','.') }}
</td>


<td class="px-4 py-3 text-center">

@if(($row->total_amount - $row->total_paid) == 0)

<span class="px-3 py-1 text-sm text-green-600 bg-green-200 rounded-full">
Match
</span>

@else

<span class="px-3 py-1 text-sm text-red-600 bg-red-200 rounded-full">
Selisih
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

</tbody>

</table>
</div>

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