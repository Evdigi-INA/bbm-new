<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBiayaRequest;
use App\Models\Biaya;
use App\Models\BiayaDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class BiayaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create biaya')->only('create');
        $this->middleware('permission:read biaya')->only('index');
        $this->middleware('permission:edit biaya')->only('edit');
        $this->middleware('permission:update biaya')->only('update');
        $this->middleware('permission:delete biaya')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $biaya = Biaya::with('matauang:id,kode,nama')->orderByDesc('id');

            return DataTables::of($biaya)
                ->addIndexColumn()
                ->addColumn('action', 'keuangan.biaya.data-table.action')
                ->addColumn('matauang', function ($row) {
                    return $row->matauang->nama;
                })
                ->addColumn('total', function ($row) {
                    return number_format($row->total);
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

        return view('keuangan.biaya.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('keuangan.biaya.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBiayaRequest $request)
    {
        DB::transaction(function () use ($request) {
            $attr = $request->validated();
            $attr['bank_id'] = $request->bank;
            $attr['matauang_id'] = $request->matauang;
            $attr['rekening_bank_id'] = $request->rekening;
            $attr['total'] = 0;
            $biayaDetail = [];

            foreach ($request->jumlah as $i => $jumlah) {
                $attr['total'] += $jumlah;

                $biayaDetail[] = new BiayaDetail([
                    'jumlah' => $jumlah,
                    'deskripsi' => $request->deskripsi[$i]
                ]);
            }

            $biaya = Biaya::create($attr);

            $biaya->biaya_detail()->saveMany($biayaDetail);
        });

        Alert::success('Simpan Data', 'Berhasil');

        return redirect()->route('biaya.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Biaya  $biaya
     * @return \Illuminate\Http\Response
     */
    public function show(Biaya $biaya)
    {
        $biaya->load(
            'matauang:id,kode,nama',
            'rekening:id,nomor_rekening,nama_rekening',
            'bank:id,kode,nama',
            'biaya_detail'
        );

        return view('keuangan.biaya.show', compact('biaya'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Biaya  $biaya
     * @return \Illuminate\Http\Response
     */
    public function edit(Biaya $biaya)
    {
        $biaya->load(
            'matauang:id,kode,nama',
            'rekening:id,nomor_rekening,nama_rekening',
            'bank:id,kode,nama',
            'biaya_detail'
        );

        return view('keuangan.biaya.edit', compact('biaya'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Biaya  $biaya
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBiayaRequest $request, Biaya $biaya)
    {
        DB::transaction(function () use ($request, $biaya) {
            $attr = $request->validated();
            $attr['bank_id'] = $request->bank;
            $attr['matauang_id'] = $request->matauang;
            $attr['rekening_bank_id'] = $request->rekening;
            $attr['total'] = 0;
            $biayaDetail = [];

            // hapus detail lama
            $biaya->biaya_detail()->delete();
            foreach ($request->jumlah as $i => $jumlah) {
                $attr['total'] += $jumlah;

                $biayaDetail[] = new BiayaDetail([
                    'jumlah' => $jumlah,
                    'deskripsi' => $request->deskripsi[$i]
                ]);
            }

            $biaya->update($attr);

            // insert detail baru
            $biaya->biaya_detail()->saveMany($biayaDetail);
        });

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('biaya.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Biaya  $biaya
     * @return \Illuminate\Http\Response
     */
    public function destroy(Biaya $biaya)
    {
        $biaya->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('biaya.index');
    }

    public function generateKode($tanggal)
    {
        abort_if(!request()->ajax(), 404);

        $checkLatestKode = Biaya::whereMonth('tanggal', date('m', strtotime($tanggal)))->whereYear('tanggal', date('Y', strtotime($tanggal)))->latest()->first();

        if ($checkLatestKode == null) {
            $kode = 'EXPEN-' . date('Ym', strtotime($tanggal)) . '00001';
        } else {
            // hapus "EXPEN-" dan ambil angka buat ditambahin
            $onlyNumberKode = \Str::after($checkLatestKode->kode, 'EXPEN-');

            $kode =  'EXPEN-' . (intval($onlyNumberKode) + 1);
        }

        return response()->json($kode, 200);
    }
}
