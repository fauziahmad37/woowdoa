@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="container mx-auto w-full">

        <!-- Header -->
        <h2 class="text-xl font-semibold text-gray-600">Daftar Kartu</h2> 

        <!-- Top Bar -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4 w-full">

            <!-- Form Pencarian -->
         <form x-data="{ search: '{{ request('search') }}' }" method="GET" class="flex flex-col sm:flex-row items-center gap-2 w-full sm:w-auto">

    <input 
        type="text"
        name="search"
        x-model="search"
        placeholder="Cari Nama / NIS / Nomor Kartu"
        class="w-full sm:w-64 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
    >

    <button 
        type="submit"
        :disabled="search.trim() === ''"
        :class="search.trim() === '' 
            ? 'bg-gray-200 text-gray-700 cursor-not-allowed px-4 py-2 rounded-md'
            : 'bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md'"
    >
        Cari 
    </button>
<a href="{{ route('cards.report') }}"
   class="w-full sm:w-auto text-green-600 border border-green-600 px-4 py-2 rounded-md text-center hover:bg-green-50 transition">
    Atur Ulang
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

<a href="{{ route('card.export.excel', request()->query()) }}"
class="block px-4 py-2 text-sm hover:bg-gray-100">
Export Excel
</a>

<a href="{{ route('card.export.pdf', request()->query()) }}"
class="block px-4 py-2 text-sm hover:bg-gray-100">
Export PDF
</a>

</div>

</div>
<!-- end export --> 
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">

            @if($cards->count() > 0)

                <div class="w-full overflow-x-auto p-4">
                    <table class="min-w-full bg-white border border-gray-200 divide-y divide-gray-200 table-auto">
                        <thead class="text-xs text-gray-700 bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 border">No </th>
                                <th class="px-4 py-2 border">NIS</th>
                                <th class="px-4 py-2 border">Nama Santri</th>
                                <th class="px-4 py-2 border">Nomor Kartu</th> 
                                <th class="px-4 py-2 border">Terbitan Ke</th> 
                                <th class="px-4 py-2 border">Status</th>  
                                <th class="px-4 py-2 border">Alasan Terbit</th>   
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($cards as $i => $rec)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3  text-center">
                                        {{ ($cards->currentPage() - 1) * $cards->perPage() + $i + 1 }}
                                    </td>
                                    <td class="px-4 py-3 text-left">{{ $rec->nis }}</td>
                                    <td class="px-4 py-3 text-left">{{ $rec->student->student_name }}</td> 
                                    <td class="px-4 py-3 text-left">{{ $rec->card_number }}</td> 
                                    <td class="px-4 py-3 text-center">{{ $rec->sequence }}</td> 
                                <td class="px-4 py-3 text-center">
    <span class="px-2 py-1 rounded-full text-xs font-semibold
        {{ $rec->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
        {{ $rec->status }}
    </span>
</td> 
                                    <td class="px-4 py-3 text-left">{{ $rec->reason }}</td>    
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $cards->links() }}
                    </div>
                </div>

            @else
                <div class="text-center py-10 text-gray-500">
                    Data kartu santri belum tersedia.
                </div>
            @endif

        </div>
    </div>
</div>

 

@endsection

@section('scripts')
<script>
  
</script>
@endsection

