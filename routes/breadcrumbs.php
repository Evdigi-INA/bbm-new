<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard.index'));
});
// Master
Breadcrumbs::for('master', function (BreadcrumbTrail $trail) {
    $trail->push('Master Data');
});

// inventory
Breadcrumbs::for('inventory', function (BreadcrumbTrail $trail) {
    $trail->push('Inventory');
});

// beli
Breadcrumbs::for('beli', function (BreadcrumbTrail $trail) {
    $trail->push('Beli');
});

// jual
Breadcrumbs::for('jual', function (BreadcrumbTrail $trail) {
    $trail->push('Jual');
});

// keuangan
Breadcrumbs::for('keuangan', function (BreadcrumbTrail $trail) {
    $trail->push('Keuangan');
});

// // pengaturan
// Breadcrumbs::for('pengaturan', function (BreadcrumbTrail $trail) {
//     $trail->push('Pengaturan');
// });

// // akun
// Breadcrumbs::for('akun', function (BreadcrumbTrail $trail) {
//     $trail->push('Akun');
// });


// laporan
Breadcrumbs::for('laporan', function (BreadcrumbTrail $trail) {
    $trail->push('Laporan');
});


// Master Data > Mata Uang
Breadcrumbs::for('matauang', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Mata Uang', route('matauang.index'));
});
// Master Data > Mata Uang > Tambah
Breadcrumbs::for('matauang_add', function (BreadcrumbTrail $trail) {
    $trail->parent('matauang');
    $trail->push('Tambah', route('matauang.create'));
});
// Master Data > Mata Uang > Tambah
Breadcrumbs::for('matauang_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('matauang');
    $trail->push('Edit');
});
// Master Data > Rate Mata Uang
Breadcrumbs::for('rate_matauang', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Rate Mata Uang', route('rate-matauang.index'));
});
// Master Data > Rate Mata Uang > Tambah
Breadcrumbs::for('rate_matauang_add', function (BreadcrumbTrail $trail) {
    $trail->parent('rate_matauang');
    $trail->push('Tambah', route('rate-matauang.create'));
});
// Master Data > Rate Mata Uang > Edit
Breadcrumbs::for('rate_matauang_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('rate_matauang');
    $trail->push('Edit');
});
// Master Data > Bank
Breadcrumbs::for('bank', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Bank', route('bank.index'));
});
// Master Data > Bank > Tambah
Breadcrumbs::for('bank_add', function (BreadcrumbTrail $trail) {
    $trail->parent('bank');
    $trail->push('Tambah', route('bank.create'));
});
// Master Data > Bank > Edit
Breadcrumbs::for('bank_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('bank');
    $trail->push('Edit');
});
// Master Data > Rekening Bank
Breadcrumbs::for('rekening_bank', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Rekening Bank', route('rekening-bank.index'));
});
// Master Data > Rekening Bank > Tambah
Breadcrumbs::for('rekening_bank_add', function (BreadcrumbTrail $trail) {
    $trail->parent('rekening_bank');
    $trail->push('Tambah', route('rekening-bank.create'));
});
// Master Data > Rekening Bank > Edit
Breadcrumbs::for('rekening_bank_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('rekening_bank');
    $trail->push('Edit');
});
// Master Data > Satuan Barang
Breadcrumbs::for('satuanbarang', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Satuan Barang', route('satuan-barang.index'));
});

// Master Data > Satuan Barang > Tambah
Breadcrumbs::for('satuanbarang_add', function (BreadcrumbTrail $trail) {
    $trail->parent('satuanbarang');
    $trail->push('Tambah', route('satuan-barang.create'));
});

// Master Data > Satuan Barang > Tambah
Breadcrumbs::for('satuanbarang_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('satuanbarang');
    $trail->push('Edit');
});

// Master Data > Supplier
Breadcrumbs::for('supplier', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Supplier', route('supplier.index'));
});

// Master Data > Supplier > Tambah
Breadcrumbs::for('supplier_add', function (BreadcrumbTrail $trail) {
    $trail->parent('supplier');
    $trail->push('Tambah', route('supplier.create'));
});
// Master Data > Supplier > Edit
Breadcrumbs::for('supplier_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('supplier');
    $trail->push('Edit');
});

