<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraan = Kendaraan::latest()->paginate(10);

        return view('admin.kendaraan.index', compact('kendaraan'));
    }

    public function create()
    {
        return view('admin.kendaraan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required|string|max:15',
            'jenis_kendaraan' => 'required|string',
            'pemilik' => 'required|string',
        ]);

        Kendaraan::create([
            'plat_nomor' => $request->plat_nomor,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'warna' => $request->warna,
            'pemilik' => $request->pemilik,
            'id_user' => auth()->id(),
        ]);

        LogAktivitas::create([
            'id_user' => auth()->id(),
            'aktivitas' => 'Menambahkan kendaraan ' . $request->plat_nomor,
            'waktu_aktivitas' => now(),
        ]);

        return redirect()->route('admin.kendaraan.index')
            ->with('success', 'Kendaraan ditambahkan.');
    }

    public function edit(Kendaraan $kendaraan)
    {
        return view('admin.kendaraan.edit', compact('kendaraan'));
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $request->validate([
            'plat_nomor' => 'required|string|max:15',
            'jenis_kendaraan' => 'required|string',
            'pemilik' => 'required|string',
            'warna' => 'required|string',
        ]);

        $data = $request->only(
            'plat_nomor',
            'jenis_kendaraan',
            'pemilik',
            'warna'
        );

        $kendaraan->update($data);

        LogAktivitas::create([
            'id_user' => auth()->id(),
            'aktivitas' => 'Mengedit kendaraan ' . $kendaraan->plat_nomor,
            'waktu_aktivitas' => now(),
        ]);

        return redirect()->route('admin.kendaraan.index')
            ->with('success', 'kendaraan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        if ($kendaraan->transaksi()->exists()) {
            return redirect()->route('admin.kendaraan.index')
                ->with('error', 'Kendaraan tidak bisa dihapus karena sudah digunakan dalam transaksi');
        }

        $platNomor = $kendaraan->plat_nomor;

        $kendaraan->delete();

        LogAktivitas::create([
            'id_user' => auth()->id(),
            'aktivitas' => 'Menghapus kendaraan ' . $platNomor,
            'waktu_aktivitas' => now(),
        ]);

        return redirect()->route('admin.kendaraan.index')
            ->with('success', 'Kendaraan berhasil dihapus');
    }
}