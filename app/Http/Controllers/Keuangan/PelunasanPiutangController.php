<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Http\Requests\PelunasanPiutangRequest;
use App\Models\{PelunasanPiutang, PelunasanPiutangDetail, Penjualan, PenjualanPembayaran};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PelunasanPiutangController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create pelunasan piutang')->only('create');
        $this->middleware('permission:read pelunasan piutang')->only('index');
        $this->middleware('permission:edit pelunasan piutang')->only('edit');
        $this->middleware('permission:detail pelunasan piutang')->only('show');
        $this->middleware('permission:update pelunasan piutang')->only('update');
        $this->middleware('permission:delete pelunasan piutang')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $pelunasan = PelunasanPiutang::orderByDesc('id');

            return DataTables::of($pelunasan)
                ->addIndexColumn()
                ->addColumn('action', 'keuangan.pelunasan.piutang.data-table.action')
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

        return view('keuangan.pelunasan.piutang.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('keuangan.pelunasan.piutang.create');
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
            $pelunasan = PelunasanPiutang::create([
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

            foreach ($request->penjualan_id as $id) {
                $pelunasanDetail[] = new PelunasanPiutangDetail([
                    'penjualan_id' => $id
                ]);

                $penjualan = Penjualan::find($id);

                // insert penjualan pembayaran
                $penjualan->penjualan_pembayaran()->create([
                    'jenis_pembayaran' => $request->jenis_pembayaran,
                    'bank_id' => $request->bank,
                    'rekening_bank_id' => $request->rekening,
                    'tgl_cek_giro' => $request->tgl_cek_giro,
                    'no_cek_giro' => $request->no_cek_giro,
                    'bayar' => $request->bayar,
                ]);

                // update pembayaran jadi lunas
                $penjualan->update(['status' => 'Lunas']);
            }

            $pelunasan->pelunasan_piutang_detail()->saveMany($pelunasanDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PelunasanPiutang  $pelunasanPiutang
     * @return \Illuminate\Http\Response
     */
    public function show(PelunasanPiutang $pelunasanPiutang)
    {
        $pelunasanPiutang->load(
            'pelunasan_piutang_detail.penjualan:id,kode,tanggal,total_netto,matauang_id,pelanggan_id',
            'pelunasan_piutang_detail.penjualan.matauang:id,kode,nama',
            'pelunasan_piutang_detail.penjualan.pelanggan:id,kode,alamat,nama_pelanggan',
            'bank:id,kode,nama',
            'rekening_bank:id,nomor_rekening,nama_rekening'
        );

        return view('keuangan.pelunasan.piutang.show', compact('pelunasanPiutang'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PelunasanPiutang  $pelunasanPiutang
     * @return \Illuminate\Http\Response
     */
    public function edit(PelunasanPiutang $pelunasanPiutang)
    {
        $pelunasanPiutang->load(
            'pelunasan_piutang_detail.penjualan:id,kode,tanggal,total_netto,matauang_id,pelanggan_id',
            'pelunasan_piutang_detail.penjualan.matauang:id,kode,nama',
            'pelunasan_piutang_detail.penjualan.pelanggan:id,kode,alamat,nama_pelanggan',
            'bank:id,kode,nama',
            'rekening_bank:id,nomor_rekening,nama_rekening'
        );

        return view('keuangan.pelunasan.piutang.edit', compact('pelunasanPiutang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PelunasanPiutang  $pelunasanPiutang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pelunasan = PelunasanPiutang::with('pelunasan_piutang_detail', 'pelunasan_piutang_detail.penjualan')->findOrFail($id);

        // buat penjualan lama jadi belum lunas
        foreach ($pelunasan->pelunasan_piutang_detail as $detail) {
            $detail->penjualan->update(['status' => 'Belum Lunas']);

            $detail->penjualan->penjualan_pembayaran()->delete();

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

            foreach ($request->penjualan_id as $id) {
                $pelunasanDetail[] = new PelunasanPiutangDetail([
                    'penjualan_id' => $id
                ]);

                $penjualan = Penjualan::find($id);

                // insert penjualan pembayaran
                $penjualan->penjualan_pembayaran()->create([
                    'jenis_pembayaran' => $request->jenis_pembayaran,
                    'bank_id' => $request->bank,
                    'rekening_bank_id' => $request->rekening,
                    'tgl_cek_giro' => $request->tgl_cek_giro,
                    'no_cek_giro' => $request->no_cek_giro,
                    'bayar' => $request->bayar,
                ]);

                // update pembayaran jadi lunas
                $penjualan->update(['status' => 'Lunas']);
            }

            $pelunasan->pelunasan_piutang_detail()->saveMany($pelunasanDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PelunasanPiutang  $pelunasanPiutang
     * @return \Illuminate\Http\Response
     */
    public function destroy(PelunasanPiutang $pelunasanPiutang)
    {
        // buat penjualan lama jadi belum lunas
        foreach ($pelunasanPiutang->pelunasan_piutang_detail as $detail) {
            $detail->penjualan->update(['status' => 'Belum Lunas']);

            $detail->penjualan->penjualan_pembayaran()->delete();

            // hapus detail pelunasan lama
            $detail->delete();
        }

        $pelunasanPiutang->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return back();
    }

    protected function getPenjualanYgBelumLunas($id)
    {
        abort_if(!request()->ajax(), 404);

        $penjualanBelumLunas = Penjualan::select(
            'id',
            'kode',
            'total_netto',
            'tanggal',
            'matauang_id',
            'pelanggan_id'
        )->with(
            'pelanggan:id,kode,nama_pelanggan,alamat',
            'matauang:id,kode,nama'
        )->findOrFail($id);

        return response()->json($penjualanBelumLunas, 200);
    }

    protected function generateKode($tanggal)
    {
        abort_if(!request()->ajax(), 404);

        $checkLatestKode = PelunasanPiutang::whereMonth('tanggal', date('m', strtotime($tanggal)))->whereYear('tanggal', date('Y', strtotime($tanggal)))->latest()->first();

        if ($checkLatestKode == null) {
            $kode = 'ARPAY-' . date('Ym', strtotime($tanggal)) . '00001';
        } else {
            // hapus "ARPAY-" dan ambil angka buat ditambahin
            $onlyNumberKode = \Str::after($checkLatestKode->kode, 'ARPAY-');

            $kode =  'ARPAY-' . (intval($onlyNumberKode) + 1);
        }

        return response()->json($kode, 200);
    }
}
