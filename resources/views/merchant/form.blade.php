@extends('layouts.app')

@section('content')
<div class="py-6">
  <div class="container mx-auto w-full px-4">
		<!-- Breadcrumb -->
		<nav class="text-gray-700 text-sm mb-6" aria-label="Breadcrumb">
				<ol class="list-reset flex flex-wrap items-center">
						<li class="flex items-center">
								<a href="{{ route('merchant.index') }}" 
									 class="text-green-600 hover:text-green-800">
										Data Merchant
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
										{{ isset($merchant) ? 'Edit Merchant' : 'Tambah Merchant Baru' }}
								</span>
						</li>
				</ol>
		</nav>

		<!-- Judul -->
		<h2 class="text-xl font-semibold text-gray-700">
				{{ isset($merchant) ? 'Edit Data Merchant' : 'Tambah Merchant Baru' }}
		</h2>
		<p class="text-gray-500 mb-6">
				Silakan isi data Merchant dengan lengkap.
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

	<form action="{{ isset($merchant) ? route('merchant.update', $merchant->id) : route('merchant.store') }}" 
    method="POST"  enctype="multipart/form-data" >
            
                @csrf
                @if(isset($merchant))
                    @method('PUT')
                @endif

<div class="grid grid-cols-1 md:grid-cols-1 gap-4">
	<!-- Kode Merchant -->
	<div>
			<label class="block text-gray-700 font-medium mb-1">
					Kode Merchant <span class="text-red-500">*</span>
			</label>
			<input type="text" name="merchant_code"
						 value="{{ old('merchant_code', $merchant->merchant_code ?? '') }}"
						 class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
			@error('merchant_code')
					<p class="text-sm text-red-600 mt-1">{{ $message }}</p>
			@enderror
	</div>

	
	<!-- Nama -->
	<div>
			<label class="block text-gray-700 font-medium mb-1">
					Nama Merchant <span class="text-red-500">*</span>
			</label>
			<input type="text" name="merchant_name"
						 value="{{ old('merchant_name', $merchant->merchant_name ?? '') }}"
						 class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
			@error('merchant_name')
					<p class="text-sm text-red-600 mt-1">{{ $message }}</p>
			@enderror
	</div>
	
    <div>
    <label class="block text-gray-700 font-medium mb-1">
        Kategori Merchant <span class="text-red-500">*</span>
    </label>

    <select name="merchant_category_id" 
        class="w-full border border-gray-300 rounded-lg px-3 py-2 select2">

        <option value="">-- Pilih Kategori --</option>

        @foreach($merchant_categories as $mc)
        <option value="{{ $mc->id }}"
        {{ old('merchant_category_id', $merchant->merchant_category_id ?? '') == $mc->id ? 'selected' : '' }}>
            {{ $mc->mc_name }}
        </option>
        @endforeach

    </select>
</div>

	<div>
			<label class="block text-gray-700 font-medium mb-1">No HP</label>
			<input type="text" name="phone"
						 value="{{ old('phone', $merchant->phone ?? '') }}"
						 class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
	</div> 
	
	<!-- Email -->
	<div>
			<label class="block text-gray-700 font-medium mb-1">Email</label>
			<input type="email" name="email"
						 value="{{ old('email', $merchant->email ?? '') }}"
						 class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
	</div>
	<div>
    <!-- Provinsi -->
    <label class="block font-medium mb-1">Provinsi<span class="text-red-500">*</span></label>
  <select id="provinsi" name="merchant_id_provinsi" class="form-control form-select input-form select2">
<option value="">-- Pilih Provinsi --</option>

@foreach($provinsi as $prov)
<option value="{{ $prov->id }}"
{{ old('merchant_id_provinsi', $merchant->province_id ?? '') == $prov->id ? 'selected' : '' }}>
{{ $prov->name }}
</option>
@endforeach

</select>
	</div>
	<div>
    <!-- Kota -->
    <label class="block font-medium mb-1">Kota/Kabupaten<span class="text-red-500">*</span></label>
 <select id="kota" name="merchant_id_kota" class="form-control form-select input-form select2">

<option value="">-- Pilih Kota --</option>

@isset($kota)
@foreach($kota as $k)
<option value="{{ $k->id }}"
{{ old('merchant_id_kota', $merchant->city_id ?? '') == $k->id ? 'selected' : '' }}>
{{ $k->name }}
</option>
@endforeach
@endisset

</select>
	</div>	
 
	<!-- No HP -->

 
 
 	<div>
    <!-- Kecamatan -->
    <label class="block font-medium mb-1">Kecamatan<span class="text-red-500">*</span></label>
   <select id="kecamatan" name="merchant_id_kecamatan" class="form-control form-select input-form select2">

<option value="">-- Pilih Kecamatan --</option>

@isset($kecamatan)
@foreach($kecamatan as $kec)
<option value="{{ $kec->id }}"
{{ old('merchant_id_kecamatan', $merchant->district_id ?? '') == $kec->id ? 'selected' : '' }}>
{{ $kec->name }}
</option>
@endforeach
@endisset

