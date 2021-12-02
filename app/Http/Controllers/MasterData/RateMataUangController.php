<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\RateMataUangRequest;
use App\Models\RateMataUang;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class RateMataUangController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create rate mata uang')->only('create');
        $this->middleware('permission:read rate mata uang')->only('index');
        $this->middleware('permission:edit rate mata uang')->only('edit');
        $this->middleware('permission:update rate mata uang')->only('update');
        $this->middleware('permission:delete rate mata uang')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rateMataUang = RateMataUang::with('matauang_asing', 'mata_uang_default')->orderByDesc('id');

        if (request()->ajax()) {
            return Datatables::of($rateMataUang)
                ->addIndexColumn()
                ->addColumn('action', 'master-data.rate-matauang.data-table.action')
                ->addColumn('matauang_asing', function ($row) {
                    return $row->matauang_asing->nama;
                })
                ->addColumn('mata_uang_default', function ($row) {
                    return $row->mata_uang_default->nama;
                })
                ->addColumn('rate', function ($row) {
                    return number_format($row->rate);
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d F Y H:i');
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d F Y H:i');
                })
                ->toJson();
        }

        return view('master-data.rate-matauang.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master-data.rate-matauang.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RateMataUangRequest $request)
    {
        RateMataUang::create($request->validated());

        Alert::success('Tambah Data', 'Berhasil');

        return redirect()->route('rate-matauang.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RateMataUang  $rateMataUang
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rateMataUang = RateMataUang::with('matauang_asing', 'mata_uang_default')->findOrFail($id);

        return view('master-data.rate-matauang.edit', compact('rateMataUang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RateMataUang  $rateMataUang
     * @return \Illuminate\Http\Response
     */
    public function update(RateMataUangRequest $request, $id)
    {
        RateMataUang::findOrFail($id)->update($request->validated());

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('rate-matauang.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RateMataUang  $rateMataUang
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RateMataUang::findOrFail($id)->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('rate-matauang.index');
    }
}
