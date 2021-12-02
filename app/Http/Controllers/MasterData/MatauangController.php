<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StoreMataUangRequest, UpdateMataUangRequest};
use App\Models\Matauang;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class MatauangController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create mata uang')->only('create');
        $this->middleware('permission:read mata uang')->only('index');
        $this->middleware('permission:edit mata uang')->only('edit');
        $this->middleware('permission:update mata uang')->only('update');
        $this->middleware('permission:delete mata uang')->only('delete');
    }

    public function index()
    {
        if (request()->ajax()) {
            return Datatables::of(Matauang::query())
                ->addIndexColumn()
                ->addColumn('action', 'master-data.matauang.data-table.action')
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d F Y H:i');
                })
                ->addColumn('default', function ($row) {
                    return $row->default == 'Y' ? 'Ya' : 'Tidak';
                })
                ->addColumn('status', function ($row) {
                    return $row->status == 'Y' ? 'Aktif' : 'Non aktif';
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d F Y H:i');
                })
                ->toJson();
        }

        return view('master-data.matauang.index');
    }

    public function create()
    {
        return view('master-data.matauang.create');
    }

    public function store(StoreMataUangRequest $request)
    {
        Matauang::create($request->validated());

        Alert::success('Tambah Data', 'Berhasil');

        return redirect()->route('matauang.index');
    }

    public function edit($id)
    {
        $matauang = Matauang::findOrFail($id);

        return view('master-data.matauang.edit', compact('matauang'));
    }

    public function update(UpdateMataUangRequest $request, Matauang $matauang)
    {
        $matauang->update($request->validated());

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('matauang.index');
    }

    public function destroy($id)
    {
        Matauang::findOrFail($id)->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('matauang.index');
    }
}
