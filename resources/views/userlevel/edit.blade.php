@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Edit User</h2>

<form action="{{ route('userlevel.update', $userlevel->user_level_id) }}" method="POST"> 
    @method('PUT')
    @include('userlevel.form')
</form>
@endsection