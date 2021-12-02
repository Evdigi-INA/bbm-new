<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StoreGudangRequest, UpdateGudangRequest};
use App\Models\Gudang;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class GudangController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create gudang')->only('create');
        $this->middleware('permission:read gudang')->only('index');
        $this->middleware('permission:edit gudang')->only('edit');
        $this->middleware('permission:update gudang')->only('update');
        $this->middleware('permission:delete gudang')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return Datatables::of(Gudang::query())
                ->addIndexColumn()
                ->addColumn('action', 'master-data.gudang.data-table.action')
                ->addColumn('status', function ($row) {
                    return $row->status == 'Y' ? 'Aktif' : 'Non aktif';
                })
                ->addColumn('gudang_penjualan', function ($row) {
                    return $row->gudang_penjualan == 1 ? 'Ya' : 'Bukan';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d F Y H:i');
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d F Y H:i');
                })
                ->toJson();
        }

        return view('master-data.gudang.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master-data.gudang.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGudangRequest $request)
    {
        Gudang::create($request->validated());

        Alert::success('Tambah Data', 'Berhasil');

        return redirect()->route('gudang.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function edit(Gudang $gudang)
    {
        return view('master-data.gudang.edit', compact('gudang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGudangRequest $request, Gudang $gudang)
    {
        $gudang->update($request->validated());

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('gudang.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gudang $gudang)
    {
        $gudang->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('gudang.index');
    }
}
