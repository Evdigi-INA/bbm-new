<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\CekGiro;
use Barryvdh\DomPDF\Facade as PDF;

class CekGiroReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:laporan cek/giro');
    }

    public function index()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        return view('laporan.cek-giro.index', compact('laporan'));
    }

    public function pdf()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        $toko = $this->getToko();

        $pdf = PDF::loadView('laporan.cek-giro.pdf',  compact('laporan', 'toko'))->setPaper('a4', 'potrait');

        $namaFile = trans('dashboard.laporan.cek_giro') . ' - ' . date('d F Y') . '.pdf';

        return $pdf->stream($namaFile);
    }

    protected function getLaporan()
    {
        return CekGiro::with(
            'pembelian:id,kode,supplier_id,matauang_id',
            'penjualan:id,kode,pelanggan_id,matauang_id',
            'pencairan_cek',
            'tolak_cek',
            'pembelian.matauang:id,kode',
            'pembelian.supplier:id,nama_supplier',
            'pembelian.pembelian_pembayaran',
            'penjualan.matauang',
            'penjualan.pelanggan:id,nama_pelanggan',
            'penjualan.penjualan_pembayaran',
            'pencairan_cek.rekening',
            'pencairan_cek.bank',
            // 'tolak_cek.rekening',
            // 'tolak_cek.bank',
        )
            ->when(request()->query('jenis_cek'), function ($q) {
                $q->where('jenis_cek',  request()->query('jenis_cek'));
            })
            ->when(request()->query('status'), function ($q) {
                $q->where('status',  request()->query('status'));
            })
            ->get();
    }
}
