@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Pengajuan Kartu Santri</h2>

<form action="{{ route('cardrequest.store') }}" method="POST">
    @include('cardrequest.form')
</form>
@endsection