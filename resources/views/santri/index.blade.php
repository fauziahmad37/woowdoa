@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="container mx-auto w-full">

        <!-- Header -->
        <h2 class="text-xl font-semibold text-gray-600">Kelola Santri</h2>
        <p class="text-gray-500 mb-10">Pendataan Data Santri</p>

        <!-- Top Bar -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4 w-full">

            <!-- Form Pencarian -->
         <form x-data="{ search: '{{ request('search') }}' }" method="GET" class="flex flex-col sm:flex-row items-center gap-2 w-full sm:w-auto">

    <input 
        type="text"
        name="search"
        x-model="search"
        placeholder="Cari NIS / Nama"
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
      <a href="{{ route('santri.index') }}"
                   class="w-full sm:w-auto text-green-600 border border-green-600 px-4 py-2 rounded-md text-center hover:bg-green-50 transition">
                    Atur Ulang
                </a>

</form>

            <!-- Tombol Tambah -->
           <div class="flex gap-2 w-full sm:w-auto">

<a href="{{ route('santri.import.form') }}"
class="px-4 py-2 rounded-lg text-white text-center"
style="background: linear-gradient(203.18deg, #2563eb 11.82%, #1e40af 85.47%);">
Import Excel
</a>

<a href="{{ route('santri.create') }}"
class="px-4 py-2 rounded-lg text-white text-center"
style="background: linear-gradient(203.18deg, #01AB14 11.82%, #085410 85.47%);">
+ Tambah Santri
</a>

</div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">

            @if($student->count() > 0)

                <div class="w-full overflow-x-auto p-4">
                    <table class="min-w-full bg-white border border-gray-200 divide-y divide-gray-200 table-auto">
                        <thead class="text-xs text-gray-700 bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 border">No</th>
                                <th class="px-4 py-2 border">NIS</th>
                                <th class="px-4 py-2 border">Nama</th>
                                <th class="px-4 py-2 border">Gender</th>
                                <th class="px-4 py-2 border">Saldo</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($student as $i => $santri)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        {{ ($student->currentPage() - 1) * $student->perPage() + $i + 1 }}
                                    </td>
                                    <td class="px-4 py-3">{{ $santri->nis }}</td>
                                    <td class="px-4 py-3">{{ $santri->student_name }}</td>
                                    <td class="px-4 py-3">{{ $santri->gender }}</td>
                                    <td class="px-4 py-3">Rp {{ $santri->balance }} </td>
                                    <td class="px-4 py-3">
                                        @if($santri->active)
                                            <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-600">Aktif</span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-600">Nonaktif</span>
                                        @endif
                                    </td>

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
                                                <a href="{{ route('santri.edit', $santri->id) }}"
                                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    Ubah Data
                                                </a>

                                                <!-- Hapus -->
                                                <button type="button"
                                                        onclick="openDeleteModal({{ $santri->id }})"
                                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                                    Hapus Data
                                                </button>
                                            </div>
                                        </details>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $student->links() }}
                    </div>
                </div>

            @else
                <div class="text-center py-10 text-gray-500">
                    Data santri belum tersedia.
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
        deleteForm.action = `/santri/${id}`;

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

