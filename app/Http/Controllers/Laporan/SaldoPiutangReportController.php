<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use Barryvdh\DomPDF\Facade as PDF;

class SaldoPiutangReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:laporan saldo piutang');
    }

    public function index()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        return view('laporan.saldo.piutang.index', compact('laporan'));
    }

    public function pdf()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        $toko = $this->getToko();

        $pdf = PDF::loadView('laporan.saldo.piutang.pdf',  compact('laporan', 'toko'))->setPaper('a4', 'potrait');

        $namaFile = trans('dashboard.laporan.saldo_piutang') . ' - ' . date('d F Y') . '.pdf';

        return $pdf->stream($namaFile);
    }

    protected function getLaporan()
    {
        return Penjualan::with(
            'penjualan_pembayaran',
            'matauang:id,kode',
            'pelanggan:id,nama_pelanggan',
            'salesman:id,nama'
        )
            ->when(request()->query('matauang'), function ($q) {
                $q->where('matauang_id',  request()->query('matauang'));
            })
            ->when(request()->query('pelanggan'), function ($q) {
                $q->where('pelanggan_id',  request()->query('pelanggan'));
            })
            ->when(request()->query('salesman'), function ($q) {
                $q->where('salesman_id',  request()->query('salesman'));
            })
            ->when(request()->query('status'), function ($q) {
                $q->where('status',  request()->query('status'));
            })
            ->where('tanggal', '<=',  request()->query('per_tanggal'))
            ->get();
    }
}
