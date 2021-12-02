<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Biaya;
use Barryvdh\DomPDF\Facade as PDF;

class BiayaReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:laporan biaya');
    }

    public function index()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        return view('laporan.biaya.index', compact('laporan'));
    }

    public function pdf()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        $toko = $this->getToko();

        $pdf = PDF::loadView('laporan.biaya.pdf',  compact('laporan', 'toko'))->setPaper('a4', 'potrait');

        $namaFile = trans('dashboard.laporan.biaya') . ' - ' . date('d F Y') . '.pdf';

        return $pdf->stream($namaFile);
    }

    protected function getLaporan()
    {
        return Biaya::with('matauang', 'rekening', 'bank', 'biaya_detail')
            ->when(request()->query('kas_bank') == 'Kas', function ($q) {
                $q->where('jenis_transaksi', request()->query('kas_bank'));
            })
            ->when(request()->query('kas_bank') && request()->query('kas_bank') != 'Kas', function ($q) {
                $q->where('bank_id',  request()->query('kas_bank'));
            })
            ->whereBetween('tanggal', [
                request()->query('dari_tanggal'),
                request()->query('sampai_tanggal')
            ])
            ->get();
    }
}
