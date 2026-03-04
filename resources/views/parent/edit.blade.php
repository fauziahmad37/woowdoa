@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="container mx-auto px-4">

        <h2 class="text-xl font-semibold mb-6">
            Edit Orangtua
        </h2>

        <div class="bg-white shadow-sm rounded-lg p-6">
            <form action="{{ route('parent.update', $parent->id) }}" method="POST">
                @method('PUT')
                @include('parent.form', ['parent' => $parent])
            </form>
        </div>

    </div>
</div>
@endsection