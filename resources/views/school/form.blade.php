@extends('layouts.app')

@section('content')
<div class="py-6">
  <div class="container mx-auto w-full px-4">
		<!-- Breadcrumb -->
		<nav class="text-gray-700 text-sm mb-6" aria-label="Breadcrumb">
				<ol class="list-reset flex flex-wrap items-center">
						<li class="flex items-center"> 
							Pesantren
						</li>
						<li> 
						</li>
				</ol>
		</nav>

		<!-- Judul -->
		<h2 class="text-xl font-semibold text-gray-700">
			Data Pesantren
		</h2>
		<p class="text-gray-500 mb-6">
				Silakan isi data   dengan lengkap.
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

	<form action="{{  route('school.update', $school->id)   }}" 
    method="POST"  enctype="multipart/form-data" >
            
                @csrf
                @if(isset($school))
                    @method('PUT')
                @endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

	<!-- Nomor -->
	<div>
			<label class="block text-gray-700 font-medium mb-1">
					No Ponpes <span class="text-red-500">*</span>
			</label>
			<input type="text" name="npsn"
						 value="{{ old('npsn', $school->npsn ?? '') }}"
						 class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
			@error('npsn')
					<p class="text-sm text-red-600 mt-1">{{ $message }}</p>
			@enderror
	</div>


  <div>
    <label class="block text-gray-700 font-medium mb-1">
        Bank <span class="text-red-500">*</span>
    </label>

    <select name="merchant_category_id" 
        class="w-full border border-gray-300 rounded-lg px-3 py-2 select2">

        <option value="">-- Pilih --</option>

        @foreach($bank as $rec)
        <option value="{{ $rec->id }}"
        {{ old('bank_id', $rec->id ?? '') == $rec->id ? 'selected' : '' }}>
            {{ $rec->nama }}
        </option>
        @endforeach

    </select>
	</div>
	
	
	<!-- Nama -->
	<div>
			<label class="block text-gray-700 font-medium mb-1">
					Nama Pesantren <span class="text-red-500">*</span>
			</label>
			<input type="text" name="school_name"
						 value="{{ old('school_name', $school->school_name ?? '') }}"
						 class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
			@error('school_name')
					<p class="text-sm text-red-600 mt-1">{{ $message }}</p>
			@enderror
	</div>
	
	<!-- PIC 1 -->
	<div>
			<label class="block text-gray-700 font-medium mb-1">
					PIC 1 <span class="text-red-500">*</span>
			</label>
			<input type="text" name="pic1"
						 value="{{ old('pic1', $school->pic1 ?? '') }}"
						 class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
			@error('pic1')
					<p class="text-sm text-red-600 mt-1">{{ $message }}</p>
			@enderror
	</div>
	 
	<!-- Alamat -->
	<div>
			<label class="block text-gray-700 font-medium mb-1">
					Alamat <span class="text-red-500">*</span>
			</label>
 
			<textarea name="address" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">{{ old('address', $school->address ?? '') }}</textarea>			 
			@error('address')
					<p class="text-sm text-red-600 mt-1">{{ $message }}</p>
			@enderror
	</div>

	 
	 


	<!-- PIC 2 -->
	<div>
			<label class="block text-gray-700 font-medium mb-1">
					PIC 2 <span class="text-red-500">*</span>
			</label>
			<input type="text" name="pic2"
						 value="{{ old('pic2', $school->pic2 ?? '') }}"
						 class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
			@error('pic2')
					<p class="text-sm text-red-600 mt-1">{{ $message }}</p>
			@enderror
	</div>
	 
	 
		<div>
		<!-- Provinsi -->
		<label class="block font-medium mb-1">Provinsi<span class="text-red-500">*</span></label>
		<select id="provinsi" name="merchant_id_provinsi" class="form-control form-select input-form select2">
		<option value="">-- Pilih Provinsi --</option>

		@foreach($provinsi as $prov)
		<option value="{{ $prov->id }}"
		{{ old('merchant_id_provinsi', $school->province_id ?? '') == $prov->id ? 'selected' : '' }}>
		{{ $prov->name }}
		</option>
		@endforeach

		</select>
		</div>
	
	<!-- PIC 3 -->
	<div>
			<label class="block text-gray-700 font-medium mb-1">
					PIC 3 <span class="text-red-500">*</span>
			</label>
			<input type="text" name="pic3"
						 value="{{ old('pic3', $school->pic3 ?? '') }}"
						 class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
			@error('pic3')
					<p class="text-sm text-red-600 mt-1">{{ $message }}</p>
			@enderror
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
	
		<div  >
			<label class="block text-gray-700 font-medium mb-1">Logo</label>
			@if(isset($school) && optional($school)->logo)
			<img src="{{ $school->logo
			? asset('images/' . $school->logo)
			: asset('images/default-avatar.png') }}"
			class="w-12 h-12 object-cover rounded-full border">
			@endif

			<input type="file" name="logo"
			class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
		</div>		
	
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


	
	<!-- Phone -->
	<div>
			<label class="block text-gray-700 font-medium mb-1">
					Phone <span class="text-red-500">*</span>
			</label>
			<input type="text" name="phone"
						 value="{{ old('phone', $school->phone ?? '') }}"
						 class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
			@error('phone')
					<p class="text-sm text-red-600 mt-1">{{ $message }}</p>
			@enderror
	</div>
	 	 

	 
	<!-- Email -->
	<div>
			<label class="block text-gray-700 font-medium mb-1">
					Email <span class="text-red-500">*</span>
			</label>
			<input type="text" name="email"
						 value="{{ old('email', $school->email ?? '') }}"
						 class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
			@error('email')
					<p class="text-sm text-red-600 mt-1">{{ $message }}</p>
			@enderror
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
            Data shortcut nominal berhasil disimpan.
        </p>

        <div class="mt-6 flex flex-col sm:flex-row justify-center gap-3">

  
            <!-- Selesai -->
            <a href="{{ route('school.index') }}"
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
@endsection@extends('layouts.app')