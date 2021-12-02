<?php

namespace App\Http\Controllers\Pembelian;

use App\Http\Controllers\Controller;
use App\Models\{Barang, PesananPembelian, PesananPembelianDetail};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PesananPembelianController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create pesanan pembelian')->only('create');
        $this->middleware('permission:read pesanan pembelian')->only('index');
        $this->middleware('permission:edit pesanan pembelian')->only('edit');
        $this->middleware('permission:detail pesanan pembelian')->only('show');
        $this->middleware('permission:update pesanan pembelian')->only('update');
        $this->middleware('permission:delete pesanan pembelian')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $pesanan = PesananPembelian::with(
                'supplier:id,nama_supplier',
                'matauang:id,kode,nama'
            )->withCount('pesanan_pembelian_detail')->orderByDesc('id');

            return Datatables::of($pesanan)
                ->addIndexColumn()
                ->addColumn('action', 'pembelian.pesanan-pembelian.data-table.action')
                ->addColumn('tanggal', function ($row) {
                    return $row->tanggal->format('d F Y');
                })
                ->addColumn('total_barang', function ($row) {
                    return $row->pesanan_pembelian_detail_count;
                })
                ->addColumn('matauang', function ($row) {
                    return $row->matauang->nama;
                })
                ->addColumn('grand_total', function ($row) {
                    return $row->matauang->kode . ' ' . number_format($row->total_netto);
                })
                ->addColumn('supplier', function ($row) {
                    return $row->supplier ? $row->supplier->nama_supplier : 'Tanpa Supplier';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d F Y H:i');
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d F Y H:i');
                })
                ->toJson();
        }

        return view('pembelian.pesanan-pembelian.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pembelian.pesanan-pembelian.create');
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
            $pesanan = PesananPembelian::create([
                'kode' => $request->kode,
                'tanggal' => $request->tanggal,
                'matauang_id' => $request->matauang,
                'supplier_id' => $request->supplier,
                'keterangan' => $request->keterangan,
                'bentuk_kepemilikan_stok' => $request->bentuk_kepemilikan,
                'rate' => $request->rate,
                'subtotal' => floatval($request->subtotal),
                'total_ppn' => floatval($request->total_ppn),
                'total_pph' => floatval($request->total_pph),
                'total_gross' => floatval($request->total_gross),
                'total_diskon' => floatval($request->total_diskon),
                'total_clr_fee' => floatval($request->total_clr_fee),
                'total_biaya_masuk' => floatval($request->total_biaya_masuk),
                'total_netto' => floatval($request->total_netto),
            ]);

            foreach ($request->barang as $i => $value) {
                $pesananDetail[] = new PesananPembelianDetail([
                    'barang_id' => $value,
                    'harga' => $request->harga[$i],
                    'qty' => $request->qty[$i],
                    'diskon_persen' => floatval($request->diskon_persen[$i]),
                    'diskon' => floatval($request->diskon[$i]),
                    'gross' => floatval($request->gross[$i]),
                    'biaya_masuk' => floatval($request->biaya_masuk[$i]),
                    'clr_fee' => floatval($request->clr_fee[$i]),
                    'ppn' => floatval($request->ppn[$i]),
                    'pph' => floatval($request->pph[$i]),
                    'netto' => floatval($request->netto[$i]),
                ]);
            }

            $pesanan->pesanan_pembelian_detail()->saveMany($pesananDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PesananPembelian  $pesananPembelian
     * @return \Illuminate\Http\Response
     */
    public function show(PesananPembelian $pesananPembelian)
    {
        $pesananPembelian->load(
            'pesanan_pembelian_detail',
            'pesanan_pembelian_detail.barang:id,kode,nama,harga_jual,harga_beli',
            'supplier:id,kode,nama_supplier',
            'matauang:id,kode,nama',
        )->withCount('pesanan_pembelian_detail');

        return view('pembelian.pesanan-pembelian.show', compact('pesananPembelian'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PesananPembelian  $pesananPembelian
     * @return \Illuminate\Http\Response
     */
    public function edit(PesananPembelian $pesananPembelian)
    {
        $pesananPembelian->load(
            'pesanan_pembelian_detail',
            'pesanan_pembelian_detail.barang:id,kode,nama,harga_jual,harga_beli',
            'supplier:id,kode,nama_supplier',
            'matauang:id,kode,nama',
        )->withCount('pesanan_pembelian_detail');

        return view('pembelian.pesanan-pembelian.edit', compact('pesananPembelian'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PesananPembelian  $pesananPembelian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pesananPembelian = PesananPembelian::findOrFail($id);

        DB::transaction(function () use ($request, $pesananPembelian) {
            $pesananPembelian->update([
                'keterangan' => $request->keterangan,
                'bentuk_kepemilikan_stok' => $request->bentuk_kepemilikan,
                'subtotal' => floatval($request->subtotal),
                'total_ppn' => floatval($request->total_ppn),
                'total_pph' => floatval($request->total_pph),
                'total_gross' => floatval($request->total_gross),
                'total_diskon' => floatval($request->total_diskon),
                'total_clr_fee' => floatval($request->total_clr_fee),
                'total_biaya_masuk' => floatval($request->total_biaya_masuk),
                'total_netto' => floatval($request->total_netto),
            ]);

            foreach ($request->barang as $i => $value) {
                $pesananPembelianDetail[] = new PesananPembelianDetail([
                    'barang_id' => $value,
                    'harga' => $request->harga[$i],
                    'qty' => $request->qty[$i],
                    'diskon_persen' => floatval($request->diskon_persen[$i]),
                    'diskon' => floatval($request->diskon[$i]),
                    'gross' => floatval($request->gross[$i]),
                    'biaya_masuk' => floatval($request->biaya_masuk[$i]),
                    'clr_fee' => floatval($request->clr_fee[$i]),
                    'ppn' => floatval($request->ppn[$i]),
                    'pph' => floatval($request->pph[$i]),
                    'netto' => floatval($request->netto[$i]),
                ]);
            }

            $pesananPembelian->pesanan_pembelian_detail()->delete();

            $pesananPembelian->pesanan_pembelian_detail()->saveMany($pesananPembelianDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PesananPembelian  $pesananPembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy(PesananPembelian $pesananPembelian)
    {
        $pesananPembelian->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return back();
    }

    public function generateKode($tanggal)
    {
        abort_if(!request()->ajax(), 404);

        $checkLatestKode = PesananPembelian::whereMonth('tanggal', date('m', strtotime($tanggal)))->whereYear('tanggal', date('Y', strtotime($tanggal)))->latest()->first();

        if ($checkLatestKode == null) {
            $kode = 'PUROR-' . date('Ym', strtotime($tanggal)) . '00001';
        } else {
            // hapus "PUROR-" dan ambil angka buat ditambahin
            $onlyNumberKode = \Str::after($checkLatestKode->kode, 'PUROR-');

            $kode =  'PUROR-' . (intval($onlyNumberKode) + 1);
        }

        return response()->json($kode, 200);
    }
}
