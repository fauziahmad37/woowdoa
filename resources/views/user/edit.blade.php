@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Edit User</h2>

<form action="{{ route('user.update', $user->id) }}" method="POST">
    @method('PUT')
    @include('user.form')
</form>
@endsection