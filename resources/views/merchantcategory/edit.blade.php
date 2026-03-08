@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Edit Merchant Category</h2>

<form action="{{ route('merchantcategory.update', $merchantcategory->id) }}" method="POST">
    @method('PUT')
    @include('merchantcategory.form')
</form>
@endsection