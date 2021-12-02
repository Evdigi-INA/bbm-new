<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StoreSupplierRequest, UpdateSupplierRequest};
use App\Models\Supplier;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create supplier')->only('create');
        $this->middleware('permission:read supplier')->only('index');
        $this->middleware('permission:edit supplier')->only('edit');
        $this->middleware('permission:update supplier')->only('update');
        $this->middleware('permission:delete supplier')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return Datatables::of(Supplier::query())
                ->addIndexColumn()
                ->addColumn('action', 'master-data.supplier.data-table.action')
                ->addColumn('status', function ($row) {
                    return $row->status == 'Y' ? 'Aktif' : 'Non aktif';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d F Y H:i');
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d F Y H:i');
                })
                ->toJson();
        }

        return view('master-data.supplier.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master-data.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSupplierRequest $request)
    {
        Supplier::create($request->validated());

        Alert::success('Tambah Data', 'Berhasil');

        return redirect()->route('supplier.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        return view('master-data.supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $supplier->update($request->validated());

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('supplier.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('supplier.index');
    }
}
