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

        // return $laporan;
        // die;
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
        return PelunasanHutang::with(
            'pelunasan_hutang_detail.pembelian',
            'pelunasan_hutang_detail.pembelian.supplier:id,kode,nama_supplier',
            'pelunasan_hutang_detail.pembelian.matauang:id,kode',
            'bank:id,kode,nama',
            'rekening_bank:id,nomor_rekening,nama_rekening'
        )
            ->when(request()->query('jenis_pembayaran'), function ($q) {
                $q->where('jenis_pembayaran', request()->query('jenis_pembayaran'));
            })
            // ->whereHas('pelunasan_hutang_detail.pembelian', function ($q) {
            //     $q->when(request()->query('pembelian'), function ($q) {
            //         $q->where('id',  request()->query('pembelian'));
            //     });

            //     $q->when(request()->query('supplier'), function ($q) {
            //         $q->where('supplier_id',  request()->query('supplier'));
            //     });
            // })
            ->whereHas('pelunasan_hutang_detail.pembelian.matauang', function ($q) {
                $q->when(request()->query('matauang'), function ($q) {
                    $q->where('id',  request()->query('matauang'));
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
