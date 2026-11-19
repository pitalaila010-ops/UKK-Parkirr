@extends('layouts.app')

@section('content')

<h3>Data Tarif</h3>

<a href="{{ route('admin.tarif.create') }}" class="btn btn-primary mb-3">
    + Tambah Tarif
</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Jenis kendaraan</th>
            <th>Tarif Per jam</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach($tarif as $i => $item)
        <tr>
            <td>{{ $tarif->firstItem() + $i }}</td>

            <td>{{ $item->jenis_kendaraan }}</td>

            <td>{{ $item->tarif_per_jam }}</td>

            <td>
                <a href="{{ route('admin.tarif.edit', $item->id_tarif) }}"
                   class="btn btn-sm btn-warning">Edit</a>

                <form action="{{ route('admin.tarif.destroy', $item->id_tarif) }}"
                      method="POST"
                      class="d-inline"
                      onsubmit="return confirm('Yakin hapus tarif ini?')">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $tarif->links() }}

@endsection