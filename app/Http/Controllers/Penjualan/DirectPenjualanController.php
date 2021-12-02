<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\PenjualanPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DirectPenjualanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create direct penjualan')->except('getBarangByMatauang');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('penjualan.direct.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $penjualan = Penjualan::create([
                'kode' => $this->generateKode(),
                'tanggal' => today(),
                'matauang_id' => $request->matauang,
                'gudang_id' => $request->gudang,
                'pelanggan_id' => $request->pelanggan,
                'salesman_id' => auth()->user()->salesman->id,
                'bentuk_kepemilikan_stok' => $request->bentuk_kepemilikan,
                'subtotal' => $request->subtotal,
                'total_ppn' => $request->total_ppn,
                'total_gross' => $request->total_gross,
                'total_diskon' => $request->total_diskon,
                'total_penjualan' => $request->total_netto,
                'total_biaya_kirim' => 0,
                'total_netto' => $request->total_netto,
                'rate' => 1
            ]);

            foreach ($request->barang as $i => $value) {
                $penjualanDetail[] = new PenjualanDetail([
                    'barang_id' => $value,
                    'harga' => $request->harga[$i],
                    'qty' => $request->qty[$i],
                    'diskon_persen' => $request->diskon_persen[$i],
                    'diskon' => $request->diskon[$i],
                    'gross' => $request->gross[$i],
                    'ppn' => $request->ppn[$i],
                    'netto' => $request->netto[$i],
                ]);

                // Update stok barang
                $barangQuery = Barang::whereId($value);
                $getBarang = $barangQuery->first();
                $barangQuery->update(['stok' => ($getBarang->stok - $request->qty[$i])]);
            }

            // kalo user isi jenis pembayaran dan bayar berarti di ga ngutag
            // if ($request->jenis_pembayaran && $request->bayar) {
            //     foreach ($request->bank as $i => $value) {
            //         $pembayaran[] = new PenjualanPembayaran([
            //             'jenis_pembayaran' => $request->jenis_pembayaran[$i],
            //             'bank_id' => $request->bank[$i],
            //             'rekening_bank_id' => $request->rekening[$i],
            //             'tgl_cek_giro' => $request->tgl_cek_giro[$i],
            //             'no_cek_giro' => $request->no_cek_giro[$i],
            //             'bayar' => $request->bayar[$i],
            //         ]);

            //         if ($request->jenis_pembayaran[$i] == 'Giro') {
            //             DB::table('cek_giro')->insert([
            //                 'penjualan_id' => $penjualan->id,
            //                 'jenis_cek' => 'In',
            //                 'status' => 'Belum Lunas',
            //                 'created_at' => now(),
            //                 'updated_at' => now()
            //             ]);
            //         }
            //     }

            //     $penjualan->penjualan_pembayaran()->saveMany($pembayaran);
            // }

            $penjualan->penjualan_detail()->saveMany($penjualanDetail);

            // $penjualan->pesanan_penjualan()->update(['status' => 'USED']);
        });

        return response()->json(['success'], 200);
    }

    public function generateKode()
    {
        $checkLatestKode = Penjualan::whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'))->latest()->first();

        if ($checkLatestKode == null) {
            $kode = 'SALES-' . date('Ym') . '00001';
        } else {
            // hapus "SALES-" dan ambil angka buat ditambahin
            $onlyNumberKode = \Str::after($checkLatestKode->kode, 'SALES-');

            $kode =  'SALES-' . (intval($onlyNumberKode) + 1);
        }

        return $kode;
    }

    public function getBarangByMatauang(Request $request)
    {
        abort_if(!$request->ajax(), 404);

        $barang = Barang::select('id', 'kode', 'nama', 'harga_jual_matauang', 'harga_beli_matauang', 'harga_jual', 'harga_beli', 'stok', 'gambar')
            ->with('mata_uang_jual:id,kode')
            ->with('matauang_beli:id,kode')
            ->where('status', 'Y')
            ->where('jenis', 1)
            ->where('harga_jual_matauang', $request->id)
            ->where('nama', 'like', '%' . $request->search . '%')
            // ->orWhere('kode', 'like', '%' . $request->search . '%')
            ->get();

        return $barang;
    }
}
