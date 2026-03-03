@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Tambah Santri</h2>

<form action="{{ route('santri.store') }}" method="POST">
    @include('santri.form')
</form>
@endsection