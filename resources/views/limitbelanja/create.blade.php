@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Tambah Limit Belanja</h2>

<form action="{{ route('limitbelanja.store') }}" method="POST">
    @include('limitbelanja.form')
</form>
@endsection