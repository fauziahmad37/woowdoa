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

<div class="card">

<img src="{{asset($design->back_background)}}" class="bg">

 

</div> 
<script>
window.print();
</script>

@endsection
 