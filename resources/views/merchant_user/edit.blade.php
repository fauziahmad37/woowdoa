@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Edit User Merchant</h2>

<form action="{{ route('merchant.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @include('merchant_user.form')

</form>
@endsection