<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePelunasanHutangRequest;
use App\Models\{PelunasanHutang, PelunasanHutangDetail, Pembelian, PembelianPembayaran};
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelunasanHutangController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create pelunasan hutang')->only('create');
        $this->middleware('permission:read pelunasan hutang')->only('index');
        $this->middleware('permission:edit pelunasan hutang')->only('edit');
        $this->middleware('permission:detail pelunasan hutang')->only('show');
        $this->middleware('permission:update pelunasan hutang')->only('update');
        $this->middleware('permission:delete pelunasan hutang')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $pelunasan = PelunasanHutang::orderByDesc('id');

            return DataTables::of($pelunasan)
                ->addIndexColumn()
                ->addColumn('action', 'keuangan.pelunasan.hutang.data-table.action')
                ->addColumn('bayar', function ($row) {
                    return number_format($row->bayar);
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

        return view('keuangan.pelunasan.hutang.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('keuangan.pelunasan.hutang.create');
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
            $pelunasan = PelunasanHutang::create([
                'kode' => $request->kode,
                'tanggal' => $request->tanggal,
                'bank_id' => $request->bank,
                'rekening_bank_id' => $request->rekening,
                'jenis_pembayaran' => $request->jenis_pembayaran,
                'rate' => $request->rate,
                'no_cek_giro' => $request->no_cek_giro,
                'tgl_cek_giro' => $request->tgl_cek_giro,
                'bayar' => $request->bayar,
                'keterangan' => $request->keterangan,
            ]);

            foreach ($request->pembelian_id as $id) {
                $pelunasanDetail[] = new PelunasanHutangDetail([
                    'pembelian_id' => $id
                ]);

                $pembelian = Pembelian::find($id);

                // insert pembelian pembayaran
                $pembelian->pembelian_pembayaran()->create([
                    'jenis_pembayaran' => $request->jenis_pembayaran,
                    'bank_id' => $request->bank,
                    'rekening_bank_id' => $request->rekening,
                    'tgl_cek_giro' => $request->tgl_cek_giro,
                    'no_cek_giro' => $request->no_cek_giro,
                    'bayar' => $request->bayar,
                ]);

                // update pembayaran jadi lunas
                $pembelian->update(['status' => 'Lunas']);
            }

            $pelunasan->pelunasan_hutang_detail()->saveMany($pelunasanDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PelunasanHutang  $pelunasanHutang
     * @return \Illuminate\Http\Response
     */
    public function show(PelunasanHutang $pelunasanHutang)
    {
        $pelunasanHutang->load(
            'pelunasan_hutang_detail.pembelian:id,kode,supplier_id,tanggal,total_netto,matauang_id',
            'pelunasan_hutang_detail.pembelian.matauang:id,kode,nama',
            'pelunasan_hutang_detail.pembelian.supplier:id,kode,nama_supplier',
            'pelunasan_hutang_detail.pembelian.matauang:id,kode,nama',
            'bank:id,kode,nama',
            'rekening_bank:id,kode,nomor_rekening,nama_rekening'
        );

        return view('keuangan.pelunasan.hutang.show', compact('pelunasanHutang'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PelunasanHutang  $pelunasanHutang
     * @return \Illuminate\Http\Response
     */
    public function edit(PelunasanHutang $pelunasanHutang)
    {
        $pelunasanHutang->load(
            'pelunasan_hutang_detail.pembelian:id,kode,supplier_id,tanggal,total_netto,matauang_id',
            'pelunasan_hutang_detail.pembelian.matauang:id,kode,nama',
            'pelunasan_hutang_detail.pembelian.supplier:id,kode,nama_supplier',
            'pelunasan_hutang_detail.pembelian.matauang:id,kode,nama',
            'bank:id,kode,nama',
            'rekening_bank:id,kode,nomor_rekening,nama_rekening'
        );

        // return $pelunasanHutang;
        // die;

        return view('keuangan.pelunasan.hutang.edit', compact('pelunasanHutang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PelunasanHutang  $pelunasanHutang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pelunasan = PelunasanHutang::with('pelunasan_hutang_detail', 'pelunasan_hutang_detail.pembelian')->findOrFail($id);

        // buat pembelian lama jadi belum lunas
        foreach ($pelunasan->pelunasan_hutang_detail as $detail) {
            $detail->pembelian->update(['status' => 'Belum Lunas']);

            $detail->pembelian->pembelian_pembayaran()->delete();

            // hapus detail pelunasan lama
            $detail->delete();
        }

        DB::transaction(function () use ($request, $pelunasan) {
            $pelunasan->update([
                // 'kode' => $request->kode,
                // 'tanggal' => $request->tanggal,
                'bank_id' => $request->bank,
                'rekening_bank_id' => $request->rekening,
                'jenis_pembayaran' => $request->jenis_pembayaran,
                // 'rate' => $request->rate,
                'no_cek_giro' => $request->no_cek_giro,
                'tgl_cek_giro' => $request->tgl_cek_giro,
                'bayar' => $request->bayar,
                'keterangan' => $request->keterangan,
            ]);

            foreach ($request->pembelian_id as $id) {
                $pelunasanDetail[] = new PelunasanHutangDetail([
                    'pembelian_id' => $id
                ]);

                $pembelian = Pembelian::find($id);

                // insert pembelian pembayaran
                $pembelian->pembelian_pembayaran()->create([
                    'jenis_pembayaran' => $request->jenis_pembayaran,
                    'bank_id' => $request->bank,
                    'rekening_bank_id' => $request->rekening,
                    'tgl_cek_giro' => $request->tgl_cek_giro,
                    'no_cek_giro' => $request->no_cek_giro,
                    'bayar' => $request->bayar,
                ]);

                // update pembayaran jadi lunas
                $pembelian->update(['status' => 'Lunas']);
            }

            $pelunasan->pelunasan_hutang_detail()->saveMany($pelunasanDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PelunasanHutang  $pelunasanHutang
     * @return \Illuminate\Http\Response
     */
    public function destroy(PelunasanHutang $pelunasanHutang)
    {
        // buat pembelian lama jadi belum lunas
        foreach ($pelunasanHutang->pelunasan_hutang_detail as $detail) {
            $detail->pembelian->update(['status' => 'Belum Lunas']);

            $detail->pembelian->pembelian_pembayaran()->delete();

            // hapus detail pelunasan lama
            $detail->delete();
        }

        $pelunasanHutang->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return back();
    }

    public function getPembelianYgBelumLunas($id)
    {
        abort_if(!request()->ajax(), 404);

        $pembelianBelumLunas = Pembelian::with(
            'supplier:id,kode,nama_supplier',
            'matauang:id,kode,nama'
        )->findOrFail($id);

        return response()->json($pembelianBelumLunas, 200);
    }

    public function generateKode($tanggal)
    {
        abort_if(!request()->ajax(), 404);

        $checkLatestKode = PelunasanHutang::whereMonth('tanggal', date('m', strtotime($tanggal)))->whereYear('tanggal', date('Y', strtotime($tanggal)))->latest()->first();

        if ($checkLatestKode == null) {
            $kode = 'APPAY-' . date('Ym', strtotime($tanggal)) . '00001';
        } else {
            // hapus "APPAY-" dan ambil angka buat ditambahin
            $onlyNumberKode = Str::after($checkLatestKode->kode, 'APPAY-');

            $kode =  'APPAY-' . (intval($onlyNumberKode) + 1);
        }

        return response()->json($kode, 200);
    }
}
