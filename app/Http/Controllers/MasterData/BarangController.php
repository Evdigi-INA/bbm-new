<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StoreBarangRequest, UpdateBarangRequest};
use App\Models\Barang;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create barang')->only('create');
        $this->middleware('permission:read barang')->only('index');
        $this->middleware('permission:edit barang')->only('edit');
        $this->middleware('permission:update barang')->only('update');
        $this->middleware('permission:delete barang')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Barang::with('kategori', 'satuan', 'matauang_beli', 'mata_uang_jual')->orderByDesc('id');

        if (request()->ajax()) {
            return Datatables::of($barang)
                ->addIndexColumn()
                ->addColumn('action', 'master-data.barang.data-table.action')
                ->addColumn('gambar', function ($row) {
                    return asset('storage/img/barang/' . $row->gambar);
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d F Y H:i');
                })
                ->addColumn('default', function ($row) {
                    return $row->default == 'Y' ? 'Ya' : 'Tidak';
                })
                ->addColumn('jenis', function ($row) {
                    return $row->jenis == 1 ? 'Barang' : 'Paket';
                })
                ->addColumn('kategori', function ($row) {
                    return $row->kategori->nama;
                })
                ->addColumn('satuan', function ($row) {
                    return $row->satuan->nama;
                })
                ->addColumn('harga_beli', function ($row) {
                    return $row->matauang_beli->kode . ' ' . number_format($row->harga_beli);
                })
                ->addColumn('harga_jual', function ($row) {
                    return $row->mata_uang_jual->kode . ' ' . number_format($row->harga_jual);
                })
                ->addColumn('status', function ($row) {
                    return $row->status == 'Y' ? 'Aktif' : 'Non aktif';
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d F Y H:i');
                })
                ->make(true);
        }

        return view('master-data.barang.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master-data.barang.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBarangRequest $request)
    {
        $data = $request->validated();
        $data['gambar'] = 'noimage.png';
        $data['kategori_id'] = $request->kategori;
        $data['satuan_id'] = $request->satuan;

        if ($request->has('gambar') && $request->file('gambar')->isValid()) {
            $filename = time() . '.' . $request->gambar->extension();

            $request->gambar->storeAs('public/img/barang/', $filename);

            $data['gambar'] = $filename;
        }

        Barang::create($data);

        Alert::success('Tambah Data', 'Berhasil');

        return redirect()->route('barang.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function edit(Barang $barang)
    {
        $barang->load('kategori', 'satuan', 'matauang_beli', 'mata_uang_jual');

        return view('master-data.barang.edit', compact('barang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBarangRequest $request, Barang $barang)
    {
        $data = $request->validated();
        $data['kategori_id'] = $request->kategori;
        $data['satuan_id'] = $request->satuan;

        if ($request->has('gambar') && $request->file('gambar')->isValid()) {
            $filename = time()  . '.' . $request->gambar->extension();

            $request->gambar->storeAs('public/img/barang/', $filename);

            // hapus gambar lama jika bukan gambar default
            if ($barang->gambar != 'noimage.png') {
                Storage::delete('public/img/barang/' . $barang->gambar);
            }

            $data['gambar'] = $filename;
        }

        $barang->update($data);

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('barang.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang)
    {
        // hapus gambar lama jika bukan gambar default
        if ($barang->gambar != 'noimage.png') {
            Storage::delete('public/img/barang/' . $barang->gambar);
        }

        $barang->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('barang.index');
    }

    public function cekStok($id)
    {
        abort_if(!request()->ajax(), 403, 'Hayo mau ngapain!!');

        $barang = Barang::select('stok', 'min_stok', 'harga_jual', 'harga_beli')->findOrFail($id);

        return response()->json([
            'stok' => $barang->stok,
            'min_stok' => $barang->min_stok,
            'harga_jual' => $barang->harga_jual,
            'harga_beli' => $barang->harga_beli,
        ], 200);
    }
}
