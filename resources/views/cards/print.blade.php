@extends('layouts.app')

@section('content')
<style>

body{
    font-family:Arial;
}

.card{
    width:{{$design->width}}px;
    height:{{$design->height}}px;
    background-image:url('{{ asset($design->background_image) }}');
    background-size:cover;
    background-repeat:no-repeat;
    position:relative;
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
			position:absolute;
			left:0;
			top:0;
			-webkit-print-color-adjust: exact;
			print-color-adjust: exact;			
	}

}
</style>

<div class="card">
 
{{-- FOTO --}}
@if(isset($elements['photo']))
<img src="{{ asset($card->user->profile_photo) }}"
style="
position:absolute;
left:{{$elements['photo']['left']}}px;
top:{{$elements['photo']['top']}}px;
width:{{$elements['photo']['width']}}px;
height:{{$elements['photo']['height']}}px;
">
@endif
 
{{-- NAMA --}}
@if(isset($elements['name']))
<div style="
position:absolute;
left:{{$elements['name']['left']}}px;
top:{{$elements['name']['top']}}px;
font-size:{{$elements['name']['font_size']}}px;
font-weight:bold;
">

{{$card->user->complete_name}}

</div>
@endif



{{-- NIS --}}
@if(isset($elements['nis']))
<div style="
position:absolute;
left:{{$elements['nis']['left']}}px;
top:{{$elements['nis']['top']}}px;
font-size:{{$elements['nis']['font_size']}}px;
">

NIS : {{$card->user->username}}

</div>
@endif 



{{-- NOMOR KARTU --}}
@if(isset($elements['card_number']))
<div style="
position:absolute;
left:{{$elements['card_number']['left']}}px;
top:{{$elements['card_number']['top']}}px;
font-size:{{$elements['card_number']['font_size']}}px;
">

{{$card->card_number}}

</div>
@endif 

 
</div>
 
<script>
window.print();
</script>

@endsection
 