// Master Data > Area
Breadcrumbs::for('area', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Area', route('area.index'));
});
// Master Data > Area > Tambah
Breadcrumbs::for('area_add', function (BreadcrumbTrail $trail) {
    $trail->parent('area');
    $trail->push('Tambah', route('area.create'));
});
// Master Data > Area > Edit
Breadcrumbs::for('area_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('area');
    $trail->push('Edit');
});

// Master Data > Pelanggan
Breadcrumbs::for('pelanggan', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Pelanggan', route('pelanggan.index'));
});
// Master Data > Pelanggan > Tambah
Breadcrumbs::for('pelanggan_add', function (BreadcrumbTrail $trail) {
    $trail->parent('pelanggan');
    $trail->push('Tambah', route('pelanggan.create'));
});
// Master Data > Pelanggan > Edit
Breadcrumbs::for('pelanggan_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('pelanggan');
    $trail->push('Edit');
});


// Master Data > Salesman
Breadcrumbs::for('salesman', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Salesman', route('salesman.index'));
});
// Master Data > Salesman > Tambah
Breadcrumbs::for('salesman_add', function (BreadcrumbTrail $trail) {
    $trail->parent('salesman');
    $trail->push('Tambah', route('salesman.create'));
});
// Master Data > Salesman > Edit
Breadcrumbs::for('salesman_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('salesman');
    $trail->push('Edit');
});


// Master Data > Gudang
Breadcrumbs::for('gudang', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Gudang', route('gudang.index'));
});
// Master Data > Gudang > Tambah
Breadcrumbs::for('gudang_add', function (BreadcrumbTrail $trail) {
    $trail->parent('gudang');
    $trail->push('Tambah', route('gudang.create'));
});
// Master Data > Gudang > Edit
Breadcrumbs::for('gudang_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('gudang');
    $trail->push('Edit');
});

// Master Data > Kategori
Breadcrumbs::for('kategori', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('kategori', route('kategori.index'));
});
// Master Data > Kategori > Tambah
Breadcrumbs::for('kategori_add', function (BreadcrumbTrail $trail) {
    $trail->parent('kategori');
    $trail->push('Tambah', route('kategori.create'));
});
// Master Data > Kategori > Edit
Breadcrumbs::for('kategori_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('kategori');
    $trail->push('Edit');
});

// Master Data > Barang
Breadcrumbs::for('barang', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('Barang', route('barang.index'));
});
// Master Data > Barang > Tambah
Breadcrumbs::for('barang_add', function (BreadcrumbTrail $trail) {
    $trail->parent('barang');
    $trail->push('Tambah', route('barang.create'));
});
// Master Data > Barang > Edit
Breadcrumbs::for('barang_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('barang');
    $trail->push('Edit');
});


// Inventory > Adjustment Plus
Breadcrumbs::for('adjustment_plus', function (BreadcrumbTrail $trail) {
    $trail->parent('inventory');
    $trail->push('Adjustment Plus', route('adjustment-plus.index'));
});
// Inventory > Adjustment Plus > Tambah
Breadcrumbs::for('adjustment_plus_add', function (BreadcrumbTrail $trail) {
    $trail->parent('adjustment_plus');
    $trail->push('Tambah', route('adjustment-plus.create'));
});
// Inventory > Adjustment Plus > Edit
Breadcrumbs::for('adjustment_plus_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('adjustment_plus');
    $trail->push('Edit');
});


// Inventory > Adjustment Minus
Breadcrumbs::for('adjustment_minus', function (BreadcrumbTrail $trail) {
    $trail->parent('inventory');
    $trail->push('Adjustment Minus', route('adjustment-minus.index'));
});
// Inventory > Adjustment Minus > Tambah
Breadcrumbs::for('adjustment_minus_add', function (BreadcrumbTrail $trail) {
    $trail->parent('adjustment_minus');
    $trail->push('Tambah', route('adjustment-minus.create'));
});
// Inventory > Adjustment Minus > Edit
Breadcrumbs::for('adjustment_minus_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('adjustment_minus');
    $trail->push('Edit');
});


