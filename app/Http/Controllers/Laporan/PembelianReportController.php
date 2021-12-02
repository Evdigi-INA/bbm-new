<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use Barryvdh\DomPDF\Facade as PDF;

class PembelianReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:laporan pembelian');
    }

    public function index()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        return view('laporan.pembelian.pembelian.index', compact('laporan'));
    }

    public function pdf()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        $toko = $this->getToko();

        $pdf = PDF::loadView('laporan.pembelian.pembelian.pdf',  compact('laporan', 'toko'))->setPaper('a4', 'potrait');

        $namaFile = trans('dashboard.laporan.pembelian') . ' - ' . date('d F Y') . '.pdf';

        return $pdf->stream($namaFile);
    }

    protected function getLaporan()
    {

        return Pembelian::with(
            'pembelian_detail',
            'pembelian_detail.barang',
            'supplier:id,nama_supplier',
            'matauang:id,kode',
            'gudang:id,nama'
        )
            ->when(request()->query('supplier'), function ($q) {
                $q->where('supplier_id',  request()->query('supplier'));
            })
            ->when(request()->query('gudang'), function ($q) {
                $q->where('gudang_id',  request()->query('gudang'));
            })
            ->whereHas('pembelian_detail', function ($q) {
                $q->when(request()->query('bentuk_kepemilikan_stok'), function ($q) {
                    $q->where('bentuk_kepemilikan_stok',  request()->query('bentuk_kepemilikan_stok'));
                });
            })
            ->whereHas('pembelian_detail.barang', function ($q) {
                $q->when(request()->query('barang'), function ($q) {
                    $q->where('barang_id',  request()->query('barang'));
                });
            })
            ->whereBetween('tanggal', [
                request()->query('dari_tanggal'),
                request()->query('sampai_tanggal')
            ])
            ->get();
    }
}
