@extends('layouts.app')

@section('content')

<h2 class="text-xl font-bold mb-4">Tambah User Merchant</h2>

<form action="{{ route('merchant.user.store') }}" method="POST" enctype="multipart/form-data">

    @csrf

    @include('merchant_user.form')

</form>

@endsection