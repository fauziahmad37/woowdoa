@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Edit Merchant</h2>

<form action="{{ route('merchant.update', $merchant->id) }}" method="POST">
    @method('PUT')
    @include('merchant.form')
</form>
@endsection