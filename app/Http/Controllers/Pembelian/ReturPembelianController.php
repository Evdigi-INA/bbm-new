<?php

namespace App\Http\Controllers\Pembelian;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\ReturPembelian;
use App\Models\ReturPembelianDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class ReturPembelianController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create retur pembelian')->only('create');
        $this->middleware('permission:read retur pembelian')->only('index');
        $this->middleware('permission:edit retur pembelian')->only('edit');
        $this->middleware('permission:detail retur pembelian')->only('show');
        $this->middleware('permission:update retur pembelian')->only('update');
        $this->middleware('permission:delete retur pembelian')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $retur = ReturPembelian::with(
                'gudang:id,kode,nama',
                'pembelian',
                'pembelian.supplier:id,kode,nama_supplier',
                'pembelian.matauang:id,kode,nama'
            )->withCount('retur_pembelian_detail')
                ->orderByDesc('id');

            return Datatables::of($retur)
                ->addIndexColumn()
                ->addColumn('action', 'pembelian.retur.data-table.action')
                ->addColumn('tanggal', function ($row) {
                    return $row->tanggal->format('d F Y');
                })
                ->addColumn('kode_beli', function ($row) {
                    return $row->pembelian->kode;
                })
                ->addColumn('supplier', function ($row) {
                    return $row->pembelian->supplier ? $row->pembelian->supplier->nama_supplier : 'Tanpa Supplier';
                })
                ->addColumn('gudang', function ($row) {
                    return $row->gudang->nama;
                })
                ->addColumn('total_barang', function ($row) {
                    return $row->retur_pembelian_detail_count;
                })
                ->addColumn('grand_total', function ($row) {
                    return $row->pembelian->matauang->kode . ' ' . number_format($row->total_netto);
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d F Y H:i');
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d F Y H:i');
                })
                ->toJson();
        }

        return view('pembelian.retur.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pembelian.retur.create');
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
            $retur = ReturPembelian::create([
                'kode' => $request->kode,
                'tanggal' => $request->tanggal,
                'pembelian_id' => $request->pembelian_id,
                'gudang_id' => $request->gudang,
                'keterangan' => $request->keterangan,
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
                $returDetail[] = new ReturPembelianDetail([
                    'barang_id' => $value,
                    'harga' => $request->harga[$i],
                    'qty_beli' => $request->qty_beli[$i],
                    'qty_retur' => $request->qty_retur[$i],
                    'diskon_persen' => floatval($request->diskon_persen[$i]),
                    'diskon' => floatval($request->diskon[$i]),
                    'gross' => floatval($request->gross[$i]),
                    'biaya_masuk' => floatval($request->biaya_masuk[$i]),
                    'clr_fee' => floatval($request->clr_fee[$i]),
                    'ppn' => floatval($request->ppn[$i]),
                    'pph' => floatval($request->pph[$i]),
                    'netto' => floatval($request->netto[$i]),
                ]);

                // Update stok barang
                $barangQuery = Barang::whereId($value);
                $getBarang = $barangQuery->first();
                $barangQuery->update(['stok' => ($getBarang->stok - $request->qty_retur[$i])]);
            }

            $retur->pembelian()->update(['retur' => 'YA']);
            $retur->retur_pembelian_detail()->saveMany($returDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReturPembelian  $returPembelian
     * @return \Illuminate\Http\Response
     */
    public function show(ReturPembelian $returPembelian)
    {
        $returPembelian->load(
            'retur_pembelian_detail',
            'retur_pembelian_detail.barang:id,kode,nama,harga_jual,harga_beli',
            'gudang:id,kode,nama',
            'pembelian',
            'pembelian.supplier:id,kode,nama_supplier',
            'pembelian.matauang:id,kode,nama'
        )->withCount('retur_pembelian_detail');

        return view('pembelian.retur.show', compact('returPembelian'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReturPembelian  $returPembelian
     * @return \Illuminate\Http\Response
     */
    public function edit(ReturPembelian $returPembelian)
    {
        $returPembelian->load(
            'retur_pembelian_detail',
            'retur_pembelian_detail.barang:id,kode,nama,harga_jual,harga_beli',
            'gudang:id,kode,nama',
            'pembelian',
            'pembelian.supplier:id,kode,nama_supplier',
            'pembelian.matauang:id,kode,nama'
        )->withCount('retur_pembelian_detail');

        return view('pembelian.retur.edit', compact('returPembelian'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReturPembelian  $returPembelian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $returPembelian = ReturPembelian::findOrFail($id);

        DB::transaction(function () use ($request, $returPembelian) {
            $returPembelian->update([
                'gudang_id' => $request->gudang,
                'keterangan' => $request->keterangan,
                'subtotal' => floatval($request->subtotal),
                'total_ppn' => floatval($request->total_ppn),
                'total_pph' => floatval($request->total_pph),
                'total_gross' => floatval($request->total_gross),
                'total_diskon' => floatval($request->total_diskon),
                'total_clr_fee' => floatval($request->total_clr_fee),
                'total_biaya_masuk' => floatval($request->total_biaya_masuk),
                'total_netto' => floatval($request->total_netto),
            ]);

            // hapus retur lama
            $returPembelian->retur_pembelian_detail()->delete();
            $returPembelian->pembelian()->update(['retur' => 'NO']);

            foreach ($request->barang as $i => $value) {
                $returDetail[] = new ReturPembelianDetail([
                    'barang_id' => $value,
                    'harga' => $request->harga[$i],
                    'qty_beli' => $request->qty_beli[$i],
                    'qty_retur' => $request->qty_retur[$i],
                    'diskon_persen' => floatval($request->diskon_persen[$i]),
                    'diskon' => floatval($request->diskon[$i]),
                    'gross' => floatval($request->gross[$i]),
                    'biaya_masuk' => floatval($request->biaya_masuk[$i]),
                    'clr_fee' => floatval($request->clr_fee[$i]),
                    'ppn' => floatval($request->ppn[$i]),
                    'pph' => floatval($request->pph[$i]),
                    'netto' => floatval($request->netto[$i]),
                ]);

                // Update stok barang
                $barangQuery = Barang::whereId($value);
                $getBarang = $barangQuery->first();
                $barangQuery->update(['stok' => ($getBarang->stok - $request->qty_retur[$i])]);
            }

            // insert retur baru
            $returPembelian->pembelian()->update(['retur' => 'YA']);
            $returPembelian->retur_pembelian_detail()->saveMany($returDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReturPembelian  $returPembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReturPembelian $returPembelian)
    {
        $returPembelian->pembelian()->update(['retur' => 'NO']);
        $returPembelian->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return back();
    }

    public function getPembelianById($id)
    {
        abort_if(!request()->ajax(), 404);

        $pembelian = Pembelian::with(
            'supplier:id,kode,nama_supplier',
            'matauang:id,kode,nama',
            'pembelian_detail',
            'pembelian_detail.barang:id,kode,nama'
        )->findOrFail($id);

        return response()->json($pembelian, 200);
    }

    public function generateKode($tanggal)
    {
        abort_if(!request()->ajax(), 404);

        $checkLatestKode = ReturPembelian::whereMonth('tanggal', date('m', strtotime($tanggal)))->whereYear('tanggal', date('Y', strtotime($tanggal)))->latest()->first();

        if ($checkLatestKode == null) {
            $kode = 'PURRT-' . date('Ym', strtotime($tanggal)) . '00001';
        } else {
            // hapus "PURRT-" dan ambil angka buat ditambahin
            $onlyNumberKode = \Str::after($checkLatestKode->kode, 'PURRT-');

            $kode =  'PURRT-' . (intval($onlyNumberKode) + 1);
        }

        return response()->json($kode, 200);
    }
}
