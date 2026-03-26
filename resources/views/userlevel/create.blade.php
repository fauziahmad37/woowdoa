@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Daftar User Level</h2> 

<form action="{{ route('userlevel.store') }}" method="POST">
    @include('userlevel.form')
</form>
@endsection