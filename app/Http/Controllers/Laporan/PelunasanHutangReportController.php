<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\PelunasanHutang;
use Barryvdh\DomPDF\Facade as PDF;

class PelunasanHutangReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:laporan pelunasan hutang');
    }

    public function index()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        return view('laporan.pelunasan.hutang.index', compact('laporan'));
    }

    public function pdf()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        $toko = $this->getToko();

        $pdf = PDF::loadView('laporan.pelunasan.hutang.pdf',  compact('laporan', 'toko'))->setPaper('a4', 'potrait');

        $namaFile = trans('dashboard.laporan.pelunasan_hutang') . ' - ' . date('d F Y') . '.pdf';

        return $pdf->stream($namaFile);
    }

    protected function getLaporan()
    {
        return PelunasanHutang::with('pembelian', 'pembelian.supplier', 'pembelian.matauang', 'bank', 'rekening_bank')
            ->when(request()->query('jenis_pembayaran'), function ($q) {
                $q->where('jenis_pembayaran', request()->query('jenis_pembayaran'));
            })
            ->whereHas('pembelian', function ($q) {
                $q->when(request()->query('pembelian'), function ($q) {
                    $q->where('id',  request()->query('pembelian'));
                });
            })
            ->whereHas('pembelian.supplier', function ($q) {
                $q->when(request()->query('supplier'), function ($q) {
                    $q->where('id',  request()->query('supplier'));
                });
            })
            ->whereHas('pembelian.matauang', function ($q) {
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
