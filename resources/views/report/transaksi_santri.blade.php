@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="container mx-auto w-full">

        <!-- Header -->
        <h2 class="text-xl font-semibold text-gray-600">Report Transaksi Santri</h2>
        <p class="text-gray-500 mb-10">Data transaksi santri</p>



        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4 w-full">

            <!-- Form Pencarian -->
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
    placeholder="Cari NIS / Nama"
    class="w-full sm:w-64 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
>

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
<a href="{{ route('report.transaksi_santri') }}"
   class="w-full sm:w-auto text-green-600 border border-green-600 px-4 py-2 rounded-md text-center hover:bg-green-50 transition">
    Atur Ulang
</a>

</form>
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

<a href="{{ route('transaksi.export.excel', request()->query()) }}"
class="block px-4 py-2 text-sm hover:bg-gray-100">
Export Excel
</a>

<a href="{{ route('transaksi.export.pdf', request()->query()) }}"
class="block px-4 py-2 text-sm hover:bg-gray-100">
Export PDF
</a>

</div>

</div>
      
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
                            <th class="px-4 py-2 border">Merchant</th>
                            <th class="px-4 py-2 border">Jumlah</th>
                            <th class="px-4 py-2 border">Tanggal Transaksi</th>
                              <th class="px-4 py-2 border">Status Transaksi</th>
                             <th class="px-4 py-2 border text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        
                        @foreach($transactions as $i => $trx)
                        <tr class="border-b hover:bg-gray-50">

                            <td class="px-4 py-3">
                              {{ ($transactions->currentPage() - 1) * $transactions->perPage() + $i + 1 }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $trx->transaction_code }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $trx->student->student_name ?? '-' }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $trx->merchant->merchant_name ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                Rp {{ number_format($trx->total_amount,0,',','.') }}
                            </td>

<<<<<<< Updated upstream
                          <td class="px-4 py-3">
{{ $trx->paid_at ? \Carbon\Carbon::parse($trx->paid_at)->format('d-m-Y H:i') : '-' }}
</td>
=======
                            <td class="px-4 py-3">
                                {{ $trx->paid_at->format('d-m-Y H:i') }}
                            </td>
>>>>>>> Stashed changes
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
            <a href="{{ route('transaksi.detail', $trx->id) }}"
               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                Detail Transaksi
            </a>

        </div>

    </details>
</td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
 <div class="mt-4">
        {{ $transactions->appends(request()->query())->links() }}
    </div>

            @else
                <div class="text-center py-10 text-gray-500">
                    Data transaksi belum tersedia.
                </div>
            @endif

        </div>

    </div>
</div>
@endsection

@section('scripts')
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