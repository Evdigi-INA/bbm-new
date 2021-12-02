<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index()
    {
        $total_penjualan = DB::table('penjualan')->whereYear('tanggal', date('Y'))->count();
        $total_pembelian = DB::table('pembelian')->whereYear('tanggal', date('Y'))->count();

        $total_cek_giro_cair = DB::table('cek_giro_cair')->whereYear('tanggal', date('Y'))->count();
        $total_cek_giro_tolak = DB::table('cek_giro_tolak')->whereYear('tanggal', date('Y'))->count();

        $barang_paling_laku = PenjualanDetail::with('penjualan:id,tanggal', 'barang:id,kode,nama,gambar')
            ->whereHas('penjualan', function ($q) {
                $q->whereYear('tanggal', date('Y'));
            })
            ->groupBy('barang_id')
            ->selectRaw('barang_id, qty, harga, sum(penjualan_detail.qty) as sum_qty')
            ->orderByRaw('sum(qty) desc')
            ->limit(5)
            ->get();

        // januari s/d maret
        $triwulan1 = DB::table('penjualan')
            ->whereYear('tanggal', date('Y'))
            ->whereMonth('tanggal', '>=', 1)
            ->whereMonth('tanggal', '<=', 3)
            ->count();

        // april s/d mei
        $triwulan2 = DB::table('penjualan')
            ->whereYear('tanggal', date('Y'))
            ->whereMonth('tanggal', '>=', 4)
            ->whereMonth('tanggal', '<=', 6)
            ->count();

        // juni s/d agustus
        $triwulan3 = DB::table('penjualan')
            ->whereYear('tanggal', date('Y'))
            ->whereMonth('tanggal', '>=', 7)
            ->whereMonth('tanggal', '<=', 9)
            ->count();

        // september s/d desember
        $triwulan4 = DB::table('penjualan')
            ->whereYear('tanggal', date('Y'))
            ->whereMonth('tanggal', '>=', 10)
            ->whereMonth('tanggal', '<=', 12)
            ->count();

        $penjualan_per_bulan = [];

        for ($i = 1; $i <= 12; $i++) {
            $penjualan_per_bulan[] = DB::table('penjualan')
                ->whereYear('tanggal', date('Y'))
                ->whereMonth('tanggal', $i)
                ->count();
        }

        $pembelian_per_bulan = [];

        for ($i = 1; $i <= 12; $i++) {
            $pembelian_per_bulan[] = DB::table('pembelian')
                ->whereYear('tanggal', date('Y'))
                ->whereMonth('tanggal', $i)
                ->count();
        }

        return view('dashboard.index', [
            'total_penjualan' => $total_penjualan,
            'total_pembelian' => $total_pembelian,
            'total_cek_giro_cair' => $total_cek_giro_cair,
            'total_cek_giro_tolak' => $total_cek_giro_tolak,
            'barang_paling_laku' => $barang_paling_laku,
            'triwulan1' => $triwulan1,
            'triwulan2' => $triwulan2,
            'triwulan3' => $triwulan3,
            'triwulan4' => $triwulan4,
            'penjualan_per_bulan' => json_encode($penjualan_per_bulan),
            'pembelian_per_bulan' => json_encode($pembelian_per_bulan),
        ]);
    }
}
