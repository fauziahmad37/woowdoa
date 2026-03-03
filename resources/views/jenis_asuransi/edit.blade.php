@extends('layouts.app')

@section('content')
<div class="py-6">
      <div class="container mx-auto w-full px-4">
        
        <!-- Breadcrumb -->
        <nav class="text-gray-700 text-sm mb-6" aria-label="Breadcrumb">
            <ol class="list-reset flex flex-wrap items-center">
                <li class="flex items-center">
                    <a href="{{ route('jenis_asuransi.index') }}" class="text-orange-600 hover:text-blue-800">Data Jenis Asuransi</a>
                    <span class="mx-2 flex-shrink-0">
                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.646447 0.646447C0.841709 0.451184 1.15829 0.451184 1.35355 0.646447L7.35355 6.64645C7.54882 6.84171 7.54882 7.15829 7.35355 7.35355L1.35355 13.3536C1.15829 13.5488 0.841709 13.5488 0.646447 13.3536C0.451184 13.1583 0.451184 12.8417 0.646447 12.6464L6.29289 7L0.646447 1.35355C0.451184 1.15829 0.451184 0.841709 0.646447 0.646447Z" fill="#1A2130"/>
                        </svg>
                    </span>
                </li>
                <li class="flex items-center">
                    <span class="text-gray-500">Edit Jenis Asuransi</span>
                </li>
            </ol>
        </nav>

        <!-- Judul -->
        <h2 class="text-xl font-semibold text-gray-700">Edit Jenis Asuransi</h2>
        <p class="text-gray-500 mb-6">Perbarui data Jenis Asuransi sesuai kebutuhan.</p>

        <!-- Form -->
        <div class="bg-white shadow-sm sm:rounded-lg p-4">
            <form action="{{ route('jenis_asuransi.update', $jenis_asuransi->jenis_asuransi_id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Input Nama -->
                <div class="mb-4">
                    <label for="jenis_asuransi_nama" class="block text-gray-700 font-medium mb-1">
                        Nama Jenis Asuransi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="jenis_asuransi_nama" id="jenis_asuransi_nama"
                           value="{{ old('jenis_asuransi_nama', $jenis_asuransi->jenis_asuransi_nama) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('jenis_asuransi_nama')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol -->
                <div class="flex justify-end mt-6">
                    <button type="submit" 
                        class="text-white px-4 py-2 rounded" 
                        style="background: linear-gradient(203.18deg, #FF8F00 11.82%, #FF6200 85.47%);">
                        Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success Modal -->
@if(session('success'))
<div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center">
    <div class="absolute inset-0 bg-gray-800 bg-opacity-40"></div>
    <div id="successModalContent"
        class="relative bg-white rounded-xl shadow-lg p-6 max-w-md w-11/12 sm:w-full transform scale-95 opacity-0 transition-all duration-200">
        
        <div class="flex justify-center mb-4">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="48" height="48" rx="24" fill="#FDE2D3"/>
                <path d="M23.9996 12.5L28.2256 18.6834L35.4123 20.7918L30.8374 26.7217L31.053 34.2082L23.9996 31.6897L16.9462 34.2082L17.1618 26.7217L12.5869 20.7918L19.7736 18.6834L23.9996 12.5ZM21.9996 24H19.9996C19.9996 26.2091 21.7905 28 23.9996 28C26.1418 28 27.8907 26.316 27.9947 24.1996L27.9996 24H25.9996C25.9996 25.1046 25.1042 26 23.9996 26C22.9452 26 22.0814 25.1841 22.0051 24.1493L21.9996 24Z" fill="url(#paint0_linear_742_13254)"/>
                <defs>
                    <linearGradient id="paint0_linear_742_13254" x1="26.409" y1="12.5" x2="18.4342" y2="32.0859" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#FF8F00"/>
                        <stop offset="1" stop-color="#FF6200"/>
                    </linearGradient>
                </defs>
            </svg>
        </div>

        <h2 class="text-lg font-semibold text-gray-800 text-center">Update Data Berhasil!</h2>
        <p class="mt-2 text-sm text-gray-600 text-center">Data jenis_asuransi berhasil diperbarui.</p>
        <div class="mt-6 flex flex-col sm:flex-row justify-center gap-3">
            <!-- Kembali ke index -->
            <a href="{{ route('jenis_asuransi.index') }}"
                class="px-4 py-2 button-add text-white rounded-lg hover:bg-green-700">
                Kembali ke Daftar
            </a>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let modal = document.getElementById("successModalContent");
        if (modal) {
            setTimeout(() => {
                modal.classList.remove("scale-95", "opacity-0");
                modal.classList.add("scale-100", "opacity-100");
            }, 100);
        }
    });
</script>
@endpush
