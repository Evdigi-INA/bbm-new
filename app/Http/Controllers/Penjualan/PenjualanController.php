<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\PenjualanPembayaran;
use App\Models\PesananPenjualan;
use App\Models\RekeningBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create penjualan')->only('create');
        $this->middleware('permission:read penjualan')->only('index');
        $this->middleware('permission:edit penjualan')->only('edit');
        $this->middleware('permission:detail penjualan')->only('show');
        $this->middleware('permission:update penjualan')->only('update');
        $this->middleware('permission:delete penjualan')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $penjualan = Penjualan::with('gudang', 'pelanggan', 'salesman', 'matauang', 'pesanan_penjualan')->withCount('penjualan_detail')->orderByDesc('id');

            return Datatables::of($penjualan)
                ->addIndexColumn()
                ->addColumn('action', 'penjualan.penjualan.data-table.action')
                ->addColumn('kode_so', function ($row) {
                    return $row->pesanan_penjualan ? $row->pesanan_penjualan->kode : 'Tanpa S.O';
                })
                ->addColumn('tanggal', function ($row) {
                    return $row->tanggal->format('d F Y');
                })
                ->addColumn('matauang', function ($row) {
                    return $row->matauang->nama;
                })
                ->addColumn('pelanggan', function ($row) {
                    return $row->pelanggan->nama_pelanggan;
                })
                ->addColumn('gudang', function ($row) {
                    return $row->gudang ?  $row->gudang->nama : '';
                })
                ->addColumn('salesman', function ($row) {
                    return $row->salesman ? $row->salesman->nama : 'Tanpa Salesman';
                })
                ->addColumn('total_barang', function ($row) {
                    return $row->penjualan_detail_count;
                })
                ->addColumn('grand_total', function ($row) {
                    return $row->matauang->kode . ' ' . number_format($row->total_penjualan);
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d F Y H:i');
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d F Y H:i');
                })
                ->toJson();
        }

        return view('penjualan.penjualan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('penjualan.penjualan.create');
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
            $penjualan = Penjualan::create([
                'kode' => $request->kode,
                'tanggal' => $request->tanggal,
                'pesanan_penjualan_id' => $request->pesanan_penjualan_id,
                'matauang_id' => $request->matauang,
                'gudang_id' => $request->gudang,
                'pelanggan_id' => $request->pelanggan,
                'salesman_id' => $request->salesman,
                'keterangan' => $request->keterangan,
                'bentuk_kepemilikan_stok' => $request->bentuk_kepemilikan,
                'rate' => $request->rate,
                'alamat' => $request->alamat,
                'subtotal' => $request->subtotal,
                'total_ppn' => $request->total_ppn,
                'total_gross' => $request->total_gross,
                'total_diskon' => $request->total_diskon,
                'total_penjualan' => $request->total_penjualan,
                'total_biaya_kirim' => $request->total_biaya_kirim ? $request->total_biaya_kirim : 0,
                'total_netto' => $request->total_netto,
            ]);

            foreach ($request->barang as $i => $value) {
                $penjualanDetail[] = new PenjualanDetail([
                    'barang_id' => $value,
                    'harga' => $request->harga[$i],
                    'qty' => $request->qty[$i],
                    'diskon_persen' => $request->diskon_persen[$i],
                    'diskon' => $request->diskon[$i],
                    'gross' => $request->gross[$i],
                    'ppn' => $request->ppn[$i],
                    'netto' => $request->netto[$i],
                ]);

                // Update stok barang
                $barangQuery = Barang::whereId($value);
                $getBarang = $barangQuery->first();
                $barangQuery->update(['stok' => ($getBarang->stok - $request->qty[$i])]);
            }

            // kalo user isi jenis pembayaran dan bayar berarti di ga ngutag
            if ($request->jenis_pembayaran && $request->bayar) {
                foreach ($request->bank as $i => $value) {
                    $pembayaran[] = new PenjualanPembayaran([
                        'jenis_pembayaran' => $request->jenis_pembayaran[$i],
                        'bank_id' => $request->bank[$i],
                        'rekening_bank_id' => $request->rekening[$i],
                        'tgl_cek_giro' => $request->tgl_cek_giro[$i],
                        'no_cek_giro' => $request->no_cek_giro[$i],
                        'bayar' => $request->bayar[$i],
                    ]);

                    if ($request->jenis_pembayaran[$i] == 'Giro') {
                        DB::table('cek_giro')->insert([
                            'penjualan_id' => $penjualan->id,
                            'jenis_cek' => 'In',
                            'status' => 'Belum Lunas',
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }

                $penjualan->penjualan_pembayaran()->saveMany($pembayaran);
            }

            $penjualan->penjualan_detail()->saveMany($penjualanDetail);

            $penjualan->pesanan_penjualan()->update(['status' => 'USED']);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function show(Penjualan $penjualan)
    {
        $penjualan->load(
            'pesanan_penjualan',
            // 'pesanan_penjualan.pesanan_penjualan_detail.barang',
            'penjualan_detail',
            'penjualan_detail.barang:id,kode,nama,harga_jual,harga_beli',
            'penjualan_pembayaran',
            'penjualan_pembayaran.bank:id,kode,nama',
            'penjualan_pembayaran.rekening:id,nomor_rekening,nama_rekening',
            'gudang:id,kode,nama',
            'salesman:id,kode,nama',
            'pelanggan:id,kode,nama_pelanggan',
            'matauang:id,kode,nama'
        );

        return view('penjualan.penjualan.show', compact('penjualan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(Penjualan $penjualan)
    {
        $penjualan->load(
            'pesanan_penjualan',
            // 'pesanan_penjualan.pesanan_penjualan_detail.barang',
            'penjualan_detail',
            'penjualan_detail.barang:id,kode,nama,harga_jual,harga_beli',
            'penjualan_pembayaran',
            'penjualan_pembayaran.bank:id,kode,nama',
            'penjualan_pembayaran.rekening:id,nomor_rekening,nama_rekening',
            'gudang:id,kode,nama',
            'salesman:id,kode,nama',
            'pelanggan:id,kode,nama_pelanggan',
            'matauang:id,kode,nama'
        );

        return view('penjualan.penjualan.edit', compact('penjualan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        DB::transaction(function () use ($request, $penjualan) {
            // hapus list lama
            $penjualan->penjualan_pembayaran()->delete();
            $penjualan->cek_giro()->delete();
            $penjualan->pesanan_penjualan()->update(['status' => 'OPEN']);

            $penjualan->update([
                'kode' => $request->kode,
                'gudang_id' => $request->gudang,
                'keterangan' => $request->keterangan,
                'subtotal' => $request->subtotal,
                'total_ppn' => $request->total_ppn,
                'total_gross' => $request->total_gross,
                'total_diskon' => $request->total_diskon,
                'total_penjualan' => $request->total_penjualan,
                'total_biaya_kirim' => $request->total_biaya_kirim,
                'total_netto' => $request->total_netto,
                'salesman_id' => $request->salesman,
                // 'pelanggan_id' => $request->pelanggan,
                // 'bentuk_kepemilikan_stok' => $request->bentuk_kepemilikan,
                // 'alamat' => $request->alamat,
            ]);

            foreach ($request->barang as $i => $value) {
                $penjualanDetail[] = new PenjualanDetail([
                    'barang_id' => $value,
                    'harga' => $request->harga[$i],
                    'qty' => $request->qty[$i],
                    'diskon_persen' => $request->diskon_persen[$i],
                    'diskon' => $request->diskon[$i],
                    'gross' => $request->gross[$i],
                    'ppn' => $request->ppn[$i],
                    'netto' => $request->netto[$i],
                ]);

                // Update stok barang
                $barangQuery = Barang::whereId($value);
                $getBarang = $barangQuery->first();
                $barangQuery->update(['stok' => ($getBarang->stok - $request->qty[$i])]);
            }

            // kalo user isi jenis pembayaran dan bayar berarti di ga ngutag
            if ($request->jenis_pembayaran && $request->bayar) {
                foreach ($request->bank as $i => $value) {
                    $pembayaran[] = new PenjualanPembayaran([
                        'jenis_pembayaran' => $request->jenis_pembayaran[$i],
                        'bank_id' => $request->bank[$i],
                        'rekening_bank_id' => $request->rekening[$i],
                        'tgl_cek_giro' => $request->tgl_cek_giro[$i],
                        'no_cek_giro' => $request->no_cek_giro[$i],
                        'bayar' => $request->bayar[$i],
                    ]);

                    if ($request->jenis_pembayaran[$i] == 'Giro') {
                        DB::table('cek_giro')->insert([
                            'penjualan_id' => $penjualan->id,
                            'jenis_cek' => 'In',
                            'status' => 'Belum Lunas',
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }

                $penjualan->penjualan_pembayaran()->saveMany($pembayaran);
            }

            $penjualan->penjualan_detail()->delete();

            $penjualan->penjualan_detail()->saveMany($penjualanDetail);

            $penjualan->pesanan_penjualan()->update(['status' => 'USED']);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penjualan $penjualan)
    {
        $penjualan->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return back();
    }

    public function generateKode($tanggal)
    {
        abort_if(!request()->ajax(), 404);

        $checkLatestKode = Penjualan::whereMonth('tanggal', date('m', strtotime($tanggal)))->whereYear('tanggal', date('Y', strtotime($tanggal)))->latest()->first();

        if ($checkLatestKode == null) {
            $kode = 'SALES-' . date('Ym', strtotime($tanggal)) . '00001';
        } else {
            // hapus "SALES-" dan ambil angka buat ditambahin
            $onlyNumberKode = \Str::after($checkLatestKode->kode, 'SALES-');

            $kode =  'SALES-' . (intval($onlyNumberKode) + 1);
        }

        return response()->json($kode, 200);
    }

    public function getRekeningByBankId($id)
    {
        abort_if(!request()->ajax(), 404);

        $rekening = RekeningBank::whereBankId($id)->get();

        return response()->json($rekening, 200);
    }

    public function getAlamatPelanggan($id)
    {
        abort_if(!request()->ajax(), 404);

        return response()->json(Pelanggan::select('alamat')->findOrFail($id), 200);
    }

    public function getDataSO($id)
    {
        abort_if(!request()->ajax(), 404);

        $pesananPenjualan = PesananPenjualan::with(
            'pelanggan:id,kode,nama_pelanggan,alamat',
            'matauang:id,kode,nama',
            'pesanan_penjualan_detail',
            'pesanan_penjualan_detail.barang'
        )->findOrFail($id);

        return response()->json($pesananPenjualan, 200);
    }
}
