@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Edit Limit Belanja</h2>

<form action="{{ route('carddesign.update', $carddesign->id) }}" method="POST">
    @method('PUT')
    @include('carddesign.form')
</form>
@endsection