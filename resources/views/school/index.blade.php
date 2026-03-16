@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Profil Pesantren</h2>

<form action="{{ route('school.store') }}" method="POST">
    @include('school.form')
</form>
@endsection