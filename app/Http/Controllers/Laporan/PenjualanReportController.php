<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Penjualan;
use Barryvdh\DomPDF\Facade as PDF;

class PenjualanReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:laporan penjualan');
    }

    public function index()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        // return $laporan;
        // die;

        return view('laporan.penjualan.penjualan.index', compact('laporan'));
    }

    public function pdf()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        $toko = $this->getToko();

        $pdf = PDF::loadView('laporan.penjualan.penjualan.pdf',  compact('laporan', 'toko'))->setPaper('a4', 'potrait');

        $namaFile = trans('dashboard.laporan.penjualan') . ' - ' . date('d F Y') . '.pdf';

        return $pdf->stream($namaFile);
    }

    protected function getLaporan()
    {
        //
        return Penjualan::select('id', 'kode', 'tanggal', 'gudang_id', 'pelanggan_id', 'matauang_id', 'salesman_id', 'total_gross', 'total_diskon', 'total_netto', 'total_ppn', 'rate')->with(
            'penjualan_detail',
            'penjualan_detail.barang:id,kode,nama',
            'gudang:id,nama',
            'pelanggan:id,nama_pelanggan',
            'salesman:id,nama',
            'matauang:id,kode',
            'retur_penjualan:id,penjualan_id',
            'retur_penjualan.retur_penjualan_detail:retur_penjualan_id,id,qty_retur',
            // 'retur_penjualan.retur_penjualan_detail.barang:id,kode,nama',
        )
            ->when(request()->query('pelanggan'), function ($q) {
                $q->where('pelanggan_id',  request()->query('pelanggan'));
            })
            ->when(auth()->user()->hasRole('salesman'), function ($q) {
                $q->where('salesman_id',  auth()->user()->salesman->id);
            })
            ->when(request()->query('salesman') && auth()->user()->hasRole('admin'), function ($q) {
                $q->where('salesman_id',  request()->query('salesman'));
            })
            ->when(request()->query('gudang'), function ($q) {
                $q->where('gudang_id',  request()->query('gudang'));
            })
            ->whereHas('penjualan_detail', function ($q) {
                $q->when(request()->query('bentuk_kepemilikan_stok'), function ($q) {
                    $q->where('bentuk_kepemilikan_stok',  request()->query('bentuk_kepemilikan_stok'));
                });

                $q->when(request()->query('barang'), function ($q) {
                    $q->where('barang_id',  request()->query('barang'));
                });
            })
            ->whereBetween('tanggal', [
                request()->query('dari_tanggal'),
                request()->query('sampai_tanggal')
            ])
            ->limit(100)
            ->orderByDesc('id')
            ->get();
    }
}
