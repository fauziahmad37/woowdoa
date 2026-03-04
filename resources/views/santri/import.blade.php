@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto bg-white shadow-sm rounded-lg p-6">

<h2 class="text-xl font-semibold mb-4">
Import Data Santri
</h2>

<p class="text-gray-600 mb-4">
Silakan upload file Excel sesuai dengan format template.
</p>

<!-- Download Template -->
<div class="mb-4">
<a href="{{ asset('template/template_santri.xlsx') }}"
class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
Download Template Excel
</a>
</div>

<form action="{{ route('santri.import') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="mb-4">
<input type="file"
name="file"
class="border w-full p-2 rounded"
required>
</div>

<div class="flex gap-2">

<button type="submit"
class="bg-green-600 text-white px-4 py-2 rounded hover:bg-blue-700">
Import Data
</button>

<a href="{{ route('santri.index') }}"
class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
Kembali
</a>

</div>

</form>

</div>

@endsection