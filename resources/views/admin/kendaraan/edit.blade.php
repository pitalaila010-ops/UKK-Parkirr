@extends('layouts.app') 
@section('content') 
<h3>Edit Kendaraan</h3> 
 
<form method="POST" action="{{ route('admin.kendaraan.update', $kendaraan->id_kendaraan) }}"> 
    @csrf @method('PUT') 
    <div class="mb-3"> 
        <label>Plat Nomor</label> 
        <input type="text" name="plat_nomor" class="form-control" value="{{ $kendaraan->plat_nomor }}" required> 
    </div> 
    <div class="mb-3"> 
        <label>Jenis Kendaraan</label> 
        <select name="jenis_kendaraan" class="form-control" required>
            <option value="">Pilih Jenis Kendaraan</option>
            <option value="motor">Motor</option>
            <option value="mobil">Mobil</option>
            <option value="lainnya">Lainnya</option>
        </select>
    </div> 
    <div class="mb-3"> 
        <label>Warna</label> 
        <input type="text" name="warna" class="form-control" value="{{ $kendaraan->warna }}" required> 
    </div> 
    <div class="mb-3"> 
        <label>Pemilik</label> 
        <input type="text" name="pemilik" class="form-control" value="{{ $kendaraan->pemilik }}" required> 
    </div> 
    <button class="btn btn-primary">Update</button> 
    <a href="{{ route('admin.kendaraan.index') }}" class="btn btn-secondary">Batal</a> 
</form> 
@endsection 