// Inventory > Perakitan Paket
Breadcrumbs::for('perakitan_paket', function (BreadcrumbTrail $trail) {
    $trail->parent('inventory');
    $trail->push('Perakitan Paket', route('perakitan-paket.index'));
});
// Inventory > Perakitan Paket > Tambah
Breadcrumbs::for('perakitan_paket_add', function (BreadcrumbTrail $trail) {
    $trail->parent('perakitan_paket');
    $trail->push('Tambah', route('perakitan-paket.create'));
});
// Inventory > Perakitan Paket > Edit
Breadcrumbs::for('perakitan_paket_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('perakitan_paket');
    $trail->push('Edit');
});
// Inventory > Pesanan Pembelian > Show
Breadcrumbs::for('perakitan_paket_show', function (BreadcrumbTrail $trail) {
    $trail->parent('perakitan_paket');
    $trail->push('Show');
});



// Beli > Pesanan Pembelian
Breadcrumbs::for('pesanan_pembelian', function (BreadcrumbTrail $trail) {
    $trail->parent('beli');
    $trail->push('Pesanan Pembelian', route('pesanan-pembelian.index'));
});
// Beli > Pesanan Pembelian > Tambah
Breadcrumbs::for('pesanan_pembelian_add', function (BreadcrumbTrail $trail) {
    $trail->parent('pesanan_pembelian');
    $trail->push('Tambah', route('pesanan-pembelian.create'));
});
// Beli > Pesanan Pembelian > Edit
Breadcrumbs::for('pesanan_pembelian_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('pesanan_pembelian');
    $trail->push('Edit');
});
// Beli > Pesanan Pembelian > Show
Breadcrumbs::for('pesanan_pembelian_show', function (BreadcrumbTrail $trail) {
    $trail->parent('pesanan_pembelian');
    $trail->push('Show');
});


// Beli > Pembelian
Breadcrumbs::for('pembelian', function (BreadcrumbTrail $trail) {
    $trail->parent('beli');
    $trail->push('Pembelian', route('pembelian.index'));
});
// Beli > Pembelian > Tambah
Breadcrumbs::for('pembelian_add', function (BreadcrumbTrail $trail) {
    $trail->parent('pembelian');
    $trail->push('Tambah', route('pembelian.create'));
});
// Beli > Pembelian > Edit
Breadcrumbs::for('pembelian_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('pembelian');
    $trail->push('Edit');
});
// Beli > Pembelian > Show
Breadcrumbs::for('pembelian_show', function (BreadcrumbTrail $trail) {
    $trail->parent('pembelian');
    $trail->push('Show');
});


// Beli > Retur
Breadcrumbs::for('retur_pembelian', function (BreadcrumbTrail $trail) {
    $trail->parent('beli');
    $trail->push('Retur', route('retur-pembelian.index'));
});
// Beli > Retur > Tambah
Breadcrumbs::for('retur_pembelian_add', function (BreadcrumbTrail $trail) {
    $trail->parent('retur_pembelian');
    $trail->push('Tambah', route('retur-pembelian.create'));
});
// Beli > Retur > Edit
Breadcrumbs::for('retur_pembelian_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('retur_pembelian');
    $trail->push('Edit');
});
// Beli > Retur > Show
Breadcrumbs::for('retur_pembelian_show', function (BreadcrumbTrail $trail) {
    $trail->parent('retur_pembelian');
    $trail->push('Show');
});


// Master Data > Setting
Breadcrumbs::for('setting', function (BreadcrumbTrail $trail) {
    $trail->push('Setting');
});
// Master Data > Setting > Toko
Breadcrumbs::for('toko', function (BreadcrumbTrail $trail) {
    $trail->parent('setting');
    $trail->push('Toko');
});


// Setting > User
Breadcrumbs::for('user', function (BreadcrumbTrail $trail) {
    $trail->parent('setting');
    $trail->push('User', route('user.index'));
});
// Setting > User > Tambah
Breadcrumbs::for('user_add', function (BreadcrumbTrail $trail) {
    $trail->parent('user');
    $trail->push('Tambah', route('user.create'));
});
// Setting > User > Edit
Breadcrumbs::for('user_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('user');
    $trail->push('Edit');
});
// Setting > Retur > Show
Breadcrumbs::for('user_show', function (BreadcrumbTrail $trail) {
    $trail->parent('user');
    $trail->push('Show');
});



