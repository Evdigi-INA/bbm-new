<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\ReturPembelian;
use Barryvdh\DomPDF\Facade as PDF;

class ReturPembelianReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:laporan retur pembelian');
    }

    public function index()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        return view('laporan.pembelian.retur.index', compact('laporan'));
    }

    public function pdf()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        $toko = $this->getToko();

        $pdf = PDF::loadView('laporan.pembelian.retur.pdf',  compact('laporan', 'toko'))->setPaper('a4', 'potrait');

        $namaFile = trans('dashboard.laporan.retur_pembelian') . ' - ' . date('d F Y') . '.pdf';

        return $pdf->stream($namaFile);
    }

    protected function getLaporan()
    {
        return ReturPembelian::with(
            'retur_pembelian_detail',
            'retur_pembelian_detail.barang',
            'pembelian.supplier',
            'pembelian.matauang',
            'gudang'
        )
            ->whereHas('retur_pembelian_detail', function ($q) {
                $q->when(request()->query('bentuk_kepemilikan_stok'), function ($q) {
                    $q->where('bentuk_kepemilikan_stok',  request()->query('bentuk_kepemilikan_stok'));
                });
            })
            ->whereHas('retur_pembelian_detail.barang', function ($q) {
                $q->when(request()->query('barang'), function ($q) {
                    $q->where('barang_id',  request()->query('barang'));
                });
            })
            ->whereHas('pembelian.supplier', function ($q) {
                $q->when(request()->query('supplier'), function ($q) {
                    $q->where('id',  request()->query('supplier'));
                });
            })
            ->when(request()->query('gudang'), function ($q) {
                $q->where('gudang_id',  request()->query('gudang'));
            })
            ->whereBetween('tanggal', [
                request()->query('dari_tanggal'),
                request()->query('sampai_tanggal')
            ])
            ->get();
    }
}
