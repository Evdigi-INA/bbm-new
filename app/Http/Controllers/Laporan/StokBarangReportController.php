<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\AdjustmentMinusDetail;
use App\Models\AdjustmentPlusDetail;
use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\PenjualanDetail;
use App\Models\ReturPembelianDetail;
use App\Models\ReturPenjualanDetail;
use Barryvdh\DomPDF\Facade as PDF;

class StokBarangReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:laporan stok barang');
    }

    public function index()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        // return $laporan;
        // die;

        // return $laporan['stok_retur_beli'];
        // die;

        // return $this->getLaporan();
        return view('laporan.stok.index', compact('laporan'));
    }

    public function pdf()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        $toko = $this->getToko();

        $pdf = PDF::loadView('laporan.stok.pdf',  compact('laporan', 'toko'))->setPaper('a4', 'potrait');

        $namaFile = trans('dashboard.laporan.stok_barang') . ' - ' . date('d F Y') . '.pdf';

        return $pdf->stream($namaFile);
    }

    protected function getLaporan()
    {
        $stok_beli = PembelianDetail::select('id', 'qty', 'netto', 'harga', 'gross', 'barang_id', 'pembelian_id')->with(
            'barang:id,nama,kode',
            'pembelian:id,gudang_id,kode,total_netto',
            'pembelian.gudang:id,nama',
        )
            ->when(request()->query('barang'), function ($q) {
                $q->where('barang_id',  request()->query('barang'));
            })
            ->whereHas('pembelian', function ($q) {
                $q->when(request()->query('gudang'), function ($q) {
                    $q->where('gudang_id',  request()->query('gudang'));
                });

                $q->when(request()->query('per_tanggal'), function ($q) {
                    $q->where('tanggal', '<=', request()->query('per_tanggal'));
                });

                $q->when(request()->query('bentuk_kepemilikan_stok'), function ($q) {
                    $q->where('bentuk_kepemilikan_stok', request()->query('bentuk_kepemilikan_stok'));
                });
            })
            ->orderByDesc('pembelian_id')
            ->limit(100)
            ->get();

        $stok_retur_beli = ReturPembelianDetail::select('id', 'qty_retur', 'harga', 'gross', 'barang_id', 'retur_pembelian_id', 'netto')->with(
            'barang:id,nama,kode',
            'retur_pembelian:id,gudang_id,total_netto,kode',
            'retur_pembelian.gudang:id,nama',
        )
            ->when(request()->query('barang'), function ($q) {
                $q->where('barang_id',  request()->query('barang'));
            })
            ->whereHas('retur_pembelian', function ($q) {
                $q->when(request()->query('gudang'), function ($q) {
                    $q->where('gudang_id',  request()->query('gudang'));
                });

                $q->when(request()->query('per_tanggal'), function ($q) {
                    $q->where('tanggal', '<=', request()->query('per_tanggal'));
                });

                $q->when(request()->query('bentuk_kepemilikan_stok'), function ($q) {
                    $q->where('bentuk_kepemilikan_stok', request()->query('bentuk_kepemilikan_stok'));
                });
            })
            ->where('qty_retur', '!=', 0)
            ->orderByDesc('retur_pembelian_id')
            ->limit(100)
            ->get();

        $stok_jual = PenjualanDetail::select('id', 'qty', 'netto', 'harga', 'gross', 'barang_id', 'penjualan_id')->with(
            'barang:id,nama,kode',
            'penjualan:id,gudang_id,total_netto,kode',
            'penjualan.gudang:id,nama',
        )
            ->when(request()->query('barang'), function ($q) {
                $q->where('barang_id',  request()->query('barang'));
            })
            ->whereHas('penjualan', function ($q) {
                $q->when(request()->query('gudang'), function ($q) {
                    $q->where('gudang_id',  request()->query('gudang'));
                });

                $q->when(request()->query('per_tanggal'), function ($q) {
                    $q->where('tanggal', '<=', request()->query('per_tanggal'));
                });

                $q->when(request()->query('bentuk_kepemilikan_stok'), function ($q) {
                    $q->where('bentuk_kepemilikan_stok', request()->query('bentuk_kepemilikan_stok'));
                });
            })
            ->orderByDesc('penjualan_id')
            ->limit(100)
            ->get();

        $stok_retur_jual = ReturPenjualanDetail::select('id', 'qty_retur', 'harga', 'gross', 'barang_id', 'retur_penjualan_id', 'netto')->with(
            'barang:id,nama,kode',
            'retur_penjualan:id,gudang_id,total_netto,kode',
            'retur_penjualan.gudang:id,nama',
        )
            ->when(request()->query('barang'), function ($q) {
                $q->where('barang_id',  request()->query('barang'));
            })
            ->whereHas('retur_penjualan', function ($q) {
                $q->when(request()->query('gudang'), function ($q) {
                    $q->where('gudang_id',  request()->query('gudang'));
                });

                $q->when(request()->query('per_tanggal'), function ($q) {
                    $q->where('tanggal', '<=', request()->query('per_tanggal'));
                });

                $q->when(request()->query('bentuk_kepemilikan_stok'), function ($q) {
                    $q->where('bentuk_kepemilikan_stok', request()->query('bentuk_kepemilikan_stok'));
                });
            })
            ->where('qty_retur', '!=', 0)
            ->orderByDesc('retur_penjualan_id')
            ->limit(100)
            ->get();

        $stok_adjustment_plus = AdjustmentPlusDetail::select('id', 'qty', 'harga', 'subtotal', 'barang_id', 'adjustment_plus_id')->with(
            'barang:id,nama,kode',
            'adjustment_plus:id,gudang_id,grand_total,kode',
            'adjustment_plus.gudang:id,nama',
        )
            ->when(request()->query('barang'), function ($q) {
                $q->where('barang_id',  request()->query('barang'));
            })
            ->whereHas('adjustment_plus', function ($q) {
                $q->when(request()->query('gudang'), function ($q) {
                    $q->where('gudang_id',  request()->query('gudang'));
                });

                $q->when(request()->query('per_tanggal'), function ($q) {
                    $q->where('tanggal', '<=', request()->query('per_tanggal'));
                });

                $q->when(request()->query('bentuk_kepemilikan_stok'), function ($q) {
                    $q->where('bentuk_kepemilikan_stok', request()->query('bentuk_kepemilikan_stok'));
                });
            })
            ->orderByDesc('adjustment_plus_id')
            ->limit(100)
            ->get();

        $stok_adjustment_minus = AdjustmentMinusDetail::select('id', 'qty', 'barang_id', 'adjustment_minus_id')->with(
            'barang:id,nama,kode,harga_beli',
            'adjustment_minus:id,gudang_id,kode',
            'adjustment_minus.gudang:id,nama',
        )
            ->when(request()->query('barang'), function ($q) {
                $q->where('barang_id',  request()->query('barang'));
            })
            ->whereHas('adjustment_minus', function ($q) {
                $q->when(request()->query('gudang'), function ($q) {
                    $q->where('gudang_id',  request()->query('gudang'));
                });

                $q->when(request()->query('per_tanggal'), function ($q) {
                    $q->where('tanggal', '<=', request()->query('per_tanggal'));
                });

                $q->when(request()->query('bentuk_kepemilikan_stok'), function ($q) {
                    $q->where('bentuk_kepemilikan_stok', request()->query('bentuk_kepemilikan_stok'));
                });
            })
            ->orderByDesc('adjustment_minus_id')
            ->limit(100)
            ->get();

        return [
            'stok_beli' => $stok_beli,
            'stok_retur_beli' => $stok_retur_beli,
            'stok_jual' =>  $stok_jual,
            'stok_retur_jual' => $stok_retur_jual,
            'stok_adjustment_plus' => $stok_adjustment_plus,
            'stok_adjustment_minus' => $stok_adjustment_minus
        ];
    }
}
