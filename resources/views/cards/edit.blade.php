@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Pengajuan Kartu Santri</h2>

<form action="{{ route('cardrequest.update', $cardrequest->id) }}" method="POST">
    @method('PUT')
    @include('cardrequest.form')
</form>
@endsection