@extends('layouts.app')

@section('content')

<style>

.card{

width:{{$design->width}}px;
height:{{$design->height}}px;

background-image:url('{{asset($design->background_image)}}');
background-size:cover;

position:relative;

border:1px solid #ccc;

}

</style>

<h3>Preview Desain Kartu</h3>

<div class="card">

{{-- PHOTO --}}
@if(isset($elements['photo']))
<img src="{{asset($student->photo)}}"
style="
position:absolute;
left:{{$elements['photo']['left']}}px;
top:{{$elements['photo']['top']}}px;
width:{{$elements['photo']['width']}}px;
height:{{$elements['photo']['height']}}px;
">
@endif


{{-- NAME --}}
@if(isset($elements['name']))
<div style="
position:absolute;
left:{{$elements['name']['left']}}px;
top:{{$elements['name']['top']}}px;
font-size:{{$elements['name']['font_size']}}px;
font-weight:bold;
">

{{$student->name}}

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

{{$student->nis}}

</div>
@endif


{{-- CARD NUMBER --}}
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

@endsection
 