@extends('layouts.app')

@section('content')
<div class="py-6">
  <div class="container mx-auto w-full px-4">
		<!-- Breadcrumb -->
		<nav class="text-gray-700 text-sm mb-6" aria-label="Breadcrumb">
				<ol class="list-reset flex flex-wrap items-center">
						<li class="flex items-center"> 
							Shortcut Nominal
						</li>
						<li> 
						</li>
				</ol>
		</nav>

		<!-- Judul -->
		<h2 class="text-xl font-semibold text-gray-700">
			Shortcut Nominal
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

	<form action="{{  route('shortcutnominal.update', $shortcutnominal->id)   }}" 
    method="POST"  enctype="multipart/form-data" >
            
                @csrf
                @if(isset($shortcutnominal))
                    @method('PUT')
                @endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

@for ($i = 1; $i < 7; $i++)

	<div>
			<label class="block text-gray-700 font-medium mb-1">
					Nominal {{$i}} <span class="text-red-500">*</span>
			</label>
			<input type="text" name="nominal{{$i}}"
						 value="{{ old('nominal'.$i, $shortcutnominal->{'nominal'.$i} ?? '') }}"
						 class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
			@error('nominal{{$i}}')
					<p class="text-sm text-red-600 mt-1">{{ $message }}</p>
			@enderror
	</div> 
@endfor
 	
	 
		
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
            <a href="{{ route('shortcutnominal.index') }}"
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
});


 
</script>
@endsection@extends('layouts.app')