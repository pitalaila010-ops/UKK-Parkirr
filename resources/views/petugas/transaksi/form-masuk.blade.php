
@extends('layouts.app')

@section('content')

<h3>Catat Kendaraan Masuk</h3>

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<form method="POST" action="{{ route('petugas.transaksi.prosesMasuk') }}">
    @csrf

    <div class="mb-3">
        <label>Kendaraan</label>
        <select name="id_kendaraan" id="kendaraan" class="form-select" required>
            <option value="">-- Pilih Kendaraan --</option>

            @foreach($kendaraans as $k)
                <option value="{{ $k->id_kendaraan }}">
                    {{ $k->plat_nomor }} - {{ $k->pemilik }} - {{ $k->jenis_kendaraan }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Jenis Kendaraan</label>
        <input type="text" id="jenis_kendaraan" class="form-control" readonly
               placeholder="Otomatis">
    </div>

    <div class="mb-3">
        <label>Tarif Per Jam</label>
        <input type="text" id="tarif" class="form-control" readonly
               placeholder="Otomatis mengikuti tarif admin">
    </div>

    <div id="pesan-error" class="alert alert-danger" style="display:none"></div>

    <div class="mb-3">
        <label>Area Parkir</label>
        <select name="id_area" class="form-select" required>
            <option value="">-- Pilih Area --</option>

            @foreach($areas as $a)
                <option value="{{ $a->id_area }}">
                    {{ $a->nama_area }} ({{ $a->terisi }}/{{ $a->kapasitas }})
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" id="btn-simpan" class="btn btn-primary" disabled>
        Simpan
    </button>

</form>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const kendaraan = document.getElementById('kendaraan');
    const jenis = document.getElementById('jenis_kendaraan');
    const tarif = document.getElementById('tarif');
    const tombol = document.getElementById('btn-simpan');
    const pesan = document.getElementById('pesan-error');

    kendaraan.addEventListener('change', function () {

        jenis.value = '';
        tarif.value = '';
        tombol.disabled = true;
        pesan.style.display = 'none';

        if (!this.value) return;

        fetch('/petugas/get-tarif/' + this.value)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Tarif kendaraan belum diatur admin.');
                }
                return response.json();
            })
            .then(data => {

                jenis.value = data.jenis;

                tarif.value = 'Rp' +
                    Number(data.tarif).toLocaleString('id-ID') +
                    '/jam';

                tombol.disabled = false;

            })
            .catch(error => {

                pesan.textContent = error.message;
                pesan.style.display = 'block';

            });

    });

});
</script>

@endsection
