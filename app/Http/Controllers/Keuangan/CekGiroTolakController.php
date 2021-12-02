<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Http\Requests\CekGiroTolakRequest;
use App\Models\{CekGiro, CekGiroTolak};
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class CekGiroTolakController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create cek/giro tolak')->only('create');
        $this->middleware('permission:read cek/giro tolak')->only('index');
        $this->middleware('permission:edit cek/giro tolak')->only('edit');
        $this->middleware('permission:detail cek/giro tolak')->only('show');
        $this->middleware('permission:update cek/giro tolak')->only('update');
        $this->middleware('permission:delete cek/giro tolak')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $cekGiroTolak =  CekGiroTolak::with(
                'cek_giro',
                'cek_giro.pembelian:id,kode',
                'cek_giro.pembelian.pembelian_pembayaran',
                'cek_giro.penjualan:id,kode',
                'cek_giro.penjualan.penjualan_pembayaran'
            )->orderByDesc('id');

            return DataTables::of($cekGiroTolak)
                ->addIndexColumn()
                ->addColumn('action', 'keuangan.cek-giro.tolak.data-table.action')
                ->addColumn('nilai_cek_giro', function ($row) {
                    if ($row->cek_giro->penjualan) {
                        return number_format($row->cek_giro->penjualan->penjualan_pembayaran[0]->bayar);
                    } else {
                        return number_format($row->cek_giro->pembelian->pembelian_pembayaran[0]->bayar);
                    }
                })
                ->addColumn('no_cek_giro', function ($row) {
                    if ($row->cek_giro->penjualan) {
                        return $row->cek_giro->penjualan->penjualan_pembayaran[0]->no_cek_giro;
                    } else {
                        return $row->cek_giro->pembelian->pembelian_pembayaran[0]->no_cek_giro;
                    }
                })
                ->addColumn('jenis_cek', function ($row) {
                    return strtoupper($row->cek_giro->jenis_cek);
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d F Y H:i');
                })
                ->addColumn('tanggal', function ($row) {
                    return $row->tanggal->format('d F Y');
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d F Y H:i');
                })
                ->toJson();
        }

        return view('keuangan.cek-giro.tolak.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('keuangan.cek-giro.tolak.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CekGiroTolakRequest $request)
    {
        $cekGiro = CekGiro::with('pembelian', 'penjualan')->findOrFail($request->no_cek_giro);

        if ($cekGiro->pembelian) {
            $cekGiro->pembelian->update(['status' => 'Belum Lunas']);
        }

        if ($cekGiro->penjualan) {
            $cekGiro->penjualan->update(['status' => 'Belum Lunas']);
        }

        $cekGiro->update(['status' => 'Tolak']);

        $cekGiro->tolak_cek()->create($request->validated());

        Alert::success('Simpan Data', 'Berhasil');

        return redirect()->route('cek-giro-tolak.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CekGiroTolak  $cekGiroTolak
     * @return \Illuminate\Http\Response
     */
    public function show(CekGiroTolak $cekGiroTolak)
    {
        $cekGiroTolak->load(
            'cek_giro',
            'cek_giro.pembelian',
            'cek_giro.pembelian.matauang:id,kode,nama',
            'cek_giro.pembelian.supplier:id,kode,nama_supplier',
            'cek_giro.pembelian.pembelian_pembayaran',
            'cek_giro.penjualan',
            'cek_giro.penjualan.matauang:id,kode,nama',
            'cek_giro.penjualan.pelanggan:id,kode,nama_pelanggan',
            'cek_giro.penjualan.penjualan_pembayaran',
        );

        return view('keuangan.cek-giro.tolak.show', compact('cekGiroTolak'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CekGiroTolak  $cekGiroTolak
     * @return \Illuminate\Http\Response
     */
    public function edit(CekGiroTolak $cekGiroTolak)
    {
        $cekGiroTolak->load(
            'cek_giro',
            'cek_giro.pembelian',
            'cek_giro.pembelian.matauang:id,kode,nama',
            'cek_giro.pembelian.supplier:id,kode,nama_supplier',
            'cek_giro.pembelian.pembelian_pembayaran',
            'cek_giro.penjualan',
            'cek_giro.penjualan.matauang:id,kode,nama',
            'cek_giro.penjualan.pelanggan:id,kode,nama_pelanggan',
            'cek_giro.penjualan.penjualan_pembayaran',
        );

        return view('keuangan.cek-giro.tolak.edit', compact('cekGiroTolak'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CekGiroTolak  $cekGiroTolak
     * @return \Illuminate\Http\Response
     */
    public function update(CekGiroTolakRequest $request, CekGiroTolak $cekGiroTolak)
    {
        $attr = $request->validated();
        $attr['cek_giro_id'] = $request->no_cek_giro;

        // insert data baru
        $cekGiroBaru = CekGiro::with('pembelian', 'penjualan')->findOrFail($request->no_cek_giro);

        $cekGiroBaru->update(['status' => 'Tolak']);

        if ($cekGiroBaru->pembelian) {
            $cekGiroBaru->pembelian->update(['status' => 'Belum Lunas']);
        }

        if ($cekGiroBaru->penjualan) {
            $cekGiroBaru->penjualan->update(['status' => 'Belum Lunas']);
        }
        // end insert data baru

        $cekGiroTolak->cek_giro()->update(['status' => 'Belum Lunas']);

        // update pencairan cek
        $cekGiroTolak->update($attr);

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('cek-giro-tolak.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CekGiroTolak  $cekGiroTolak
     * @return \Illuminate\Http\Response
     */
    public function destroy(CekGiroTolak $cekGiroTolak)
    {
        $cekGiroTolak->cek_giro->update(['status' => 'Belum Lunas']);

        $cekGiroTolak->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return back();
    }

    public function generateKode($tanggal)
    {
        abort_if(!request()->ajax(), 404);

        $checkLatestKode = CekGiroTolak::whereMonth('tanggal', date('m', strtotime($tanggal)))->whereYear('tanggal', date('Y', strtotime($tanggal)))->latest()->first();

        if ($checkLatestKode == null) {
            $kode = 'CHRJC-' . date('Ym', strtotime($tanggal)) . '00001';
        } else {
            // hapus "CHRJC-" dan ambil angka buat ditambahin
            $onlyNumberKode = \Str::after($checkLatestKode->kode, 'CHRJC-');

            $kode =  'CHRJC-' . (intval($onlyNumberKode) + 1);
        }

        return response()->json($kode, 200);
    }

    public function getCekGiroById($id)
    {
        abort_if(!request()->ajax(), 404);

        $cekGiro = CekGiro::with(
            'pembelian:id,supplier_id,matauang_id,kode,rate',
            'penjualan:id,pelanggan_id,matauang_id,kode,rate',
            'pembelian.supplier:id,nama_supplier',
            'penjualan.pelanggan:id,nama_pelanggan',
            'penjualan.matauang:id,kode,nama',
            'pembelian.matauang:id,kode,nama',
            'penjualan.penjualan_pembayaran',
            'pembelian.pembelian_pembayaran'
        )->findOrFail($id);

        return response()->json($cekGiro, 200);
    }
}
