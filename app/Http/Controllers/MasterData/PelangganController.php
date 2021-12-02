<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StorePelangganRequest, UpdatePelangganRequest};
use App\Models\{Area, Pelanggan};
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PelangganController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create pelanggan')->only('create');
        $this->middleware('permission:read pelanggan')->only('index');
        $this->middleware('permission:edit pelanggan')->only('edit');
        $this->middleware('permission:update pelanggan')->only('update');
        $this->middleware('permission:delete pelanggan')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return Datatables::of(Pelanggan::query())
                ->addIndexColumn()
                ->addColumn('action', 'master-data.pelanggan.data-table.action')
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

        return view('master-data.pelanggan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master-data.pelanggan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePelangganRequest $request)
    {
        $data = $request->validated();
        $data['area_id'] = $request->area;

        Pelanggan::create($data);

        Alert::success('Tambah Data', 'Berhasil');

        return redirect()->route('pelanggan.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pelanggan $pelanggan)
    {
        $pelanggan->load('area');

        return view('master-data.pelanggan.edit', compact('pelanggan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePelangganRequest $request, Pelanggan $pelanggan)
    {
        $data = $request->validated();
        $data['area_id'] = $request->area;

        $pelanggan->update($data);

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('pelanggan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('pelanggan.index');
    }
}
