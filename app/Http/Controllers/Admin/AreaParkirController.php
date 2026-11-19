<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AreaParkir;
use App\Models\LogAktivitas;

class AreaParkirController extends Controller
{
    public function index()
    {
        $areas = AreaParkir::latest()->paginate(10);

        return view('admin.area.index', compact('areas'));
    }

    public function create()
    {
        return view('admin.area.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_area' => 'required|string|max:100',
            'kapasitas' => 'required|integer|min:1',
        ]);

        AreaParkir::create($request->only(
            'nama_area',
            'kapasitas'
        ));

        LogAktivitas::create([
            'id_user' => auth()->id(),
            'aktivitas' => 'Menambahkan area parkir ' . $request->nama_area,
            'waktu_aktivitas' => now(),
        ]);

        return redirect()
            ->route('admin.area.index')
            ->with('success', 'Area parkir ditambahkan.');
    }

    public function edit(AreaParkir $area)
    {
        return view('admin.area.edit', compact('area'));
    }

    public function update(Request $request, AreaParkir $area)
    {
        $request->validate([
            'nama_area' => 'required|string|max:100',
            'kapasitas' => 'required|integer|min:1',
        ]);

        $data = $request->only('nama_area', 'kapasitas');

        $area->update($data);

        LogAktivitas::create([
            'id_user' => auth()->id(),
            'aktivitas' => 'Mengedit area parkir ' . $area->nama_area,
            'waktu_aktivitas' => now(),
        ]);

        return redirect()
            ->route('admin.area.index')
            ->with('success', 'Area berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $area = AreaParkir::findOrFail($id);

        if ($area->transaksi()->exists()) {
            return redirect()->route('admin.area.index')
                ->with('error', 'Area Parkir tidak bisa dihapus karena sudah digunakan dalam transaksi');
        }

        $namaArea = $area->nama_area;

        $area->delete();

        LogAktivitas::create([
            'id_user' => auth()->id(),
            'aktivitas' => 'Menghapus area parkir ' . $namaArea,
            'waktu_aktivitas' => now(),
        ]);

        return redirect()->route('admin.area.index')
            ->with('success', 'Area Parkir berhasil dihapus');
    }
}