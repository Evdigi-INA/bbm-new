<?php

namespace App\Providers;

use App\Models\{Area, Bank, Barang, CekGiro, Gudang, Kategori, Matauang, Pelanggan, Pembelian, Penjualan, PesananPembelian, PesananPenjualan, Salesman, SatuanBarang, Supplier};
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\{Role, Permission};
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // list barang
        View::composer([
            // 'inventory.adjustment-plus.create',
            // 'inventory.adjustment-plus.edit',
            'inventory.adjustment-minus.create',
            'inventory.adjustment-minus.edit',
            // 'pembelian.pesanan-pembelian.create',
            // 'pembelian.pesanan-pembelian.edit',
            // 'pembelian.pembelian.create',
            // 'pembelian.pembelian.edit',
            // 'penjualan.penjualan.edit',
            // 'penjualan.penjualan.create',
            'inventory.perakitan-paket.create',
            'inventory.perakitan-paket.edit',
            'laporan.adjustment.plus.index',
            'laporan.adjustment.minus.index',
            'laporan.pembelian.pesanan.index',
            // 'laporan.pembelian.pembelian.index',
            'laporan.pembelian.retur.index',
            // 'penjualan.pesanan.create',
            // 'penjualan.pesanan.edit',
            // 'laporan.profit.gross.index',
            'laporan.stok.index',
            // 'penjualan.direct.create'
        ], function ($view) {
            return $view->with(
                'barang',
                Barang::select('id', 'kode', 'nama', 'harga_jual', 'harga_beli', 'stok', 'min_stok')
                    ->where('status', 'Y')
                    ->where('jenis', 1)
                    ->get()
            );
        });

        // 1 =  barang, 2 = paket

        // list paket
        View::composer([
            'inventory.perakitan-paket.create',
            'inventory.perakitan-paket.edit'
        ], function ($view) {
            return $view->with(
                'paket',
                Barang::select('id', 'kode', 'nama', 'harga_jual', 'harga_beli', 'stok', 'min_stok')
                    ->where('status', 'Y')
                    ->where('jenis', 2)
                    ->get()
            );
        });

        // list supplier
        View::composer([
            'inventory.adjustment-plus.create',
            'inventory.adjustment-plus.edit',
            'inventory.adjustment-minus.create',
            'inventory.adjustment-minus.edit',
            'pembelian.pesanan-pembelian.create',
            'pembelian.pesanan-pembelian.edit',
            'pembelian.pembelian.create',
            'laporan.adjustment.plus.index',
            'laporan.adjustment.minus.index',
            'laporan.pembelian.pesanan.index',
            'laporan.pembelian.pembelian.index',
            'laporan.pembelian.retur.index',
            'laporan.pelunasan.hutang.index',
            'laporan.saldo.hutang.index',
        ], function ($view) {
            return $view->with(
                'supplier',
                Supplier::select('id', 'kode', 'alamat', 'status', 'nama_supplier')
                    ->where('status', 'Y')
                    ->get()
            );
        });


        // list gudang
        View::composer([
            'inventory.adjustment-plus.create',
            'inventory.adjustment-plus.edit',
            'inventory.adjustment-minus.create',
            'inventory.adjustment-minus.edit',
            'pembelian.pembelian.create',
            'pembelian.pembelian.edit',
            'pembelian.retur.create',
            'pembelian.retur.edit',
            'penjualan.penjualan.edit',
            'penjualan.penjualan.create',
            'penjualan.retur.edit',
            'penjualan.retur.create',
            'inventory.perakitan-paket.create',
            'inventory.perakitan-paket.edit',
            'laporan.adjustment.plus.index',
            'laporan.adjustment.minus.index',
            'laporan.pembelian.pembelian.index',
            'laporan.pembelian.retur.index',
            'laporan.penjualan.penjualan.index',
            'laporan.penjualan.retur.index',
            'laporan.profit.gross.index',
            'laporan.stok.index',
            'penjualan.direct.create'
        ], function ($view) {
            return $view->with(
                'gudang',
                Gudang::select('id', 'kode', 'nama')
                    ->where('status', 'Y')
                    ->get()
            );
        });


        // list matauang
        View::composer([
            'inventory.adjustment-plus.create',
            'pembelian.pesanan-pembelian.create',
            'pembelian.pembelian.create',
            'master-data.rate-matauang.create',
            'master-data.rate-matauang.edit',
            'master-data.barang.create',
            'master-data.barang.edit',
            // 'penjualan.penjualan.edit',
            'penjualan.penjualan.create',
            'keuangan.biaya.create',
            'keuangan.biaya.edit',
            'laporan.pelunasan.hutang.index',
            'laporan.pelunasan.piutang.index',
            'penjualan.pesanan.create',
            'laporan.saldo.hutang.index',
            'laporan.saldo.piutang.index',
            'laporan.profit.gross.index',
            'penjualan.direct.create'
        ], function ($view) {
            return $view->with('matauang', Matauang::select('id', 'kode', 'nama')->get());
        });


        // list bank
        View::composer([
            'pembelian.pembelian.create',
            'pembelian.pembelian.edit',
            'master-data.rekening-bank.create',
            'master-data.rekening-bank.edit',
            'penjualan.penjualan.edit',
            'penjualan.penjualan.create',
            'keuangan.pelunasan.hutang.edit',
            'keuangan.pelunasan.hutang.create',
            'keuangan.pelunasan.piutang.edit',
            'keuangan.pelunasan.piutang.create',
            'keuangan.cek-giro.cair.create',
            'keuangan.cek-giro.cair.edit',
            'keuangan.biaya.create',
            'keuangan.biaya.edit',
            'laporan.biaya.index',
        ], function ($view) {
            return $view->with('bank', Bank::select('id', 'kode', 'nama')->get());
        });


        // list pesananPembelian
        View::composer([
            'pembelian.pembelian.create',
            // 'pembelian.pembelian.edit',
        ], function ($view) {
            return $view->with(
                'pesananPembelian',
                PesananPembelian::select('kode', 'id')
                    ->where('status_po', 'OPEN')
                    ->orderByDesc('id')
                    ->limit(150)
                    ->get()
            );
        });

        // list pesananPenjualan
        View::composer([
            'penjualan.penjualan.create',
        ], function ($view) {
            return $view->with(
                'pesananPenjualan',
                PesananPenjualan::select('kode', 'id')
                    ->where('status', 'OPEN')
                    ->orderByDesc('id')
                    ->limit(150)
                    ->get()
            );
        });


        // list penjualan
        View::composer([
            'penjualan.retur.create'
        ], function ($view) {
            return $view->with(
                'penjualan',
                Penjualan::select('kode', 'id')
                    ->where('retur', 'NO')
                    ->orderByDesc('id')
                    ->limit(150)
                    ->get()
            );
        });

        // list semua  penjualan
        View::composer([
            'laporan.pelunasan.piutang.index',
        ], function ($view) {
            return $view->with(
                'semuaPenjualan',
                Penjualan::select('kode', 'id')
                    ->orderByDesc('id')
                    ->limit(150)
                    ->get()
            );
        });


        // list pembelian belum lunas
        View::composer([
            'keuangan.pelunasan.hutang.edit',
            'keuangan.pelunasan.hutang.create',
            // 'laporan.pelunasan.hutang.index'
        ], function ($view) {
            $pembelianBelumLunas = Pembelian::select('kode', 'id')
                ->whereStatus('Belum Lunas')
                ->orderByDesc('id')
                ->limit(150)
                ->get();

            return $view->with('pembelianBelumLunas', $pembelianBelumLunas);
        });

        // list penjualan belum dibayar
        View::composer([
            'keuangan.pelunasan.piutang.edit',
            'keuangan.pelunasan.piutang.create'
        ], function ($view) {
            $penjualanBelumLunas =
                Penjualan::select('kode', 'id')
                ->whereStatus('Belum Lunas')
                ->orderByDesc('id')
                ->limit(150)
                ->get();

            return $view->with('penjualanBelumLunas', $penjualanBelumLunas);
        });

        // list Pelanggan
        View::composer([
            'penjualan.penjualan.create',
            // 'penjualan.penjualan.edit',
            'penjualan.retur.create',
            'laporan.penjualan.penjualan.index',
            'laporan.penjualan.retur.index',
            'laporan.pelunasan.piutang.index',
            'penjualan.pesanan.create',
            'penjualan.pesanan.edit',
            'laporan.saldo.piutang.index',
            'laporan.profit.gross.index',
            'laporan.penjualan.pesanan.index',
            'penjualan.direct.create'
        ], function ($view) {
            return $view->with('pelanggan', Pelanggan::select('id', 'nama_pelanggan', 'alamat', 'kode')->where('status', 'Y')->get());
        });


        // list Kategori
        View::composer([
            'master-data.barang.create',
            'master-data.barang.edit'
        ], function ($view) {
            return $view->with('kategori', Kategori::all());
        });


        // list Satuan
        View::composer([
            'master-data.barang.create',
            'master-data.barang.edit'
        ], function ($view) {
            return $view->with('satuan', SatuanBarang::all());
        });


        // list pembelian yg ga diretur
        View::composer([
            'pembelian.retur.create',
            'pembelian.retur.edit',
        ], function ($view) {
            return $view->with(
                'pembelian',
                Pembelian::select('id', 'kode')
                    ->where('retur', 'NO')
                    ->orderByDesc('id')
                    ->limit(150)
                    ->get()
            );
        });

        // list semua pembelian
        View::composer([
            'laporan.pelunasan.hutang.index'
        ], function ($view) {
            return $view->with(
                'semuaPembelian',
                Pembelian::select('id', 'kode')
                    ->orderByDesc('id')
                    ->limit(150)
                    ->get()
            );
        });

        // list roles
        View::composer([
            'setting.user.create',
            'setting.user.edit'
        ], function ($view) {
            // dicache biar ga cuma get query ke database cuma sekali aja
            $role = Cache::rememberForever('role', function () {
                return Role::all();
            });

            return $view->with('roles', $role);
        });

        // list permissions
        View::composer([
            'setting.user.create',
            'setting.user.edit'
        ], function ($view) {
            $permissions = Cache::rememberForever('permissions', function () {
                return  Permission::all();
            });

            return $view->with('permissions', $permissions);
        });

        // list salesman
        View::composer([
            'setting.user.create',
            'setting.user.edit',
            'penjualan.penjualan.edit',
            'penjualan.penjualan.create',
            'laporan.penjualan.penjualan.index',
            'laporan.penjualan.retur.index',
            'laporan.komisi-salesman.index',
            'laporan.saldo.piutang.index',
            'laporan.profit.gross.index'
        ], function ($view) {
            return $view->with('salesman', Salesman::select('id', 'nama')->where('status', 'Y')->get());
        });

        // list area
        View::composer([
            'master-data.pelanggan.create',
            'master-data.pelanggan.edit'
        ], function ($view) {
            return $view->with('area', Area::where('status', 'Y')->get());
        });

        // Cek/Giro yang belum dilunas/dibayar
        View::composer([
            'keuangan.cek-giro.cair.create',
            'keuangan.cek-giro.cair.edit',
            'keuangan.cek-giro.tolak.create',
            'keuangan.cek-giro.tolak.edit'
        ], function ($view) {
            $cekGiroBelumLunas = CekGiro::with('pembelian', 'penjualan', 'pembelian.pembelian_pembayaran', 'penjualan.penjualan_pembayaran')
                ->where('status', 'Belum Lunas')
                ->get();

            return $view->with('cekGiroBelumLunas', $cekGiroBelumLunas);
        });

        // list Status PO
        View::composer([
            'laporan.pembelian.pesanan.index',
            'laporan.penjualan.pesanan.index'
        ], function ($view) {
            return $view->with(
                'statusPo',
                collect([
                    (object)[
                        'id' => 'Open',
                        'nama' => 'Open'
                    ],
                    (object)[
                        'id' => 'Used',
                        'nama' => 'Used'
                    ],
                    (object)[
                        'id' => 'Cancel',
                        'nama' => 'Cancel'
                    ],
                ])
            );
        });

        // list dicairkan ke
        View::composer([
            'keuangan.cek-giro.cair.create',
            'keuangan.cek-giro.cair.edit',
            'keuangan.biaya.create',
            'keuangan.biaya.edit'
        ], function ($view) {
            return $view->with(
                'dicairkanKe',
                collect([
                    (object)[
                        'id' => 'Kas',
                        'nama' => 'Kas'
                    ],
                    (object)[
                        'id' => 'Bank',
                        'nama' => 'Bank'
                    ],
                ])
            );
        });

        // list jenis transaksi
        View::composer([
            'keuangan.biaya.create',
            'keuangan.biaya.edit'
        ], function ($view) {
            return $view->with(
                'jenisTransaksi',
                collect([
                    (object)[
                        'id' => 'Pemasukan',
                        'nama' => 'Pemasukan'
                    ],
                    (object)[
                        'id' => 'Pengeluaran',
                        'nama' => 'Pengeluaran'
                    ],
                ])
            );
        });

        // list jenis Cek/giro
        View::composer([
            'laporan.cek-giro.index'
        ], function ($view) {
            return $view->with(
                'jenisCekGiro',
                collect([
                    (object)[
                        'id' => 'In',
                        'nama' => 'In'
                    ],
                    (object)[
                        'id' => 'Out',
                        'nama' => 'Out'
                    ],
                ])
            );
        });

        // list status Cek/giro
        View::composer([
            'laporan.cek-giro.index'
        ], function ($view) {
            return $view->with(
                'statusCekGiro',
                collect([
                    (object)[
                        'id' => 'Belum Lunas',
                        'nama' => 'Belum Lunas'
                    ],
                    (object)[
                        'id' => 'Cair',
                        'nama' => 'Cair'
                    ],
                    (object)[
                        'id' => 'Tolak',
                        'nama' => 'Tolak'
                    ],
                ])
            );
        });

        // list status Hutang/Piutang
        View::composer([
            'laporan.saldo.hutang.index',
            'laporan.saldo.piutang.index'
        ], function ($view) {
            return $view->with(
                'statusHutangPiutang',
                collect([
                    (object)[
                        'id' => 'Belum Lunas',
                        'nama' => 'Belum Lunas'
                    ],
                    (object)[
                        'id' => 'Lunas',
                        'nama' => 'Lunas'
                    ],
                    // (object)[
                    //     'id' => 'Over Due',
                    //     'nama' => 'Over Due'
                    // ],
                ])
            );
        });

        // list bentuk kepemilikan stok
        View::composer([
            'laporan.adjustment.plus.index',
            'laporan.adjustment.minus.index',
            'laporan.pembelian.pesanan.index',
            'laporan.pembelian.pembelian.index',
            'laporan.pembelian.retur.index',
            'penjualan.pesanan.create',
            'penjualan.pesanan.edit',
            'laporan.stok.index',
            'laporan.penjualan.pesanan.index',
            'penjualan.direct.create'
        ], function ($view) {
            return $view->with(
                'bentukKepemilikanStok',
                collect([
                    (object)[
                        'id' => 'Stok Sendiri',
                        'nama' => 'Stok Sendiri'
                    ],
                    (object)[
                        'id' => 'Konsinyasi',
                        'nama' => 'Konsinyasi'
                    ],
                ])
            );
        });

        // list jenisPembayaran
        View::composer([
            'pembelian.pembelian.create',
            'pembelian.pembelian.edit',
            'penjualan.penjualan.edit',
            'penjualan.penjualan.create',
            'keuangan.pelunasan.hutang.edit',
            'keuangan.pelunasan.hutang.create',
            'keuangan.pelunasan.piutang.edit',
            'keuangan.pelunasan.piutang.create',
            'laporan.pelunasan.hutang.index',
            'laporan.pelunasan.piutang.index',
            'penjualan.pesanan.create',
            'penjualan.pesanan.edit',
        ], function ($view) {
            $jenisPembayaran = Cache::rememberForever('jenisPembayaran', function () {
                return collect([
                    (object)  [
                        'id' => 'Cash',
                        'nama' => 'Cash'
                    ],
                    (object)  [
                        'id' => 'Transfer',
                        'nama' =>  'Transfer',
                    ],
                    (object) [
                        'id' => 'Giro',
                        'nama' => 'Giro'
                    ]
                ]);
            });

            return $view->with('jenisPembayaran', $jenisPembayaran);
        });
    }
}
