@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Tambah Merchant</h2>

<form action="{{ route('merchant.store') }}" method="POST">
    @include('merchant.form')
</form>
@endsection