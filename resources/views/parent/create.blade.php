@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="container mx-auto px-4">

        <h2 class="text-xl font-semibold mb-6">
            Tambah Orangtua
        </h2>

        <div class="bg-white shadow-sm rounded-lg p-6">
            <form action="{{ route('parent.store') }}" method="POST">
                @include('parent.form', ['parent' => null])
            </form>
        </div>

    </div>
</div>
@endsection