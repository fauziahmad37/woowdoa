@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Edit Santri</h2>

<form action="{{ route('santri.update', $santri->id) }}" method="POST">
    @method('PUT')
    @include('santri.form')
</form>
@endsection