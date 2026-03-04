@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="container mx-auto w-full px-4">
        
        <!-- Breadcrumb -->
        <nav class="text-gray-700 text-sm mb-6" aria-label="Breadcrumb">
            <ol class="list-reset flex flex-wrap items-center">
                <li class="flex items-center">
                    <a href="{{ route('parent.index') }}" 
                       class="text-green-600 hover:text-green-800">
                        Data Orangtua
                    </a>
                    <span class="mx-2">›</span>
                </li>
                <li>
                    <span class="text-gray-500">
                        {{ isset($parent) ? 'Edit Orangtua' : 'Tambah Orangtua Baru' }}
                    </span>
                </li>
            </ol>
        </nav>

        <!-- Judul -->
        <h2 class="text-xl font-semibold text-gray-700">
            {{ isset($parent) ? 'Edit Data Orangtua' : 'Tambah Orangtua Baru' }}
        </h2>
        <p class="text-gray-500 mb-6">
            Silakan isi data orangtua dengan lengkap.
        </p>

        <!-- Card Form -->
        <div class="bg-white shadow-sm sm:rounded-lg p-6">

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

         <form 
    action="{{ isset($parent) && $parent->exists
        ? route('parent.update', $parent->id)
        : route('parent.store') }}"
    method="POST"   enctype="multipart/form-data"
>
    @csrf

    @if(isset($parent) && $parent->exists)
        @method('PUT')
    @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- Nama -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">
                            Nama Orangtua <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="parent_name"
                               value="{{ old('parent_name', $parent->parent_name ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                        @error('parent_name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Username -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">
                            Username <span class="text-red-500">*</span>
                        </label>
                     <input type="text" name="username"
    value="{{ old('username', isset($parent) ? optional($parent->user)->username : '') }}"
    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
    @error('username')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email"
                               value="{{ old('email', optional($parent->user)->email) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                        @error('email')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">
                            No HP
                        </label>
                        <input type="text" name="phone"
                               value="{{ old('phone', $parent->parent_phone ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                    </div>

                    <!-- Sekolah -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">
                            Sekolah
                        </label>
                        <select name="school_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                            <option value="">Pilih Sekolah</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}"
                                    {{ old('school_id', $parent->user->school_id ?? '') == $school->id ? 'selected' : '' }}>
                                    {{ $school->school_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">
                            Password
                        </label>
                        <input type="password" name="password"
                               placeholder="Kosongkan jika tidak ingin mengubah password"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                    </div>

                    <!-- Status -->
               <!-- Status -->

                </div>


                <div class="mt-4">


                        <label class="block text-gray-700 font-medium mb-1">
                            Status
                        </label>
                           
      @php
                        $selectedActive = old(
                            'active',
                            isset($parent) && $parent->user
                                ? $parent->user->is_active
                                : 1
                        );
                    @endphp
                        <select name="active"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                            <option value="1" {{ $selectedActive == 1 ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="0" {{ $selectedActive == 0 ? 'selected' : '' }}>
                                Nonaktif
                            </option>
                        </select>
</div>

<!-- Alamat -->
<div class="mt-4">
    <label class="block text-gray-700 font-medium mb-1">
        Alamat
    </label>
    <textarea name="address"
        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500"
        rows="3">{{ old('address', $parent->address ?? '') }}</textarea>
</div>

<!-- Foto Profil -->
<div class="mt-4">
    <label class="block text-gray-700 font-medium mb-1">
        Profil Foto
    </label>

    @if(isset($parent))
        <img src="{{ $parent->user && $parent->user->profile_photo
            ? asset('storage/' . $parent->user->profile_photo)
            : asset('images/default-avatar.png') }}"
            class="w-12 h-12 object-cover rounded-full border mb-2">
    @endif

    <input type="file" name="profile_photo"
        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
</div>

                <!-- Tombol -->
                <div class="flex justify-end mt-6">
                    <button type="submit"
                        class="text-white px-6 py-2 rounded-lg"
                        style="background: linear-gradient(203.18deg, #01AB14 11.82%, #085410 85.47%);">
                        Simpan Data
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

@if(session('success'))
<div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center">
    <div class="absolute inset-0 bg-gray-500 bg-opacity-40"></div>

    <div id="successModalContent"
        class="relative bg-white rounded-xl shadow-lg p-6 max-w-md w-11/12 sm:w-full transform scale-95 opacity-0 transition-all duration-200">
        
        <div class="flex justify-center mb-4">
            <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>

        <h2 class="text-lg font-semibold text-gray-800 text-center">
            Berhasil!
        </h2>

        <p class="mt-2 text-sm text-gray-600 text-center">
            {{ session('success') }}
        </p>

        <div class="mt-6 flex flex-col sm:flex-row justify-center gap-3">

            <!-- Buat Lagi -->
            <button onclick="reloadForm()"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Buat Lagi
            </button>

            <!-- Selesai -->
            <a href="{{ route('parent.index') }}"
                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                Selesai
            </a>

        </div>
    </div>
</div>
@endif
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

function reloadForm() {
    window.location.href = "{{ route('parent.create') }}";
}
</script>
@endsection

