<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use Barryvdh\DomPDF\Facade as PDF;

class GrossProfitReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:laporan gross profit');
    }

    public function index()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        return view('laporan.profit.gross.index', compact('laporan'));
    }

    public function pdf()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        $toko = $this->getToko();

        $pdf = PDF::loadView('laporan.profit.gross.pdf',  compact('laporan', 'toko'))->setPaper('a4', 'potrait');

        $namaFile = trans('dashboard.laporan.profit_gross') . ' - ' . date('d F Y') . '.pdf';

        return $pdf->stream($namaFile);
    }

    protected function getLaporan()
    {
        return Penjualan::with(
            'penjualan_detail',
            'gudang:id,nama',
            'pelanggan:id,nama_pelanggan',
            'salesman:id,nama',
            'matauang:id,kode'
        )
            ->when(request()->query('pelanggan'), function ($q) {
                $q->where('pelanggan_id',  request()->query('pelanggan'));
            })
            ->when(request()->query('salesman'), function ($q) {
                $q->where('salesman_id',  request()->query('salesman'));
            })
            ->when(request()->query('gudang'), function ($q) {
                $q->where('gudang_id',  request()->query('gudang'));
            })
            ->whereHas('penjualan_detail', function ($q) {
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
