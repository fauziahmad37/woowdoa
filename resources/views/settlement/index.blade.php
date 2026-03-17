@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="container mx-auto w-full">

        <!-- Header -->
        <h2 class="text-xl font-semibold text-gray-600">Daftar Permintaan Settlement</h2> 

        <!-- Top Bar -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4 w-full">

            <!-- Form Pencarian -->
         <form x-data="{ search: '{{ request('search') }}' }" method="GET" class="flex flex-col sm:flex-row items-center gap-2 w-full sm:w-auto">

    <input 
        type="text"
        name="search"
        x-model="search"
        placeholder="Cari"
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
      <a href="{{ route('settlement.index') }}"
                   class="w-full sm:w-auto text-green-600 border border-green-600 px-4 py-2 rounded-md text-center hover:bg-green-50 transition">
                    Atur Ulang
                </a>

</form>
 
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">

            @if($settlement->count() > 0)

                <div class="w-full overflow-x-auto p-4">
                    <table class="min-w-full bg-white border border-gray-200 divide-y divide-gray-200 table-auto">
                        <thead class="text-xs text-gray-700 bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 border">No </th>
                                <th class="px-4 py-2 border">Nama Merchant</th>
                                <th class="px-4 py-2 border">Tanggal</th> 
                                <th class="px-4 py-2 border">Saldo</th> 
                                <th class="px-4 py-2 border">Amount</th> 
                                <th class="px-4 py-2 border">Status</th>  
                                <th class="px-4 py-2 border text-center">Approval</th> 
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($settlement as $i => $rec)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3 text-center">
                                        {{ ($settlement->currentPage() - 1) * $settlement->perPage() + $i + 1 }}
                                    </td> 
                                    <td class="px-4 py-3 text-left">{{ $rec->merchant->merchant_name }}</td>
                                    <td class="px-4 py-3 text-center">{{ $rec->created_at }}</td> 
                                    <td class="px-4 py-3 text-center">{{ $rec->ewallet->balance }}</td> 
                                    <td class="px-4 py-3 text-right">{{ $rec->amount }}</td> 
                                    <td class="px-4 py-3 text-center"> 
																			<span class="px-2 py-1 text-xs font-semibold rounded-full
																					{{ strtolower($rec->status) == 'approved' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
																					{{ $rec->status }}
																			</span>																		
																		</td>  
                                    <td class="px-4 py-3 text-center">													 
																				@if($rec->status == 'pending') 
																				<form action="{{ route('settlement.approve',$rec->id) }}" method="POST">
																				@csrf
																				<button type="submit">Approve</button>
																				</form> 
																				<form action="{{ route('settlement.reject',$rec->id) }}" method="POST">
																				@csrf
																				<button type="submit">Reject</button>
																				</form> 
																				@endif 																
																		</td>   
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $settlement->links() }}
                    </div>
                </div>

            @else
                <div class="text-center py-10 text-gray-500">
                    Data permintaan kartu belum tersedia.
                </div>
            @endif

        </div>
    </div>
</div>


<!-- Modal Delete -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-gray-800 bg-opacity-40" onclick="closeDeleteModal()"></div>

    <div id="deleteModalContent"
         class="relative bg-white rounded-xl shadow-lg p-6 max-w-md w-full transform scale-95 opacity-0 transition-all duration-200">

        <h2 class="text-lg font-semibold text-gray-800">
            Apakah Anda yakin ingin menghapus data ini?
        </h2>

        <div class="mt-6 flex justify-center gap-3">
            <button onclick="closeDeleteModal()"
                    class="px-4 py-2 bg-white text-gray-700 rounded-lg hover:bg-gray-100">
                Batalkan
            </button>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 text-white rounded-lg bg-red-600 hover:bg-red-700">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const deleteModal = document.getElementById('deleteModal');
    const deleteModalContent = document.getElementById('deleteModalContent');
    const deleteForm = document.getElementById('deleteForm');

    function openDeleteModal(id) {
        // Set action form
        deleteForm.action = `/settlement/${id}`;

        // Tampilkan modal
        deleteModal.classList.remove('hidden');
        deleteModal.classList.add('flex');

        // Animasi muncul
        setTimeout(() => {
            deleteModalContent.classList.remove('scale-95', 'opacity-0');
            deleteModalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeDeleteModal() {
        // Animasi keluar
        deleteModalContent.classList.remove('scale-100', 'opacity-100');
        deleteModalContent.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            deleteModal.classList.add('hidden');
            deleteModal.classList.remove('flex');
        }, 200);
    }


    // untuk dropdown
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

