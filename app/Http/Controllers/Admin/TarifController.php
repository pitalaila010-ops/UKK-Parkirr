<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tarif;
use App\Models\LogAktivitas;

class TarifController extends Controller
{
    public function index()
    {
        $tarif = Tarif::latest()->paginate(10);

        return view('admin.tarif.index', compact('tarif'));
    }

    public function create()
    {
        return view('admin.tarif.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_kendaraan' => 'required|in:motor,mobil,lainnya',
            'tarif_per_jam' => 'required|numeric|min:0',
        ]);

        Tarif::create([
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'tarif_per_jam' => $request->tarif_per_jam,
        ]);

        LogAktivitas::create([
            'id_user' => auth()->id(),
            'aktivitas' => 'Menambahkan tarif ' . $request->jenis_kendaraan,
            'waktu_aktivitas' => now(),
        ]);

        return redirect()
            ->route('admin.tarif.index')
            ->with('success', 'Tarif ditambahkan.');
    }

    public function edit(Tarif $tarif)
    {
        return view('admin.tarif.edit', compact('tarif'));
    }

    public function update(Request $request, Tarif $tarif)
    {
        $request->validate([
            'jenis_kendaraan' => 'required|in:motor,mobil,lainnya',
            'tarif_per_jam' => 'required|numeric|min:0',
        ]);

        $data = $request->only('jenis_kendaraan', 'tarif_per_jam');

        $tarif->update($data);

        LogAktivitas::create([
            'id_user' => auth()->id(),
            'aktivitas' => 'Mengedit tarif ' . $tarif->jenis_kendaraan,
            'waktu_aktivitas' => now(),
        ]);

        return redirect()
            ->route('admin.tarif.index')
            ->with('success', 'Tarif berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tarif = Tarif::findOrFail($id);

        if ($tarif->transaksi()->exists()) {
            return redirect()->route('admin.tarif.index')
                ->with('error', 'Tarif tidak bisa dihapus karena sudah digunakan dalam transaksi');
        }

        $jenisKendaraan = $tarif->jenis_kendaraan;

        $tarif->delete();

        LogAktivitas::create([
            'id_user' => auth()->id(),
            'aktivitas' => 'Menghapus tarif ' . $jenisKendaraan,
            'waktu_aktivitas' => now(),
        ]);

        return redirect()->route('admin.tarif.index')
            ->with('success', 'Tarif berhasil dihapus');
    }
}