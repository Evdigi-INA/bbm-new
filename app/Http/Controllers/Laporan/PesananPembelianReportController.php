<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\PesananPembelian;
use Barryvdh\DomPDF\Facade as PDF;

class PesananPembelianReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:laporan pesanan pembelian');
    }

    public function index()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        return view('laporan.pembelian.pesanan.index', compact('laporan'));
    }

    public function pdf()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        $toko = $this->getToko();

        $pdf = PDF::loadView('laporan.pembelian.pesanan.pdf',  compact('laporan', 'toko'))->setPaper('a4', 'potrait');

        $namaFile = trans('dashboard.laporan.pesanan_pembelian') . ' - ' . date('d F Y') . '.pdf';

        return $pdf->stream($namaFile);
    }

    protected function getLaporan()
    {
        return PesananPembelian::with(
            'pesanan_pembelian_detail',
            'pesanan_pembelian_detail.barang',
            'supplier:id,kode,nama_supplier',
            'matauang:id,kode,nama'
        )
            ->whereHas('pesanan_pembelian_detail.barang', function ($q) {
                $q->when(request()->query('barang'), function ($q) {
                    $q->where('barang_id',  request()->query('barang'));
                });
            })
            ->when(request()->query('bentuk_kepemilikan_stok'), function ($q) {
                $q->where('bentuk_kepemilikan_stok',  request()->query('bentuk_kepemilikan_stok'));
            })
            ->when(request()->query('supplier'), function ($q) {
                $q->where('supplier_id',  request()->query('supplier'));
            })
            ->when(request()->query('status'), function ($q) {
                $q->where('status_po',  request()->query('status'));
            })
            ->whereBetween('tanggal', [
                request()->query('dari_tanggal'),
                request()->query('sampai_tanggal')
            ])
            ->get();
    }
}
