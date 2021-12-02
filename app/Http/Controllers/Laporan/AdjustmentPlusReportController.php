<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\AdjustmentPlus;
use Barryvdh\DomPDF\Facade as PDF;

class AdjustmentPlusReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:laporan adjustment plus');
    }

    public function index()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        return view('laporan.adjustment.plus.index', compact('laporan'));
    }

    public function pdf()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        $toko = $this->getToko();

        $pdf = PDF::loadView('laporan.adjustment.plus.pdf',  compact('laporan', 'toko'))->setPaper('a4', 'potrait');

        $namaFile = trans('dashboard.laporan.adjustment_plus') . ' - ' . date('d F Y') . '.pdf';

        return $pdf->stream($namaFile);

        // kalo pengen langsung download/tanpa priview
        // return $pdf->download($namaFile);
    }

    protected function getLaporan()
    {
        // Optional: ganti make query builder
        return AdjustmentPlus::with(
            'gudang:id,kode,nama',
            'matauang:id,kode,nama',
            'adjustment_plus_detail',
            'adjustment_plus_detail.barang:id,kode,nama,harga_jual,harga_beli',
            'adjustment_plus_detail.supplier:id,kode,nama_supplier',
        )
            ->whereHas('adjustment_plus_detail', function ($q) {
                $q->when(request()->query('bentuk_kepemilikan_stok'), function ($q) {
                    $q->where('bentuk_kepemilikan_stok',  request()->query('bentuk_kepemilikan_stok'));
                });

                $q->when(request()->query('barang'), function ($q) {
                    $q->where('barang_id',  request()->query('barang'));
                });
            })
            ->whereHas('adjustment_plus_detail.supplier', function ($q) {
                $q->when(request()->query('supplier'), function ($q) {
                    $q->where('id',  request()->query('supplier'));
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
