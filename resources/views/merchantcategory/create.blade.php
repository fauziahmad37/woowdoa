@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Tambah Merchant Category</h2>

<form action="{{ route('merchantcategory.store') }}" method="POST">
    @include('merchantcategory.form')
</form>
@endsection