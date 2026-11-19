
@extends('layouts.app')

@section('content')

<h3>Data kendaraan</h3>

<a href="{{ route('admin.kendaraan.create') }}" class="btn btn-primary mb-3">
    + Tambah Kendaraan
</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Nomor Plat</th>
            <th>Jenis kendaraan</th>
            <th>Pemilik</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach($kendaraan as $i => $item)
        <tr>
            <td>{{ $kendaraan->firstItem() + $i }}</td>
            <td>{{ $item->plat_nomor }}</td>
            <td>{{ $item->jenis_kendaraan }}</td>
            <td>{{ $item->pemilik }}</td>

            <td>
                <a href="{{ route('admin.kendaraan.edit', $item->id_kendaraan) }}"
                   class="btn btn-sm btn-warning">Edit</a>

                <form action="{{ route('admin.kendaraan.destroy', $item->id_kendaraan) }}"
                      method="POST"
                      class="d-inline"
                      onsubmit="return confirm('Yakin hapus kendaraan ini?')">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $kendaraan->links() }}

@endsection
