@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Daftar User</h2>

<form action="{{ route('user.store') }}" method="POST">
    @include('user.form')
</form>
@endsection