<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StoreRekeningBankRequest, UpdateRekeningBankRequest};
use App\Models\RekeningBank;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class RekeningBankController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create rekening')->only('create');
        $this->middleware('permission:read rekening')->only('index');
        $this->middleware('permission:edit rekening')->only('edit');
        $this->middleware('permission:update rekening')->only('update');
        $this->middleware('permission:delete rekening')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rekeningBank = RekeningBank::with('bank')->orderByDesc('id');

        if (request()->ajax()) {
            return Datatables::of($rekeningBank)
                ->addIndexColumn()
                ->addColumn('action', 'master-data.rekening-bank.data-table.action')
                ->addColumn('status', function ($row) {
                    return $row->status == 'Y' ? 'Aktif' : 'Non aktif';
                })
                ->addColumn('bank', function ($row) {
                    return $row->bank->nama;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d F Y H:i');
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d F Y H:i');
                })
                ->toJson();
        }

        return view('master-data.rekening-bank.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master-data.rekening-bank.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRekeningBankRequest $request)
    {
        $data = $request->validated();
        $data['bank_id'] = $request->bank;

        RekeningBank::create($data);

        Alert::success('Tambah Data', 'Berhasil');

        return redirect()->route('rekening-bank.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RekeningBank  $rekeningBank
     * @return \Illuminate\Http\Response
     */
    public function edit(RekeningBank $rekeningBank)
    {
        $rekeningBank->load('bank');

        return view('master-data.rekening-bank.edit', compact('rekeningBank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RekeningBank  $rekeningBank
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRekeningBankRequest $request, RekeningBank $rekeningBank)
    {
        $data = $request->validated();
        $data['bank_id'] = $request->bank;

        $rekeningBank->update($data);

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('rekening-bank.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RekeningBank  $rekeningBank
     * @return \Illuminate\Http\Response
     */
    public function destroy(RekeningBank $rekeningBank)
    {
        $rekeningBank->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('rekening-bank.index');
    }
}