// Master Data > Akun
Breadcrumbs::for('akun', function (BreadcrumbTrail $trail) {
    $trail->push('Akun');
});
// Master Data > Akun > Profile
Breadcrumbs::for('profile', function (BreadcrumbTrail $trail) {
    $trail->parent('akun');
    $trail->push('Profile');
});


// Jual > Penjualan
Breadcrumbs::for('penjualan', function (BreadcrumbTrail $trail) {
    $trail->parent('jual');
    $trail->push('Penjualan', route('penjualan.index'));
});
// Jual > Penjualan > Tambah
Breadcrumbs::for('penjualan_add', function (BreadcrumbTrail $trail) {
    $trail->parent('penjualan');
    $trail->push('Tambah', route('penjualan.create'));
});
// Jual > Penjualan > Edit
Breadcrumbs::for('penjualan_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('penjualan');
    $trail->push('Edit');
});
// Jual > Penjualan > Show
Breadcrumbs::for('penjualan_show', function (BreadcrumbTrail $trail) {
    $trail->parent('penjualan');
    $trail->push('Show');
});

// Jual > Pesanan Penjualan
Breadcrumbs::for('pesanan_penjualan', function (BreadcrumbTrail $trail) {
    $trail->parent('jual');
    $trail->push('Pesanan Penjualan', route('pesanan-penjualan.index'));
});
// Jual > Pesanan Penjualan > Tambah
Breadcrumbs::for('pesanan_penjualan_add', function (BreadcrumbTrail $trail) {
    $trail->parent('pesanan_penjualan');
    $trail->push('Tambah', route('pesanan-penjualan.create'));
});
// Jual > Pesanan Penjualan > Edit
Breadcrumbs::for('pesanan_penjualan_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('pesanan_penjualan');
    $trail->push('Edit');
});
// Jual > Pesanan Penjualan > Show
Breadcrumbs::for('pesanan_penjualan_show', function (BreadcrumbTrail $trail) {
    $trail->parent('pesanan_penjualan');
    $trail->push('Show');
});



// Jual > Retur Penjualan
Breadcrumbs::for('retur_penjualan', function (BreadcrumbTrail $trail) {
    $trail->parent('jual');
    $trail->push('Retur Penjualan', route('retur-penjualan.index'));
});
// Jual > Retur Penjualan > Tambah
Breadcrumbs::for('retur_penjualan_add', function (BreadcrumbTrail $trail) {
    $trail->parent('retur_penjualan');
    $trail->push('Tambah', route('retur-penjualan.create'));
});
// Jual > Retur Penjualan > Edit
Breadcrumbs::for('retur_penjualan_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('retur_penjualan');
    $trail->push('Edit');
});
// Jual > Retur Penjualan > Show
Breadcrumbs::for('retur_penjualan_show', function (BreadcrumbTrail $trail) {
    $trail->parent('retur_penjualan');
    $trail->push('Show');
});


// Master Data > Retur Penjualan
Breadcrumbs::for('direct_sales_add', function (BreadcrumbTrail $trail) {
    $trail->parent('master');
    $trail->push('POS Terminal', route('direct-penjualan.create'));
});


// Keuangan > Pelunasan Hutang
Breadcrumbs::for('pelunasan_hutang', function (BreadcrumbTrail $trail) {
    $trail->parent('keuangan');
    $trail->push('Pelunasan Hutang', route('pelunasan-hutang.index'));
});
// Keuangan > Pelunasan Hutang > Tambah
Breadcrumbs::for('pelunasan_hutang_add', function (BreadcrumbTrail $trail) {
    $trail->parent('pelunasan_hutang');
    $trail->push('Tambah', route('pelunasan-hutang.create'));
});
// Keuangan > Pelunasan Hutang > Edit
Breadcrumbs::for('pelunasan_hutang_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('pelunasan_hutang');
    $trail->push('Edit');
});
// Keuangan > Pelunasan Hutang > Show
Breadcrumbs::for('pelunasan_hutang_show', function (BreadcrumbTrail $trail) {
    $trail->parent('pelunasan_hutang');
    $trail->push('Show');
});


