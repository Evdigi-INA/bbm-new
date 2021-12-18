<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\ReturPenjualan;
use App\Models\ReturPenjualanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class ReturPenjualanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create retur penjualan')->only('create');
        $this->middleware('permission:read retur penjualan')->only('index');
        $this->middleware('permission:edit retur penjualan')->only('edit');
        $this->middleware('permission:detail retur penjualan')->only('show');
        $this->middleware('permission:update retur penjualan')->only('update');
        $this->middleware('permission:delete retur penjualan')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $retur = ReturPenjualan::with(
                'gudang:id,kode,nama',
                'penjualan'
            )->withCount('retur_penjualan_detail');

            return Datatables::of($retur)
                ->addIndexColumn()
                ->addColumn('action', 'penjualan.retur.data-table.action')
                ->addColumn('tanggal', function ($row) {
                    return $row->tanggal->format('d F Y');
                })
                ->addColumn('kode_jual', function ($row) {
                    return $row->penjualan->kode;
                })
                ->addColumn('gudang', function ($row) {
                    return $row->gudang->nama;
                })
                ->addColumn('total_barang', function ($row) {
                    return $row->retur_penjualan_detail_count;
                })
                ->addColumn('grand_total', function ($row) {
                    return $row->penjualan->matauang->kode . ' ' . number_format($row->total_netto);
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d F Y H:i');
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d F Y H:i');
                })
                ->toJson();
        }

        return view('penjualan.retur.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('penjualan.retur.create');
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
            $retur = ReturPenjualan::create([
                'kode' => $request->kode,
                'tanggal' => $request->tanggal,
                'penjualan_id' => $request->penjualan_id,
                'gudang_id' => $request->gudang,
                'keterangan' => $request->keterangan,
                'rate' => $request->rate,
                'subtotal' => floatval($request->subtotal),
                'total_ppn' => floatval($request->total_ppn),
                'total_gross' => floatval($request->total_gross),
                'total_diskon' => floatval($request->total_diskon),
                'total_netto' => floatval($request->total_netto),
            ]);

            foreach ($request->barang as $i => $value) {
                $returDetail[] = new ReturPenjualanDetail([
                    'barang_id' => $value,
                    'harga' => $request->harga[$i],
                    'qty_beli' => $request->qty_beli[$i],
                    'qty_retur' => $request->qty_retur[$i],
                    'diskon_persen' => floatval($request->diskon_persen[$i]),
                    'diskon' => floatval($request->diskon[$i]),
                    'gross' => floatval($request->gross[$i]),
                    'ppn' => floatval($request->ppn[$i]),
                    'netto' => floatval($request->netto[$i]),
                ]);

                // Update stok barang
                $barangQuery = Barang::whereId($value);
                $getBarang = $barangQuery->first();
                $barangQuery->update(['stok' => ($getBarang->stok + $request->qty_retur[$i])]);
            }

            $retur->penjualan()->update(['retur' => 'YA']);

            $retur->retur_penjualan_detail()->saveMany($returDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReturPenjualan  $returPenjualan
     * @return \Illuminate\Http\Response
     */
    public function show(ReturPenjualan $returPenjualan)
    {
        $returPenjualan->load(
            'retur_penjualan_detail',
            'retur_penjualan_detail.barang:id,kode,nama,harga_jual,harga_beli',
            'penjualan.gudang:id,kode,nama',
            'penjualan.salesman:id,kode,nama',
            'penjualan.pelanggan:id,kode,nama_pelanggan',
            'penjualan.matauang:id,kode,nama'
        )->withCount('retur_penjualan_detail');

        return view('penjualan.retur.show', compact('returPenjualan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReturPenjualan  $returPenjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(ReturPenjualan $returPenjualan)
    {
        $returPenjualan->load(
            'retur_penjualan_detail',
            'retur_penjualan_detail.barang:id,kode,nama,harga_jual,harga_beli',
            'penjualan.gudang:id,kode,nama',
            'penjualan.salesman:id,kode,nama',
            'penjualan.pelanggan:id,kode,nama_pelanggan',
            'penjualan.matauang:id,kode,nama'
        )->withCount('retur_penjualan_detail');

        return view('penjualan.retur.edit', compact('returPenjualan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReturPenjualan  $returPenjualan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReturPenjualan $returPenjualan)
    {
        $returPenjualan->load('retur_penjualan_detail');

        DB::transaction(function () use ($request, $returPenjualan) {
            foreach ($returPenjualan->retur_penjualan_detail as $pd) {
                // Update stok barang
                $barangQuery = Barang::whereId($pd->barang_id);
                $getBarang = $barangQuery->first();
                $barangQuery->update(['stok' => ($getBarang->stok - $pd->qty_retur)]);
            }

            // hapus retur lama
            $returPenjualan->penjualan()->update(['retur' => 'NO']);
            $returPenjualan->retur_penjualan_detail()->delete();

            $returPenjualan->update([
                'gudang_id' => $request->gudang,
                'keterangan' => $request->keterangan,
                'rate' => $request->rate,
                'subtotal' => floatval($request->subtotal),
                'total_ppn' => floatval($request->total_ppn),
                'total_gross' => floatval($request->total_gross),
                'total_diskon' => floatval($request->total_diskon),
                'total_netto' => floatval($request->total_netto),
            ]);

            foreach ($request->barang as $i => $value) {
                $returDetail[] = new ReturPenjualanDetail([
                    'barang_id' => $value,
                    'harga' => $request->harga[$i],
                    'qty_beli' => $request->qty_beli[$i],
                    'qty_retur' => $request->qty_retur[$i],
                    'diskon_persen' => floatval($request->diskon_persen[$i]),
                    'diskon' => floatval($request->diskon[$i]),
                    'gross' => floatval($request->gross[$i]),
                    'ppn' => floatval($request->ppn[$i]),
                    'netto' => floatval($request->netto[$i]),
                ]);

                // Update stok barang
                $barangQuery = Barang::whereId($value);
                $getBarang = $barangQuery->first();
                $barangQuery->update(['stok' => ($getBarang->stok + $request->qty_retur[$i])]);
            }

            // insert retur baru
            $returPenjualan->retur_penjualan_detail()->saveMany($returDetail);
            $returPenjualan->penjualan()->update(['retur' => 'YA']);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReturPenjualan  $returPenjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReturPenjualan $returPenjualan)
    {
        $returPenjualan->load('retur_penjualan_detail');

        foreach ($returPenjualan->retur_penjualan_detail as $pd) {
            // Update stok barang
            $barangQuery = Barang::whereId($pd->barang_id);
            $getBarang = $barangQuery->first();
            $barangQuery->update(['stok' => ($getBarang->stok - $pd->qty_retur)]);
        }

        $returPenjualan->penjualan()->update(['retur' => 'NO']);
        $returPenjualan->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return back();
    }

    public function getPenjualanById($id)
    {
        // kalo ngakses dari browser
        abort_if(!request()->ajax(), 404);

        $penjualan = Penjualan::with(
            'pelanggan:id,kode,nama_pelanggan,alamat',
            'salesman:id,kode,nama',
            'matauang:id,kode,nama',
            'penjualan_detail',
            'penjualan_detail.barang:id,kode,nama',
        )->findOrFail($id);

        return response()->json($penjualan, 200);
    }

    public function generateKode($tanggal)
    {
        abort_if(!request()->ajax(), 404);

        $checkLatestKode = ReturPenjualan::whereMonth('tanggal', date('m', strtotime($tanggal)))->whereYear('tanggal', date('Y', strtotime($tanggal)))->latest()->first();

        if ($checkLatestKode == null) {
            $kode = 'SLSRT-' . date('Ym', strtotime($tanggal)) . '00001';
        } else {
            // hapus "SLSRT-" dan ambil angka buat ditambahin
            $onlyNumberKode = \Str::after($checkLatestKode->kode, 'SLSRT-');

            $kode =  'SLSRT-' . (intval($onlyNumberKode) + 1);
        }

        return response()->json($kode, 200);
    }
}
