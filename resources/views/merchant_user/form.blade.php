@extends('layouts.app')

@section('content')
<div class="py-6">
<div class="container mx-auto w-full px-4">

<h2 class="text-xl font-semibold text-gray-700 mb-6">
{{ isset($user) ? 'Edit User Merchant' : 'Tambah User Merchant' }}
</h2>
<div class="bg-white shadow-sm sm:rounded-lg p-6">

@if ($errors->any())
<div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
<ul>
@foreach ($errors->all() as $error)
<li>• {{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<form action="{{ isset($user) ? route('merchant.user.update', $user->id) : route('merchant.user.store') }}" 
      method="POST" enctype="multipart/form-data">

@csrf

@if(isset($user))
    @method('PUT')
@endif
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

{{-- OWNER NAME --}}
<div>
<label class="block font-medium mb-1">
Nama User <span class="text-red-500">*</span>
</label>
<input type="text" name="owner_name"
class="w-full border rounded-lg px-3 py-2"
value="{{ old('owner_name', $user->owner_name ?? '') }}">
</div>

{{-- USERNAME --}}
<div>
<label class="block font-medium mb-1">
Username <span class="text-red-500">*</span>
</label>

<input type="text" name="username"
class="w-full border rounded-lg px-3 py-2"
value="{{ old('username', $user->user->username ?? '') }}">
</div>

{{-- EMAIL --}}
<div>
<label class="block font-medium mb-1">Email</label>
<input type="email" name="email"
class="w-full border rounded-lg px-3 py-2"
value="{{ old('email', $user->email ?? '') }}">
</div>

{{-- PHONE --}}
<div>
<label class="block font-medium mb-1">Phone</label>
<input type="text" name="phone"
class="w-full border rounded-lg px-3 py-2"
value="{{ old('phone', $user->phone ?? '') }}">
</div>




{{-- PASSWORD --}}
<div>
<label class="block font-medium mb-1">
Password
@if(!isset($user))
<span class="text-red-500">*</span>
@endif
</label>

<input type="password" name="password"
class="w-full border rounded-lg px-3 py-2">

@if(isset($user))
<small class="text-gray-500">
Kosongkan jika tidak ingin mengubah password
</small>
@endif

</div>


{{-- MERCHANT --}}
<div>
<label class="block font-medium mb-1">
Merchant <span class="text-red-500">*</span>
</label>

<select name="merchant_id"
class="w-full border rounded-lg px-3 py-2">

<option value="">Pilih Merchant</option>

@foreach($merchants as $merchant)
<option value="{{ $merchant->id }}"
{{ old('merchant_id', $user->merchant_id ?? '') == $merchant->id ? 'selected' : '' }}>
{{ $merchant->merchant_name }}
</option>
@endforeach

</select>
</div>


{{-- SCHOOL --}}
<div>
<label class="block font-medium mb-1">
Sekolah
</label>

<select name="school_id" class="w-full border rounded-lg px-3 py-2">
<option value="">Pilih Sekolah</option>

@foreach($schools as $school)
<option value="{{ $school->id }}"
{{ old('school_id', $user->user->school_id ?? '') == $school->id ? 'selected' : '' }}>
{{ $school->school_name }}
</option>
@endforeach

</select>
</div>



{{-- USER TYPE --}}
<div>
<label class="block font-medium mb-1">
User Type
</label>

<select name="user_type"
class="w-full border rounded-lg px-3 py-2">

<option value="">Pilih Level</option>

@foreach($levels as $level)
<option value="{{ $level->user_level_id }}"
{{ old('user_type', $user->user_type ?? '') == $level->user_level_id ? 'selected' : '' }}>
{{ $level->user_level_name }}
</option>
@endforeach

</select>
</div>



{{-- PROVINSI --}}
<div>
<label class="block font-medium mb-1">
Provinsi <span class="text-red-500">*</span>
</label>

<select id="provinsi" name="province_id"
class="w-full border rounded-lg px-3 py-2 select2">

<option value="">-- Pilih Provinsi --</option>

@foreach($provinsi as $prov)
<option value="{{ $prov->id }}"
{{ old('province_id', $user->province_id ?? '') == $prov->id ? 'selected' : '' }}>
{{ $prov->name }}
</option>
@endforeach

</select>
</div>



{{-- KOTA --}}
<div>
<label class="block font-medium mb-1">
Kota/Kabupaten <span class="text-red-500">*</span>
</label>
<select id="kota" name="city_id"
class="w-full border rounded-lg px-3 py-2 select2">

<option value="">-- Pilih Kota --</option>

@foreach($kota as $k)
<option value="{{ $k->id }}"
{{ old('city_id', $user->city_id ?? '') == $k->id ? 'selected' : '' }}>
{{ $k->name }}
</option>
@endforeach

</select>
</div>


{{-- KECAMATAN --}}
<div>
<label class="block font-medium mb-1">
Kecamatan <span class="text-red-500">*</span>
</label>

<select id="kecamatan" name="district_id"
class="w-full border rounded-lg px-3 py-2 select2">

<option value="">-- Pilih Kecamatan --</option>

@foreach($kecamatan as $kec)
<option value="{{ $kec->id }}"
{{ old('district_id', $user->district_id ?? '') == $kec->id ? 'selected' : '' }}>
{{ $kec->name }}
</option>
@endforeach

</select>
</div>


{{-- KELURAHAN --}}
<div>
<label class="block font-medium mb-1">
Kelurahan / Desa <span class="text-red-500">*</span>
</label>

<select id="kelurahan" name="village_id"
class="w-full border rounded-lg px-3 py-2 select2">

<option value="">-- Pilih Kelurahan --</option>

@foreach($kelurahan as $kel)
<option value="{{ $kel->id }}"
{{ old('village_id', $user->village_id ?? '') == $kel->id ? 'selected' : '' }}>
{{ $kel->name }}
</option>
@endforeach

</select>
</div>

</div>

<div class="md:col-span-2">
<label class="block font-medium mb-1">
Alamat
</label>

<textarea name="address"
class="w-full border rounded-lg px-3 py-2"
rows="3">{{ old('address', $user->address ?? '') }}</textarea>
</div>

{{-- PROFILE PHOTO --}}
<div>
<label class="block font-medium mb-1">
Profile Photo
</label>

<input type="file" name="profile_photo"
class="w-full border rounded-lg px-3 py-2">

@if(isset($user->user) && $user->user->profile_photo)
<img src="{{ asset('storage/'.$user->user->profile_photo) }}"
class="mt-3 w-20 h-20 rounded-full object-cover border">
@endif

</div>

<div class="flex justify-end mt-6">
<button type="submit"
class="text-white px-6 py-2 rounded-lg"
style="background: linear-gradient(203.18deg, #01AB14 11.82%, #085410 85.47%);">
Simpan Data
</button>
</div>

</form>

</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function(){

$('#provinsi').change(function(){

let id = $(this).val()

$('#kota').html('<option value="">Loading...</option>')

$.get('/merchant/kota/'+id,function(res){

$('#kota').html('<option value="">-- Pilih Kota --</option>')

res.forEach(function(item){
$('#kota').append(`<option value="${item.id}">${item.name}</option>`)
})

})

})


$('#kota').change(function(){

let id = $(this).val()

$('#kecamatan').html('<option value="">Loading...</option>')

$.get('/merchant/kecamatan/'+id,function(res){

$('#kecamatan').html('<option value="">-- Pilih Kecamatan --</option>')

res.forEach(function(item){
$('#kecamatan').append(`<option value="${item.id}">${item.name}</option>`)
})

})

})


$('#kecamatan').change(function(){

let id = $(this).val()

$('#kelurahan').html('<option value="">Loading...</option>')

$.get('/merchant/kelurahan/'+id,function(res){

$('#kelurahan').html('<option value="">-- Pilih Kelurahan --</option>')

res.forEach(function(item){
$('#kelurahan').append(`<option value="${item.id}">${item.name}</option>`)
})

})

})

});
</script>
@endsection