// Keuangan > Pelunasan Piutang
Breadcrumbs::for('pelunasan_piutang', function (BreadcrumbTrail $trail) {
    $trail->parent('keuangan');
    $trail->push('Pelunasan Piutang', route('pelunasan-piutang.index'));
});
// Keuangan > Pelunasan Piutang > Tambah
Breadcrumbs::for('pelunasan_piutang_add', function (BreadcrumbTrail $trail) {
    $trail->parent('pelunasan_piutang');
    $trail->push('Tambah', route('pelunasan-piutang.create'));
});
// Keuangan > Pelunasan Piutang > Edit
Breadcrumbs::for('pelunasan_piutang_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('pelunasan_piutang');
    $trail->push('Edit');
});
// Keuangan > Pelunasan Piutang > Show
Breadcrumbs::for('pelunasan_piutang_show', function (BreadcrumbTrail $trail) {
    $trail->parent('pelunasan_piutang');
    $trail->push('Show');
});


// Keuangan > Cek-Giro Cair
Breadcrumbs::for('cek_giro_cair', function (BreadcrumbTrail $trail) {
    $trail->parent('keuangan');
    $trail->push('Cek-Giro Cair', route('cek-giro-cair.index'));
});
// Keuangan > Cek-Giro Cair > Tambah
Breadcrumbs::for('cek_giro_cair_add', function (BreadcrumbTrail $trail) {
    $trail->parent('cek_giro_cair');
    $trail->push('Tambah', route('cek-giro-cair.create'));
});
// Keuangan > Cek-Giro Cair > Edit
Breadcrumbs::for('cek_giro_cair_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('cek_giro_cair');
    $trail->push('Edit');
});
// Keuangan > Cek-Giro Cair > Show
Breadcrumbs::for('cek_giro_cair_show', function (BreadcrumbTrail $trail) {
    $trail->parent('cek_giro_cair');
    $trail->push('Show');
});


// Keuangan > Cek-Giro Tolak
Breadcrumbs::for('cek_giro_tolak', function (BreadcrumbTrail $trail) {
    $trail->parent('keuangan');
    $trail->push('Cek-Giro Tolak', route('cek-giro-tolak.index'));
});
// Keuangan > Cek-Giro Tolak > Tambah
Breadcrumbs::for('cek_giro_tolak_add', function (BreadcrumbTrail $trail) {
    $trail->parent('cek_giro_tolak');
    $trail->push('Tambah', route('cek-giro-tolak.create'));
});
// Keuangan > Cek-Giro Tolak > Edit
Breadcrumbs::for('cek_giro_tolak_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('cek_giro_tolak');
    $trail->push('Edit');
});
// Keuangan > Cek-Giro Tolak > Show
Breadcrumbs::for('cek_giro_tolak_show', function (BreadcrumbTrail $trail) {
    $trail->parent('cek_giro_tolak');
    $trail->push('Show');
});


// Keuangan > Biaya
Breadcrumbs::for('biaya', function (BreadcrumbTrail $trail) {
    $trail->parent('keuangan');
    $trail->push('Biaya', route('biaya.index'));
});
// Keuangan > Biaya > Tambah
Breadcrumbs::for('biaya_add', function (BreadcrumbTrail $trail) {
    $trail->parent('biaya');
    $trail->push('Tambah', route('biaya.create'));
});
// Keuangan > Biaya > Edit
Breadcrumbs::for('biaya_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('biaya');
    $trail->push('Edit');
});
// Keuangan > Biaya > Show
Breadcrumbs::for('biaya_show', function (BreadcrumbTrail $trail) {
    $trail->parent('biaya');
    $trail->push('Show');
});

// Laporan
// Laporan > Adjustment Plus
Breadcrumbs::for('laporan_adjustment_plus', function (BreadcrumbTrail $trail) {
    $trail->parent('laporan');
    $trail->push('Adjustment Plus', route('adjustment-plus.laporan'));
});

// Laporan > Adjustment Minus
Breadcrumbs::for('laporan_adjustment_minus', function (BreadcrumbTrail $trail) {
    $trail->parent('laporan');
    $trail->push('Adjustment Minus', route('adjustment-minus.laporan'));
});

