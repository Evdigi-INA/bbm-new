<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\PelunasanPiutang;
use Barryvdh\DomPDF\Facade as PDF;

class PelunasanPiutangReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:laporan pelunasan piutang');
    }

    public function index()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        return view('laporan.pelunasan.piutang.index', compact('laporan'));
    }

    public function pdf()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        $toko = $this->getToko();

        $pdf = PDF::loadView('laporan.pelunasan.piutang.pdf',  compact('laporan', 'toko'))->setPaper('a4', 'potrait');

        $namaFile = trans('dashboard.laporan.pelunasan_piutang') . ' - ' . date('d F Y') . '.pdf';

        return $pdf->stream($namaFile);
    }

    protected function getLaporan()
    {
        return PelunasanPiutang::with(
            'pelunasan_piutang_detail.penjualan',
            'pelunasan_piutang_detail.penjualan.pelanggan:id,nama_pelanggan',
            'pelunasan_piutang_detail.penjualan.matauang:id,kode',
            'bank:id,kode,nama',
            'rekening_bank:id,nomor_rekening,nama_rekening'
        )
            ->when(request()->query('jenis_pembayaran'), function ($q) {
                $q->where('jenis_pembayaran', request()->query('jenis_pembayaran'));
            })
            // ->when(request()->query('penjualan'), function ($q) {
            //     $q->whereHas('pelunasan_piutang_detail.penjualan', function ($q) {
            //         $q->where('id',  request()->query('penjualan'));
            //     });
            // })
            // ->when(request()->query('pelanggan'), function ($q) {
            //     $q->whereHas('pelunasan_piutang_detail.penjualan', function ($q) {
            //         $q->where('pelanggan_id',  request()->query('pelanggan'));
            //     });
            // })
            ->when(request()->query('matauang'), function ($q) {
                $q->whereHas('pelunasan_piutang_detail.penjualan', function ($q) {
                    $q->where('matauang_id',  request()->query('matauang'));
                });
            })
            ->whereBetween('tanggal', [
                request()->query('dari_tanggal'),
                request()->query('sampai_tanggal')
            ])
            ->limit(100)
            ->get();
    }
}
