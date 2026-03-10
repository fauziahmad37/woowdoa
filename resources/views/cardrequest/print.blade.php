@extends('layouts.app')

@section('content')

<div style="
width:{{$design->width}}px;
height:{{$design->height}}px;
background-image:url('{{asset($design->background_image)}}');
position:relative;
">

<img src="{{asset($card->student->photo)}}"
style="position:absolute; left:30px; top:60px; width:80px;">

<div style="position:absolute; left:130px; top:80px;">
{{$card->student->name}}
</div>

<div style="position:absolute; left:130px; top:110px;">
{{$card->student->nis}}
</div>

<div style="position:absolute; left:130px; top:140px;">
{{$card->card_number}}
</div>

</div>

@endsection
 