// Laporan > Pesanan Pembelian
Breadcrumbs::for('laporan_pesanan_pembelian', function (BreadcrumbTrail $trail) {
    $trail->parent('laporan');
    $trail->push('Pesanan Pembelian', route('pesanan-pembelian.laporan'));
});

// Laporan > Pembelian
Breadcrumbs::for('laporan_pembelian', function (BreadcrumbTrail $trail) {
    $trail->parent('laporan');
    $trail->push('Pembelian', route('pembelian.laporan'));
});

// Laporan > Retur Pembelian
Breadcrumbs::for('laporan_retur_pembelian', function (BreadcrumbTrail $trail) {
    $trail->parent('laporan');
    $trail->push('Retur Pembelian', route('retur-pembelian.laporan'));
});

// Laporan > Penjualan
Breadcrumbs::for('laporan_penjualan', function (BreadcrumbTrail $trail) {
    $trail->parent('laporan');
    $trail->push('Penjualan', route('penjualan.laporan'));
});

// Laporan > Pesanan Penjualan
Breadcrumbs::for('laporan_pesanan_penjualan', function (BreadcrumbTrail $trail) {
    $trail->parent('laporan');
    $trail->push('Pesanan Penjualan', route('pesanan-penjualan.laporan'));
});


// Laporan > Retur Penjualan
Breadcrumbs::for('laporan_retur_penjualan', function (BreadcrumbTrail $trail) {
    $trail->parent('laporan');
    $trail->push('Retur Penjualan', route('retur-penjualan.laporan'));
});

// Laporan > Pelunasan Hutang
Breadcrumbs::for('laporan_pelunasan_hutang', function (BreadcrumbTrail $trail) {
    $trail->parent('laporan');
    $trail->push('Pelunasan Hutang', route('pelunasan-hutang.laporan'));
});

// Laporan > Pelunasan Piutang
Breadcrumbs::for('laporan_pelunasan_piutang', function (BreadcrumbTrail $trail) {
    $trail->parent('laporan');
    $trail->push('Pelunasan Piutang', route('pelunasan-piutang.laporan'));
});

// Laporan > Biaya
Breadcrumbs::for('laporan_biaya', function (BreadcrumbTrail $trail) {
    $trail->parent('laporan');
    $trail->push('Biaya', route('biaya.laporan'));
});

// Laporan > Saldo Hutang
Breadcrumbs::for('laporan_saldo_hutang', function (BreadcrumbTrail $trail) {
    $trail->parent('laporan');
    $trail->push('Saldo Hutang', route('saldo-hutang.laporan'));
});

// Laporan > Saldo Piutang
Breadcrumbs::for('laporan_saldo_piutang', function (BreadcrumbTrail $trail) {
    $trail->parent('laporan');
    $trail->push('Saldo Piutang', route('saldo-piutang.laporan'));
});



// Laporan > Komisi Salesman
Breadcrumbs::for('laporan_komisi_salesman', function (BreadcrumbTrail $trail) {
    $trail->parent('laporan');
    $trail->push('Komisi Salesman', route('komisi-salesman.laporan'));
});

// Laporan > Cek-Giro
Breadcrumbs::for('laporan_cek_giro', function (BreadcrumbTrail $trail) {
    $trail->parent('laporan');
    $trail->push('Cek-Giro', route('cek-giro.laporan'));
});

// Laporan > Gross Profit
Breadcrumbs::for('laporan_gross_profit', function (BreadcrumbTrail $trail) {
    $trail->parent('laporan');
    $trail->push('Gross Profit', route('gross-profit.laporan'));
});

// Laporan > Stok Barang
Breadcrumbs::for('laporan_stok_barang', function (BreadcrumbTrail $trail) {
    $trail->parent('laporan');
    $trail->push('Stok Barang', route('stok-barang.laporan'));
});

// Laporan > Nett Profit
Breadcrumbs::for('laporan_nett_profit', function (BreadcrumbTrail $trail) {
    $trail->parent('laporan');
    $trail->push('Nett Profit', route('nett-profit.laporan'));
});
