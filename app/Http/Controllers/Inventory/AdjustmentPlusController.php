<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\{AdjustmentPlus, AdjustmentPlusDetail, Barang};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class AdjustmentPlusController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create adjustment plus')->only('create');
        $this->middleware('permission:read adjustment plus')->only('index');
        $this->middleware('permission:edit adjustment plus')->only('edit');
        $this->middleware('permission:update adjustment plus')->only('update');
        $this->middleware('permission:delete adjustment plus')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $adjustmentPlus = AdjustmentPlus::with(
                'adjustment_plus_detail',
                'adjustment_plus_detail.barang:id,kode,nama,harga_jual,harga_beli',
                'adjustment_plus_detail.supplier:id,kode,nama_supplier',
                'matauang:id,kode,nama',
                'gudang:id,kode,nama'
            )->withCount('adjustment_plus_detail')->orderByDesc('id');

            return Datatables::of($adjustmentPlus)
                ->addIndexColumn()
                ->addColumn('action', 'inventory.adjustment-plus.data-table.action')
                ->addColumn('gudang', function ($row) {
                    return $row->gudang->nama;
                })
                ->addColumn('total_barang', function ($row) {
                    return $row->adjustment_plus_detail_count;
                })
                ->addColumn('matauang', function ($row) {
                    return $row->matauang->nama;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d F Y H:i');
                })
                ->addColumn('grand_total', function ($row) {
                    return $row->matauang->kode . ' ' . number_format($row->grand_total, 2, '.', ',');
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d F Y H:i');
                })
                ->addColumn('tanggal', function ($row) {
                    return $row->tanggal->format('d F Y');
                })
                ->toJson();
        }

        return view('inventory.adjustment-plus.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.adjustment-plus.create');
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
            $adjusment = AdjustmentPlus::create([
                'kode' => $request->kode,
                'tanggal' => $request->tanggal,
                'matauang_id' => $request->matauang,
                'gudang_id' => $request->gudang,
                'rate' => $request->rate,
                'grand_total' => $request->grand_total,
            ]);

            foreach ($request->barang as $i => $value) {
                $adjusmentDetail[] = new AdjustmentPlusDetail([
                    'barang_id' => $value,
                    'supplier_id' => $request->supplier[$i],
                    'bentuk_kepemilikan_stok' => $request->bentuk_kepemilikan[$i],
                    'harga' => $request->harga[$i],
                    'qty' => $request->qty[$i],
                    'subtotal' => $request->subtotal[$i],
                ]);

                // Update stok barang
                $barangQuery = Barang::whereId($value);
                $getBarang = $barangQuery->first();
                $barangQuery->update(['stok' => ($getBarang->stok + $request->qty[$i])]);
            }

            $adjusment->adjustment_plus_detail()->saveMany($adjusmentDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdjustmentPlus  $adjustmentPlus
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $adjustmentPlus = AdjustmentPlus::with(
            'adjustment_plus_detail',
            'adjustment_plus_detail.barang:id,kode,nama,harga_jual,harga_beli',
            'adjustment_plus_detail.supplier:id,kode,nama_supplier',
            'matauang:id,kode,nama',
            'gudang:id,kode,nama'
        )
            ->withCount('adjustment_plus_detail')
            ->findOrFail($id);

        return view('inventory.adjustment-plus.show', compact('adjustmentPlus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdjustmentPlus  $adjustmentPlus
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $adjustmentPlus = AdjustmentPlus::with(
            'adjustment_plus_detail',
            'adjustment_plus_detail.barang:id,kode,nama,harga_jual,harga_beli',
            'adjustment_plus_detail.supplier:id,kode,nama_supplier',
            'matauang:id,kode,nama',
            'gudang:id,kode,nama'
        )
            ->withCount('adjustment_plus_detail')
            ->findOrFail($id);

        return view('inventory.adjustment-plus.edit', compact('adjustmentPlus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdjustmentPlus  $adjustmentPlus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $adjusment = AdjustmentPlus::findOrFail($id);

        DB::transaction(function () use ($request, $adjusment) {
            $adjusment->update([
                'gudang_id' => $request->gudang,
                'grand_total' => $request->grand_total,
            ]);

            foreach ($request->barang as $i => $value) {
                $adjusmentDetail[] = new AdjustmentPlusDetail([
                    'barang_id' => $value,
                    'supplier_id' => $request->supplier[$i],
                    'bentuk_kepemilikan_stok' => $request->bentuk_kepemilikan[$i],
                    'harga' => $request->harga[$i],
                    'qty' => $request->qty[$i],
                    'subtotal' => $request->subtotal[$i],
                ]);

                // Update stok barang
                $barangQuery = Barang::whereId($value);
                $getBarang = $barangQuery->first();
                $barangQuery->update(['stok' => ($getBarang->stok + $request->qty[$i])]);
            }


            // hapus list barang lama
            $adjusment->adjustment_plus_detail()->delete();

            $adjusment->adjustment_plus_detail()->saveMany($adjusmentDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdjustmentPlus  $adjustmentPlus
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adjusment = AdjustmentPlus::findOrFail($id);
        $adjusment->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('adjustment-plus.index');
    }

    public function generateKode($tanggal)
    {
        abort_if(!request()->ajax(), 404);

        $checkLatestKode = AdjustmentPlus::whereMonth('tanggal', date('m', strtotime($tanggal)))->whereYear('tanggal', date('Y', strtotime($tanggal)))->latest()->first();

        if ($checkLatestKode == null) {
            $kode = 'ADJPL-' . date('Ym', strtotime($tanggal)) . '00001';
        } else {
            // hapus "ADJPL-" dan ambil angka buat ditambahin
            $onlyNumberKode = \Str::after($checkLatestKode->kode, 'ADJPL-');

            $kode =  'ADJPL-' . (intval($onlyNumberKode) + 1);
        }

        return response()->json($kode, 200);
    }
}
