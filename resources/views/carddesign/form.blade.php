@extends('layouts.app')

@section('content')
<div class="py-6">
  <div class="container mx-auto w-full px-4">
		<!-- Breadcrumb -->
		<nav class="text-gray-700 text-sm mb-6" aria-label="Breadcrumb">
				<ol class="list-reset flex flex-wrap items-center">
						<li class="flex items-center">
								<a href="{{ route('card.index') }}" 
									 class="text-green-600 hover:text-green-800">
										Data Design Kartu
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
										{{ isset($carddesign) ? 'Edit Design Kartu' : 'Design Kartu' }}
								</span>
						</li>
				</ol>
		</nav>

		<!-- Judul -->
		<h2 class="text-xl font-semibold text-gray-700">
			Design Kartu
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

	<form action="{{ isset($carddesign) ? route('carddesign.update', $carddesign->id) : route('carddesign.store') }}" 
    method="POST"  enctype="multipart/form-data" >
            
                @csrf
                @if(isset($carddesign))
                    @method('PUT')
                @endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
	<div>
	<label class="block text-gray-700 font-medium mb-1">Nama Desain</label>
	<input type="text" name="name" required 
						 value="{{ old('carddesign', $carddesign->name ?? '') }}"
						 class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500"> 
	</div>
</div>  
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

 

	<div>
	<label>Background Depan</label>
	@if($carddesign->front_background)
	<br>
	<img src="{{asset($carddesign->front_background)}}" width="250">
	<br>
	<a  href="{{asset($carddesign->front_background)}}"  download="design-depan.jpg">download</a>
	<br>
	@endif
	
	<input type="file" name="front_background"
						 value="{{ old('front_background', $carddesign->front_background ?? '') }}"
						 class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
	</div>
	
	<div>
	<label>Background Belakang</label>
	@if($carddesign->back_background)
	<br>
	<img src="{{asset($carddesign->back_background)}}" width="250">
	<br>
	<a  href="{{asset($carddesign->back_background)}}"  download="design-belakang.jpg">download</a>
	<br>	
	@endif
	
	<input type="file" name="back_background"
						 value="{{ old('back_background', $carddesign->back_background ?? '') }}"
						 class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
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
            Design kartu berhasil diupdate.
        </p>

        <div class="mt-6 flex flex-col sm:flex-row justify-center gap-3">

  
            <!-- Selesai -->
            <a href="{{ route('carddesign.index') }}"
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
		
		$("#btnPreview").click(function(){
			alert('aaa');
		});
});


 
</script>
@endsection@extends('layouts.app')