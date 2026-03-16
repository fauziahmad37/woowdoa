@extends('layouts.app')

@section('content')
<style>

body{
    font-family:Arial;
}

.card{
	width:85.6mm;
	height:54mm;
	position:relative;
	margin-bottom:30px;
}

.bg{
position:absolute;
width:100%;
height:100%;
left:0;
top:0;
}


/* PRINT ONLY CARD */
@media print {

	body *{
			visibility:hidden;
	}

	.card, .card *{
			visibility:visible;
	}

	.card{ 
			left:0;
			top:0;
			-webkit-print-color-adjust: exact;
			print-color-adjust: exact;		 
	}

}
</style>
{{-- ================= FRONT CARD ================= --}}
<div class="card">
 
<img src="{{asset($design->front_background)}}" class="bg">
 
{{-- FOTO --}}
@if(isset($front['photo']))
<img src="{{ asset($card->user->profile_photo) }}"
style="
position:absolute;
left:{{$front['photo']['left']}}px;
top:{{$front['photo']['top']}}px;
width:{{$front['photo']['width']}}px;
height:{{$front['photo']['height']}}px;
">
@endif
 
{{-- NAMA --}}
@if(isset($front['name']))
<div style="
position:absolute;
left:{{$front['name']['left']}}px;
top:{{$front['name']['top']}}px;
font-size:{{$front['name']['font_size']}}px;
font-weight:bold;
">

{{$card->user->complete_name}}

</div>
@endif



{{-- NIS --}}
@if(isset($front['nis']))
<div style="
position:absolute;
left:{{$front['nis']['left']}}px;
top:{{$front['nis']['top']}}px;
font-size:{{$front['nis']['font_size']}}px;
">

NIS : {{$card->user->username}}
</div>
@endif 



{{-- NOMOR KARTU --}}
@if(isset($front['card_number']))
<div style="
position:absolute;
left:{{$front['card_number']['left']}}px;
top:{{$front['card_number']['top']}}px;
font-size:{{$front['card_number']['font_size']}}px;
">

{!! DNS1D::getBarcodeHTML($card->card_number, 'C128',2,20) !!}
 
</div>
@endif 
</div>
  
<script>
window.print();
</script>

@endsection
 