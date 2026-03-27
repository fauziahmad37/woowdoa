@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="container mx-auto w-full px-4">
        
        <!-- Breadcrumb -->
        <nav class="text-gray-700 text-sm mb-6" aria-label="Breadcrumb">
            <ol class="list-reset flex flex-wrap items-center">
                <li class="flex items-center">
                    <a href="{{ route('santri.index') }}" 
                       class="text-green-600 hover:text-green-800">
                        Data Santri
                    </a>
                    <span class="mx-2">
                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0.646447 0.646447C0.841709 0.451184 1.15829 0.451184 1.35355 0.646447L7.35355 6.64645C7.54882 6.84171 7.54882 7.15829 7.35355 7.35355L1.35355 13.3536C1.15829 13.5488 0.841709 13.5488 0.646447 13.3536C0.451184 13.1583 0.451184 12.8417 0.646447 12.6464L6.29289 7L0.646447 1.35355C0.451184 1.15829 0.451184 0.841709 0.646447 0.646447Z"
                                fill="#1A2130"/>
                        </svg>
                    </span>
                </li>
                <li>
                    <span class="text-gray-500">
                        {{ isset($santri) ? 'Edit Santri' : 'Tambah Santri Baru' }}
                    </span>
                </li>
            </ol>
        </nav>

        <!-- Judul -->
        <h2 class="text-xl font-semibold text-gray-700">
            {{ isset($santri) ? 'Edit Data Santri' : 'Tambah Santri Baru' }}
        </h2>
        <p class="text-gray-500 mb-6">
            Silakan isi data santri dengan lengkap.
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
    action="{{ isset($santri) ? route('santri.update', $santri->id) : route('santri.store') }}" 
    method="POST"
    enctype="multipart/form-data"
>
            
                @csrf
                @if(isset($santri))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- NIS -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">
                            NIS <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nis"
                               value="{{ old('nis', $santri->nis ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                        @error('nis')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">
                            Nama Santri <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="student_name"
                               value="{{ old('student_name', $santri->student_name ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                        @error('student_name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- username -->

                    <div>
    <label class="block text-gray-700 font-medium mb-1">
        Username <span class="text-red-500">*</span>
    </label>
    <input type="text" name="username"
        value="{{ old('username', optional(optional($santri)->user)->username) }}"
        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
    @error('username')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>
                    <!-- username -->

<!-- sekolah -->

<div>
                        <label class="block text-gray-700 font-medium mb-1">Sekolah</label>
                    <select name="school_id" class="w-full border rounded-lg px-3 py-2" required>
    <option value="">Pilih Sekolah</option>
    @foreach($schools as $school)
        <option value="{{ $school->id }}"
            {{ old('school_id', $santri->school_id ?? '') == $school->id ? 'selected' : '' }}>
            {{ $school->school_name }}
        </option>
    @endforeach
</select>
                    </div>
<!-- sekolah -->


<!-- sekolah -->

<div>
    <label class="block text-gray-700 font-medium mb-1">
        Tahun Ajaran
    </label>
<select name="tahun_ajaran_id" class="w-full border rounded-lg px-3 py-2" required>
    <option value="">Pilih Tahun Ajaran</option>
    @foreach($tahunAjarans as $tahun)
        <option value="{{ $tahun->id }}"
            {{ old('tahun_ajaran_id', $santri->tahun_ajaran_id ?? '') == $tahun->id ? 'selected' : '' }}>
            {{ $tahun->tahun_ajaran }}
        </option>
    @endforeach
</select>
</div>


<div>
    <label class="block text-gray-700 font-medium mb-1">
        Kelas
    </label>
<select name="class_id" class="w-full border rounded-lg px-3 py-2" required>
    <option value="">Pilih Kelas</option>
    @foreach($classes as $class)
        <option value="{{ $class->id }}"
            {{ old('class_id', $santri->class_id ?? '') == $class->id ? 'selected' : '' }}>
            {{ $class->class_name }}
        </option>
    @endforeach
</select>
</div>



