<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\PesananPenjualan;
use Barryvdh\DomPDF\Facade as PDF;

class PesananPenjualanReportController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:laporan pesanan penjualan');
    }

    public function index()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        return view('laporan.penjualan.pesanan.index', compact('laporan'));
    }

    public function pdf()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        $toko = $this->getToko();

        $pdf = PDF::loadView('laporan.penjualan.pesanan.pdf',  compact('laporan', 'toko'))->setPaper('a4', 'potrait');

        $namaFile = trans('dashboard.laporan.pesanan_penjualan') . ' - ' . date('d F Y') . '.pdf';

        return $pdf->stream($namaFile);
    }

    protected function getLaporan()
    {
        return PesananPenjualan::with(
            'pesanan_penjualan_detail',
            'pesanan_penjualan_detail.barang',
            'pelanggan:id,kode,nama_pelanggan',
            'matauang:id,kode,nama'
        )
            ->whereHas('pesanan_penjualan_detail.barang', function ($q) {
                $q->when(request()->query('barang'), function ($q) {
                    $q->where('barang_id',  request()->query('barang'));
                });
            })
            ->when(request()->query('bentuk_kepemilikan_stok'), function ($q) {
                $q->where('bentuk_kepemilikan_stok',  request()->query('bentuk_kepemilikan_stok'));
            })
            ->when(request()->query('pelanggan'), function ($q) {
                $q->where('pelanggan_id',  request()->query('pelanggan'));
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
