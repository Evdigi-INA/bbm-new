<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\AdjustmentMinus;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;

class AdjustmentMinusReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:laporan adjustment minus');
    }

    public function index()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        return view('laporan.adjustment.minus.index', compact('laporan'));
    }

    public function pdf()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        $toko = $this->getToko();

        $pdf = PDF::loadView('laporan.adjustment.minus.pdf',  compact('laporan', 'toko'))->setPaper('a4', 'potrait');

        $namaFile = trans('dashboard.laporan.adjustment_minus') . ' - ' . date('d F Y') . '.pdf';

        return $pdf->stream($namaFile);

        // kalo pengen langsung download/tanpa priview
        // return $pdf->download($namaFile);
    }

    protected function getLaporan()
    {
        // Optional: ganti make query builder
        // return DB::table('adjustment_minus as am')
        //     ->join('adjusment_minus_detail as amd', 'amd.adjustment_minus_id', '=', 'am.id')
        //     ->join('barang as b', 'b.id', '=', 'amd.barang_id')
        //     ->join('gudang as g', 'gudang.id', '=', 'am.gudang_id')
        //     ->join('matauang as m', 'm.id', '=', 'am.matauang_id')
        //     ->select('*')
        //     ->get();

        // Optional: ganti make query builder
        return AdjustmentMinus::with(
            'gudang:id,kode,nama',
            'adjustment_minus_detail',
            'adjustment_minus_detail.barang:id,kode,nama,harga_jual,harga_beli',
            'adjustment_minus_detail.supplier:id,kode,nama_supplier',
        )
            ->whereHas('adjustment_minus_detail', function ($q) {
                $q->when(request()->query('bentuk_kepemilikan_stok'), function ($q) {
                    $q->where('bentuk_kepemilikan_stok',  request()->query('bentuk_kepemilikan_stok'));
                });

                $q->when(request()->query('supplier'), function ($q) {
                    $q->where('supplier_id',  request()->query('supplier'));
                });

                $q->when(request()->query('barang'), function ($q) {
                    $q->where('barang_id',  request()->query('barang'));
                });
            })
            ->whereHas('gudang', function ($q) {
                $q->when(request()->query('gudang'), function ($q) {
                    $q->where('id',  request()->query('gudang'));
                });
            })
            ->whereBetween('tanggal', [
                request()->query('dari_tanggal'),
                request()->query('sampai_tanggal')
            ])
            ->get();
    }
}