<!-- sekolah -->
                    <!-- Gender -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Jenis Kelamin</label>
                        <select name="gender"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                             <option>Pilih Jenis Kelamin</option>
                            <option value="Laki-Laki" {{ old('gender', $santri->gender ?? '') == 'Laki-Laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender', $santri->gender ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <!-- No HP -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">No HP</label>
                        <input type="text" name="phone"
                               value="{{ old('phone', $santri->phone ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Email</label>
                        <input type="email" name="email"
                               value="{{ old('email', $santri->email ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                    </div>

                    <!-- PIN -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">PIN</label>
                       <input type="password" name="pin"
    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500"
    placeholder="Kosongkan jika tidak ingin mengubah PIN">
                    </div>

                     <div>
                        <label class="block text-gray-700 font-medium mb-1">Password</label>
<input type="password" name="password"
    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500"
    placeholder="Kosongkan jika tidak ingin mengubah password">
                    </div>

                    <!-- Status -->
                 
                </div>
   <div class="mt-4">
                        <label class="block text-gray-700 font-medium mb-1">Status</label>
   @php
    $selectedActive = old(
        'active',
        isset($santri) && $santri->user
            ? $santri->user->is_active
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

                     <div class="mt-4">
    <label class="block text-gray-700 font-medium mb-1">Alamat</label>
 <textarea name="address"
    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500"
    rows="3">{{ old('address', $santri->address ?? '') }}</textarea>
</div>
 <div class="mt-4">
                        <label class="block text-gray-700 font-medium mb-1">Profil Foto</label>
                    @if(isset($santri) && optional($santri->user)->profile_photo)
   <img src="{{ $santri->user && $santri->user->profile_photo
    ? asset('storage/' . $santri->user->profile_photo)
    : asset('images/default-avatar.png') }}"
  class="w-12 h-12 object-cover rounded-full border">
@endif

<input type="file" name="profile_photo"
       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                    </div>


                    <hr>


        <!-- Judul -->
        <h2 class="text-xl font-semibold text-gray-700">
          Data Orangtua
        </h2>
        <p class="text-gray-500 mb-6">
            Silakan isi data orangtua dengan lengkap.
        </p>


       
                <div class="mt-6">
    <label class="block text-gray-700 font-medium mb-1">
        NIK Orangtua <span class="text-red-500">*</span>
    </label>
    <input type="text" id="nik" name="nik"
        class="w-full border border-gray-300 rounded-lg px-3 py-2">

        
        <p id="nik_status" class="text-sm mt-1"></p>
</div>
                    <!-- Nama -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">
                            Nama Orangtua <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="parent_name" id="parent_name"
                              value="{{ old('parent_name') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                        @error('parent_name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- gender -->

                    <div>
    <label class="block text-gray-700 font-medium mb-1">
        Jenis Kelamin
    </label>
    <select name="parent_gender"
        class="w-full border border-gray-300 rounded-lg px-3 py-2">
        
        <option value="">Pilih Jenis Kelamin</option>

        <option value="Laki-Laki"
            {{ old('parent_gender') == 'Laki-Laki' ? 'selected' : '' }}>
            Laki-laki
        </option>

        <option value="Perempuan"
            {{ old('parent_gender') == 'Perempuan' ? 'selected' : '' }}>
            Perempuan
        </option>

    </select>
</div>
                    <!-- Username -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">
                            Username <span class="text-red-500">*</span>
                        </label>
                     <input type="text" name="parent_username" id="parent_username"
  value="{{ old('parent_username') }}"
    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
    @error('parent_username')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="parent_email" id="parent_email"
                              value="{{ old('parent_email') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                        @error('parent_email')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">
                            No HP
                        </label>
                        <input type="text" name="parent_phone" id="parent_phone" 
                              value="{{ old('parent_phone') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                    </div>

                    <!-- Sekolah -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">
                            Sekolah
                        </label>
                        <select name="parent_school_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                            <option value="">Pilih Sekolah</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}"
                                    {{ old('parent_school_id') == $school->id ? 'selected' : '' }}>
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
                        <input type="password" name="parent_password"
                               placeholder="Kosongkan jika tidak ingin mengubah password"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                    </div>

                    <!-- Status -->
               <!-- Status -->

                <div class="mt-4">


                        <label class="block text-gray-700 font-medium mb-1">
                            Status
                        </label>
                           
 @php
    $selectedActive = old('parent_active', 1);
@endphp
                        <select name="parent_active"
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
    <textarea name="parent_address"
        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500"
        rows="3">{{ old('parent_address') }}</textarea>
</div>



<!-- Foto Profil -->
<div class="mt-4">
    <label class="block text-gray-700 font-medium mb-1">
        Profil Foto
    </label>

<img id="parent_photo_preview" class="w-12 h-12 rounded-full hidden">
    <input type="file" name="parent_profile_photo"
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

<!-- modal success -->


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
            Data santri berhasil ditambahkan.
        </p>

        <div class="mt-6 flex flex-col sm:flex-row justify-center gap-3">

            <!-- Buat Lagi -->
            <button onclick="reloadForm()"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Buat Lagi
            </button>

            <!-- Selesai -->
            <a href="{{ route('santri.index') }}"
                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                Selesai
            </a>

        </div>
    </div>
</div>
@endif



<!-- end modal -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    // modal success
    let modal = document.getElementById("successModalContent");
    if (modal) {
        setTimeout(() => {
            modal.classList.remove("scale-95", "opacity-0");
            modal.classList.add("scale-100", "opacity-100");
        }, 100);
    }

    // =========================
    // 🔥 CHECK NIK REALTIME
    // =========================

    let timeout = null;
    let nikInput = document.getElementById('nik');
    let statusText = document.getElementById('nik_status');

    nikInput.addEventListener('input', function () {

        clearTimeout(timeout);

        let nik = this.value;

        timeout = setTimeout(() => {

            if (nik.length < 5) {
                statusText.innerText = '';
                nikInput.classList.remove('border-green-500', 'border-red-500');
                return;
            }

            // loading
            statusText.innerText = "⏳ Mengecek NIK...";
            statusText.className = "text-gray-500 text-sm mt-1";

            fetch(`/parent/check-nik/${nik}`)
                .then(res => res.json())
                .then(res => {

                    if (res.exists) {

                        document.getElementById('parent_name').value = res.data.parent_name;
                        document.getElementById('parent_email').value = res.data.email;
                        document.getElementById('parent_phone').value = res.data.phone;

                        document.getElementById('parent_name').readOnly = true;
                        document.getElementById('parent_email').readOnly = true;
                        document.getElementById('parent_phone').readOnly = true;
    document.querySelector('select[name="parent_school_id"]').value = res.data.school_id;
    document.querySelector('select[name="parent_gender"]').value = res.data.gender;
document.querySelector('textarea[name="parent_address"]').value = res.data.address;
// username
document.getElementById('parent_username').value = res.data.username;

// foto preview
if (res.data.profile_photo) {
    let img = document.getElementById('parent_photo_preview');
    img.src = '/storage/' + res.data.profile_photo;
    img.classList.remove('hidden');
}
                        statusText.innerText = "✅ NIK ditemukan";
                        statusText.className = "text-green-600 text-sm mt-1";

                        nikInput.classList.add('border-green-500');
                        nikInput.classList.remove('border-red-500');

                    } else {

                        document.getElementById('parent_name').value = '';
                        document.getElementById('parent_email').value = '';
                        document.getElementById('parent_phone').value = '';

                        document.getElementById('parent_name').readOnly = false;
                        document.getElementById('parent_email').readOnly = false;
                        document.getElementById('parent_phone').readOnly = false;

                        statusText.innerText = "❌ NIK tidak terdaftar silahkan isi data";
                        statusText.className = "text-red-600 text-sm mt-1";

                        nikInput.classList.add('border-red-500');
                        nikInput.classList.remove('border-green-500');
                    }

                })
                .catch(() => {
                    statusText.innerText = "⚠️ Error cek NIK";
                    statusText.className = "text-yellow-600 text-sm mt-1";
                });

        }, 500); // delay biar tidak spam

    });

    
});

// reload form
function reloadForm() {
    window.location.href = "{{ route('santri.create') }}";
}
</script>
@endsection