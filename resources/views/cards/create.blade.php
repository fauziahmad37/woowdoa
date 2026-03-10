@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Daftar Kartu Santri</h2>

<form action="{{ route('card.store') }}" method="POST">
    @include('cards.form')
</form>
@endsection