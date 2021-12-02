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
        return PelunasanPiutang::with('penjualan', 'penjualan.pelanggan', 'penjualan.matauang', 'bank', 'rekening_bank')
            ->when(request()->query('jenis_pembayaran'), function ($q) {
                $q->where('jenis_pembayaran', request()->query('jenis_pembayaran'));
            })
            ->whereHas('penjualan', function ($q) {
                $q->when(request()->query('penjualan'), function ($q) {
                    $q->where('id',  request()->query('penjualan'));
                });
            })
            ->whereHas('penjualan.pelanggan', function ($q) {
                $q->when(request()->query('pelanggan'), function ($q) {
                    $q->where('id',  request()->query('pelanggan'));
                });
            })
            ->whereHas('penjualan.matauang', function ($q) {
                $q->when(request()->query('matauang'), function ($q) {
                    $q->where('id',  request()->query('matauang'));
                });
            })
            ->whereBetween('tanggal', [
                request()->query('dari_tanggal'),
                request()->query('sampai_tanggal')
            ])
            ->get();
    }
}