</select>
	</div>




	<div>
    <!-- Kelurahan -->
    <label class="block font-medium mb-1">Kelurahan/Desa<span class="text-red-500">*</span></label>
   <select id="kelurahan" name="merchant_id_kelurahan" class="form-control form-select input-form select2">

<option value="">-- Pilih Kelurahan --</option>

@isset($kelurahan)
@foreach($kelurahan as $kel)
<option value="{{ $kel->id }}"
{{ old('merchant_id_kelurahan', $merchant->village_id ?? '') == $kel->id ? 'selected' : '' }}>
{{ $kel->name }}
</option>
@endforeach
@endisset

</select>
	</div> 
	<!-- sekolah -->

	<div>
		<label class="block text-gray-700 font-medium mb-1">Sekolah</label>
			<select name="school_id" class="w-full border rounded-lg px-3 py-2" required>
			<option value="">Pilih Sekolah</option>
			@foreach($schools as $school)
			<option value="{{ $school->id }}"
			{{ old('school_id', $merchant->school_id ?? '') == $school->id ? 'selected' : '' }}>
			{{ $school->school_name }}
			</option>
			@endforeach
			</select>
	</div>
	<!-- sekolah -->

 



    <!-- Nomor Rekening -->
<!-- Bank -->
<div>
    <label class="block text-gray-700 font-medium mb-1">
        Bank
    </label>
<select name="bank_id"
class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">

<option value="">-- Pilih Bank --</option>

@foreach($banks as $item)
<option value="{{ $item->id }}"
{{ old('bank_id', $merchant->bank_id ?? '') == $item->id ? 'selected' : '' }}>
{{ $item->nama }}
</option>
@endforeach

</select>

@error('bank_id')
<p class="text-sm text-red-600 mt-1">{{ $message }}</p>
@enderror
</div>

<!-- Nomor Rekening -->
<div>
    <label class="block text-gray-700 font-medium mb-1">
        Nomor Rekening
    </label>
    <input type="text" name="nomor_rekening"
        value="{{ old('nomor_rekening', $merchant->nomor_rekening ?? '') }}"
        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">

    @error('nomor_rekening')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

<!-- Atas Nama Rekening -->
<div>
    <label class="block text-gray-700 font-medium mb-1">
        Atas Nama Rekening
    </label>
    <input type="text" name="atas_nama_norek"
        value="{{ old('atas_nama_norek', $merchant->atas_nama_norek ?? '') }}"
        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">

    @error('atas_nama_norek')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>
  
<div>
<label class="block text-gray-700 font-medium mb-1">
No NPWP
</label>

<input type="text" name="no_npwp"
value="{{ old('no_npwp', $merchant->no_npwp ?? '') }}"
class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
</div>
	
<div>
	<label class="block text-gray-700 font-medium mb-1">Alamat</label>
	<textarea name="address"
	class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500"
	rows="3">{{ old('address', $merchant->address ?? '') }}</textarea>
</div>

 <div>
    <label class="block text-gray-700 font-medium mb-1">
        Logo Merchant
    </label>

    <input type="file" name="logo"
        class="w-full border border-gray-300 rounded-lg px-3 py-2">

    @if(isset($merchant) && $merchant->logo)
        <img src="{{ asset('storage/'.$merchant->logo) }}"
            class="mt-2 h-16">
    @endif
</div>




		
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
            Data merchant berhasil ditambahkan.
        </p>

        <div class="mt-6 flex flex-col sm:flex-row justify-center gap-3">

            <!-- Buat Lagi -->
            <button onclick="reloadForm()"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Buat Lagi
            </button>

            <!-- Selesai -->
            <a href="{{ route('merchant.index') }}"
                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                Selesai
            </a>

        </div>
    </div>
</div>
@endif



<!-- end modal -->


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    let modal = document.getElementById("successModalContent");
    if (modal) {
        setTimeout(() => {
            modal.classList.remove("scale-95", "opacity-0");
            modal.classList.add("scale-100", "opacity-100");
        }, 100);
    }
 
    $('.select2').select2({ width: '100%' });

    $('#provinsi').on('change', function () {
        $('#kota').html('<option value="">-- Pilih Kota --</option>');
        $.get('/merchant/kota/' + this.value, res => {
            res.forEach(r => $('#kota').append(`<option value="${r.id}">${r.name}</option>`));
        });
    });

    $('#kota').on('change', function () {
        $('#kecamatan').html('<option value="">-- Pilih Kecamatan --</option>');
        $.get('/merchant/kecamatan/' + this.value, res => {
            res.forEach(r => $('#kecamatan').append(`<option value="${r.id}">${r.name}</option>`));
        });
    });

    $('#kecamatan').on('change', function () {
        $('#kelurahan').html('<option value="">-- Pilih Kelurahan --</option>');
        $.get('/merchant/kelurahan/' + this.value, res => {
            res.forEach(r => $('#kelurahan').append(`<option value="${r.id}">${r.name}</option>`));
        });
    });
});


function reloadForm() {
    window.location.href = "{{ route('merchant.create') }}";
}
</script>
@endsection