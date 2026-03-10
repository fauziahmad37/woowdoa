@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Edit Limit Belanja</h2>

<form action="{{ route('limitbelanja.update', $limitbelanja->id) }}" method="POST">
    @method('PUT')
    @include('limitbelanja.form')
</form>
@endsection