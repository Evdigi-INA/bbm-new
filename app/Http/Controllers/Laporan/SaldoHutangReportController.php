<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use Barryvdh\DomPDF\Facade as PDF;

class SaldoHutangReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:laporan saldo hutang');
    }

    public function index()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        return view('laporan.saldo.hutang.index', compact('laporan'));
    }

    public function pdf()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        $toko = $this->getToko();

        $pdf = PDF::loadView('laporan.saldo.hutang.pdf',  compact('laporan', 'toko'))->setPaper('a4', 'potrait');

        $namaFile = trans('dashboard.laporan.saldo_hutang') . ' - ' . date('d F Y') . '.pdf';

        return $pdf->stream($namaFile);
    }

    protected function getLaporan()
    {
        return Pembelian::with(
            'pembelian_pembayaran',
            'matauang:id,kode',
            'supplier:id,nama_supplier'
        )
            ->when(request()->query('matauang'), function ($q) {
                $q->where('matauang_id',  request()->query('matauang'));
            })
            ->when(request()->query('supplier'), function ($q) {
                $q->where('supplier_id',  request()->query('supplier'));
            })
            ->when(request()->query('status'), function ($q) {
                $q->where('status',  request()->query('status'));
            })
            ->where('tanggal', '<=',  request()->query('per_tanggal'))
            ->get();
    }
}
