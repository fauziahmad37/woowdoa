@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="container mx-auto w-full">

        <!-- Header -->
        <h2 class="text-xl font-semibold text-gray-600">Daftar Permintaan Kartu</h2> 

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
      <a href="{{ route('cardrequest.index') }}"
                   class="w-full sm:w-auto text-green-600 border border-green-600 px-4 py-2 rounded-md text-center hover:bg-green-50 transition">
                    Atur Ulang
                </a>

</form>

            <!-- Tombol Tambah -->
            <a href="{{ route('cardrequest.create') }}"
               class="px-4 py-2 rounded-lg text-white text-center sm:w-auto w-full"
               style="background: linear-gradient(203.18deg, #01AB14 11.82%, #085410 85.47%);">
                + Tambah Request Kartu
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">

            @if($cardrequest->count() > 0)

                <div class="w-full overflow-x-auto p-4">
                    <table class="min-w-full bg-white border border-gray-200 divide-y divide-gray-200 table-auto">
                        <thead class="text-xs text-gray-700 bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 border">No </th>
                                <th class="px-4 py-2 border">NIS</th>
                                <th class="px-4 py-2 border">Nama Santri</th>
                                <th class="px-4 py-2 border">Pemohon</th>
                                <th class="px-4 py-2 border">Tanggal Request</th>
                                <th class="px-4 py-2 border">Alasan</th>
                                <th class="px-4 py-2 border">Status</th> 
																@if($user_level==1)
                                <th class="px-4 py-2 border text-center">Approval</th>
																@endif 
																@if($user_level==7)
                                <th class="px-4 py-2 border text-center">Aksi</th>
																@endif 
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($cardrequest as $i => $rec)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        {{ ($cardrequest->currentPage() - 1) * $cardrequest->perPage() + $i + 1 }}
                                    </td>
                                    <td class="px-4 py-3 text-right">{{ $rec->nis }}</td>
                                    <td class="px-4 py-3 text-right">{{ $rec->student->student_name }}</td>
                                    <td class="px-4 py-3 text-right">{{ $rec->requester->complete_name }}</td> 
                                    <td class="px-4 py-3 text-right">{{ $rec->created_at->format('d-m-Y') }}</td> 
                                    <td class="px-4 py-3 text-right">{{ $rec->reason }}</td> 
                                    <td class="px-4 py-3 text-right">{{ $rec->status }}</td> 
																		@if($user_level==1)
                                    <td class="px-4 py-3 text-right">
														 
																				@if($rec->status == 'pending') 
																				<form action="{{ route('cardrequest.approve',$rec->id) }}" method="POST">
																				@csrf
																				<button type="submit">Approve</button>
																				</form> 
																				<form action="{{ route('cardrequest.reject',$rec->id) }}" method="POST">
																				@csrf
																				<button type="submit">Reject</button>
																				</form> 
																				@endif 																
																		</td> 
																		@endif 	
																		@if($user_level==7)
                                    <!-- Dropdown Aksi -->
                                    <td class="px-4 py-4 text-center">
                                        <details class="inline-block text-left">
                                           
                                        <summary
    class="list-none bg-green-600 hover:bg-green-700 
           text-white cursor-pointer marker:content-none
           w-8 h-8 flex items-center justify-center rounded-full">
<svg width="13" height="4" viewBox="0 0 13 4" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M1.83333 0.666016C1.1 0.666016 0.5 1.26602 0.5 1.99935C0.5 2.73268 1.1 3.33268 1.83333 3.33268C2.56667 3.33268 3.16667 2.73268 3.16667 1.99935C3.16667 1.26602 2.56667 0.666016 1.83333 0.666016ZM11.1667 0.666016C10.4333 0.666016 9.83333 1.26602 9.83333 1.99935C9.83333 2.73268 10.4333 3.33268 11.1667 3.33268C11.9 3.33268 12.5 2.73268 12.5 1.99935C12.5 1.26602 11.9 0.666016 11.1667 0.666016ZM6.5 0.666016C5.76667 0.666016 5.16667 1.26602 5.16667 1.99935C5.16667 2.73268 5.76667 3.33268 6.5 3.33268C7.23333 3.33268 7.83333 2.73268 7.83333 1.99935C7.83333 1.26602 7.23333 0.666016 6.5 0.666016Z" fill="white"></path>
</svg>
                                            </summary>

                                            <div class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-xl shadow-lg z-50 overflow-hidden">

                                                <!-- Edit -->
                                                <a href="{{ route('cardrequest.edit', $rec->id) }}"
                                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    Ubah Data
                                                </a>

                                                <!-- Hapus -->
                                                <button type="button"
                                                        onclick="openDeleteModal({{ $rec->id }})"
                                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                                    Hapus Data
                                                </button>
                                            </div>
                                        </details>
                                    </td>
																		@endif 	
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $cardrequest->links() }}
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
        deleteForm.action = `/cardrequest/${id}`;

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

