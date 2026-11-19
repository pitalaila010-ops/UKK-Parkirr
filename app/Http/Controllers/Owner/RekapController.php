<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\LogAktivitas;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['kendaraan', 'area'])->where('status', 'keluar');

        if ($request->filled('dari') && $request->filled('sampai')) {
            $query->whereBetween('waktu_keluar', [
                $request->dari . ' 00:00:00',
                $request->sampai . ' 23:59:59',
            ]);
        }

        $transaksis = $query->latest('waktu_keluar')->paginate(15)->withQueryString();

        $totalPendapatan = (clone $query)->sum('biaya_total');

        LogAktivitas::create([
            'id_user' => auth()->id(),
            'aktivitas' => 'Melihat rekap parkir',
            'waktu_aktivitas' => now(),
        ]);

        return view('owner.rekap.index', compact('transaksis', 'totalPendapatan'));
    }
}