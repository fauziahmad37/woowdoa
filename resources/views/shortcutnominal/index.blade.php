@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Shortcut Nominal</h2>

<form action="{{ route('shortcutnominal.store') }}" method="POST">
    @include('shortcutnominal.form')
</form>
@endsection