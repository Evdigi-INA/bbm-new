<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\{PesananPenjualan, Barang, PesananPenjualanDetail};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PesananPenjualanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create pesanan penjualan')->only('create');
        $this->middleware('permission:read pesanan penjualan')->only('index');
        $this->middleware('permission:edit pesanan penjualan')->only('edit');
        $this->middleware('permission:detail pesanan penjualan')->only('show');
        $this->middleware('permission:update pesanan penjualan')->only('update');
        $this->middleware('permission:delete pesanan penjualan')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $penjualan = PesananPenjualan::with(
                'pelanggan:id,kode,nama_pelanggan',
                'matauang:id,kode,nama'
            )->withCount('pesanan_penjualan_detail')
                ->orderByDesc('id');

            return datatables()::of($penjualan)
                ->addIndexColumn()
                ->addColumn('action', 'penjualan.pesanan.data-table.action')
                ->addColumn('tanggal', function ($row) {
                    return $row->tanggal->format('d F Y');
                })
                ->addColumn('matauang', function ($row) {
                    return $row->matauang->nama;
                })
                ->addColumn('pelanggan', function ($row) {
                    return $row->pelanggan->nama_pelanggan;
                })
                ->addColumn('total_barang', function ($row) {
                    return $row->pesanan_penjualan_detail_count;
                })
                ->addColumn('grand_total', function ($row) {
                    return $row->matauang->kode . ' ' . number_format($row->total_penjualan);
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d F Y H:i');
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d F Y H:i');
                })
                ->toJson();
        }

        return view('penjualan.pesanan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('penjualan.pesanan.create');
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
            $penjualan = PesananPenjualan::create([
                'kode' => $request->kode,
                'tanggal' => $request->tanggal,
                'matauang_id' => $request->matauang,
                'pelanggan_id' => $request->pelanggan,
                // 'gudang_id' => $request->gudang,
                // 'salesman_id' => $request->salesman,
                'keterangan' => $request->keterangan,
                'bentuk_kepemilikan_stok' => $request->bentuk_kepemilikan,
                'rate' => $request->rate,
                'alamat' => $request->alamat,
                'subtotal' => $request->subtotal,
                'total_ppn' => $request->total_ppn,
                'total_gross' => $request->total_gross,
                'total_diskon' => $request->total_diskon,
                'total_penjualan' => $request->total_penjualan,
                'total_biaya_kirim' => $request->total_biaya_kirim ? $request->total_biaya_kirim : 0,
                'total_netto' => $request->total_netto,
            ]);

            foreach ($request->barang as $i => $value) {
                $penjualanDetail[] = new PesananPenjualanDetail([
                    'barang_id' => $value,
                    'harga' => $request->harga[$i],
                    'qty' => $request->qty[$i],
                    'diskon_persen' => $request->diskon_persen[$i],
                    'diskon' => $request->diskon[$i],
                    'gross' => $request->gross[$i],
                    'ppn' => $request->ppn[$i],
                    'netto' => $request->netto[$i],
                ]);

                // // Update stok barang
                // $barangQuery = Barang::whereId($value);
                // $getBarang = $barangQuery->first();
                // $barangQuery->update(['stok' => ($getBarang->stok - $request->qty[$i])]);
            }

            $penjualan->pesanan_penjualan_detail()->saveMany($penjualanDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PesananPenjualan  $pesananPenjualan
     * @return \Illuminate\Http\Response
     */
    public function show(PesananPenjualan $pesananPenjualan)
    {
        $pesananPenjualan->load(
            'pesanan_penjualan_detail',
            'pesanan_penjualan_detail.barang:id,kode,nama,harga_jual,harga_beli',
            'pelanggan:id,kode,nama_pelanggan',
            'matauang:id,kode,nama',
        );

        return view('penjualan.pesanan.show', compact('pesananPenjualan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PesananPenjualan  $pesananPenjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(PesananPenjualan $pesananPenjualan)
    {
        $pesananPenjualan->load(
            'pesanan_penjualan_detail',
            'pesanan_penjualan_detail.barang:id,kode,nama,harga_jual,harga_beli',
            'pelanggan:id,kode,nama_pelanggan',
            'matauang:id,kode,nama',
        );

        return view('penjualan.pesanan.edit', compact('pesananPenjualan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PesananPenjualan  $pesananPenjualan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $penjualan = PesananPenjualan::findOrFail($id);

        DB::transaction(function () use ($request, $penjualan) {
            $penjualan->update([
                'kode' => $request->kode,
                'pelanggan_id' => $request->pelanggan,
                'keterangan' => $request->keterangan,
                'bentuk_kepemilikan_stok' => $request->bentuk_kepemilikan,
                'alamat' => $request->alamat,
                'subtotal' => $request->subtotal,
                'total_ppn' => $request->total_ppn,
                'total_gross' => $request->total_gross,
                'total_diskon' => $request->total_diskon,
                'total_penjualan' => $request->total_penjualan,
                'total_biaya_kirim' => $request->total_biaya_kirim,
                'total_netto' => $request->total_netto,
                // 'gudang_id' => $request->gudang,
                // 'salesman_id' => $request->salesman,
            ]);

            // Hapus list lama
            $penjualan->pesanan_penjualan_detail()->delete();

            foreach ($request->barang as $i => $value) {
                $penjualanDetail[] = new PesananPenjualanDetail([
                    'barang_id' => $value,
                    'harga' => $request->harga[$i],
                    'qty' => $request->qty[$i],
                    'diskon_persen' => $request->diskon_persen[$i],
                    'diskon' => $request->diskon[$i],
                    'gross' => $request->gross[$i],
                    'ppn' => $request->ppn[$i],
                    'netto' => $request->netto[$i],
                ]);

                // // Update stok barang
                // $barangQuery = Barang::whereId($value);
                // $getBarang = $barangQuery->first();
                // $barangQuery->update(['stok' => ($getBarang->stok - $request->qty[$i])]);
            }

            $penjualan->pesanan_penjualan_detail()->saveMany($penjualanDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PesananPenjualan  $pesananPenjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(PesananPenjualan $pesananPenjualan)
    {
        $pesananPenjualan->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return back();
    }

    public function generateKode($tanggal)
    {
        abort_if(!request()->ajax(), 404);

        $checkLatestKode = PesananPenjualan::whereMonth('tanggal', date('m', strtotime($tanggal)))->whereYear('tanggal', date('Y', strtotime($tanggal)))->latest()->first();

        if ($checkLatestKode == null) {
            $kode = 'SLSOR-' . date('Ym', strtotime($tanggal)) . '00001';
        } else {
            // hapus "SLSOR-" dan ambil angka buat ditambahin
            $onlyNumberKode = \Str::after($checkLatestKode->kode, 'SLSOR-');

            $kode =  'SLSOR-' . (intval($onlyNumberKode) + 1);
        }

        return response()->json($kode, 200);
    }
}
