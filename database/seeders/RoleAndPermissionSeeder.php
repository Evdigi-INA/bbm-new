<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'salesman']);


        // Master data
        Permission::create(['name' => 'create mata uang']);
        Permission::create(['name' => 'read mata uang']);
        Permission::create(['name' => 'edit mata uang']);
        Permission::create(['name' => 'update mata uang']);
        Permission::create(['name' => 'delete mata uang']);

        Permission::create(['name' => 'create rate mata uang']);
        Permission::create(['name' => 'read rate mata uang']);
        Permission::create(['name' => 'edit rate mata uang']);
        Permission::create(['name' => 'update rate mata uang']);
        Permission::create(['name' => 'delete rate mata uang']);

        Permission::create(['name' => 'create bank']);
        Permission::create(['name' => 'read bank']);
        Permission::create(['name' => 'edit bank']);
        Permission::create(['name' => 'update bank']);
        Permission::create(['name' => 'delete bank']);

        Permission::create(['name' => 'create rekening']);
        Permission::create(['name' => 'read rekening']);
        Permission::create(['name' => 'edit rekening']);
        Permission::create(['name' => 'update rekening']);
        Permission::create(['name' => 'delete rekening']);

        Permission::create(['name' => 'create supplier']);
        Permission::create(['name' => 'read supplier']);
        Permission::create(['name' => 'edit supplier']);
        Permission::create(['name' => 'update supplier']);
        Permission::create(['name' => 'delete supplier']);

        Permission::create(['name' => 'create area']);
        Permission::create(['name' => 'read area']);
        Permission::create(['name' => 'edit area']);
        Permission::create(['name' => 'update area']);
        Permission::create(['name' => 'delete area']);

        Permission::create(['name' => 'create pelanggan']);
        Permission::create(['name' => 'read pelanggan']);
        Permission::create(['name' => 'edit pelanggan']);
        Permission::create(['name' => 'update pelanggan']);
        Permission::create(['name' => 'delete pelanggan']);

        Permission::create(['name' => 'create salesman']);
        Permission::create(['name' => 'read salesman']);
        Permission::create(['name' => 'edit salesman']);
        Permission::create(['name' => 'update salesman']);
        Permission::create(['name' => 'delete salesman']);

        Permission::create(['name' => 'create gudang']);
        Permission::create(['name' => 'read gudang']);
        Permission::create(['name' => 'edit gudang']);
        Permission::create(['name' => 'update gudang']);
        Permission::create(['name' => 'delete gudang']);

        Permission::create(['name' => 'create kategori']);
        Permission::create(['name' => 'read kategori']);
        Permission::create(['name' => 'edit kategori']);
        Permission::create(['name' => 'update kategori']);
        Permission::create(['name' => 'delete kategori']);

        Permission::create(['name' => 'create barang']);
        Permission::create(['name' => 'read barang']);
        Permission::create(['name' => 'edit barang']);
        Permission::create(['name' => 'update barang']);
        Permission::create(['name' => 'delete barang']);

        Permission::create(['name' => 'create satuan']);
        Permission::create(['name' => 'read satuan']);
        Permission::create(['name' => 'edit satuan']);
        Permission::create(['name' => 'update satuan']);
        Permission::create(['name' => 'delete satuan']);


        // Inventory
        Permission::create(['name' => 'create adjustment plus']);
        Permission::create(['name' => 'read adjustment plus']);
        Permission::create(['name' => 'detail adjustment plus']);
        Permission::create(['name' => 'edit adjustment plus']);
        Permission::create(['name' => 'update adjustment plus']);
        Permission::create(['name' => 'delete adjustment plus']);

        Permission::create(['name' => 'create adjustment minus']);
        Permission::create(['name' => 'read adjustment minus']);
        Permission::create(['name' => 'detail adjustment minus']);
        Permission::create(['name' => 'edit adjustment minus']);
        Permission::create(['name' => 'update adjustment minus']);
        Permission::create(['name' => 'delete adjustment minus']);

        Permission::create(['name' => 'create perakitan paket']);
        Permission::create(['name' => 'read perakitan paket']);
        Permission::create(['name' => 'detail perakitan paket']);
        Permission::create(['name' => 'edit perakitan paket']);
        Permission::create(['name' => 'update perakitan paket']);
        Permission::create(['name' => 'delete perakitan paket']);


        // Pembelian
        Permission::create(['name' => 'create pesanan pembelian']);
        Permission::create(['name' => 'read pesanan pembelian']);
        Permission::create(['name' => 'detail pesanan pembelian']);
        Permission::create(['name' => 'edit pesanan pembelian']);
        Permission::create(['name' => 'update pesanan pembelian']);
        Permission::create(['name' => 'delete pesanan pembelian']);

        Permission::create(['name' => 'create pembelian']);
        Permission::create(['name' => 'read pembelian']);
        Permission::create(['name' => 'detail pembelian']);
        Permission::create(['name' => 'edit pembelian']);
        Permission::create(['name' => 'update pembelian']);
        Permission::create(['name' => 'delete pembelian']);

        Permission::create(['name' => 'create retur pembelian']);
        Permission::create(['name' => 'read retur pembelian']);
        Permission::create(['name' => 'detail retur pembelian']);
        Permission::create(['name' => 'edit retur pembelian']);
        Permission::create(['name' => 'update retur pembelian']);
        Permission::create(['name' => 'delete retur pembelian']);


        // Penjualan
        Permission::create(['name' => 'create pesanan penjualan']);
        Permission::create(['name' => 'read pesanan penjualan']);
        Permission::create(['name' => 'detail pesanan penjualan']);
        Permission::create(['name' => 'edit pesanan penjualan']);
        Permission::create(['name' => 'update pesanan penjualan']);
        Permission::create(['name' => 'delete pesanan penjualan']);

        Permission::create(['name' => 'create direct penjualan']);

        Permission::create(['name' => 'create penjualan']);
        Permission::create(['name' => 'read penjualan']);
        Permission::create(['name' => 'detail penjualan']);
        Permission::create(['name' => 'edit penjualan']);
        Permission::create(['name' => 'update penjualan']);
        Permission::create(['name' => 'delete penjualan']);

        Permission::create(['name' => 'create retur penjualan']);
        Permission::create(['name' => 'read retur penjualan']);
        Permission::create(['name' => 'detail retur penjualan']);
        Permission::create(['name' => 'edit retur penjualan']);
        Permission::create(['name' => 'update retur penjualan']);
        Permission::create(['name' => 'delete retur penjualan']);


        // Keuangan
        Permission::create(['name' => 'create pelunasan hutang']);
        Permission::create(['name' => 'read pelunasan hutang']);
        Permission::create(['name' => 'detail pelunasan hutang']);
        Permission::create(['name' => 'edit pelunasan hutang']);
        Permission::create(['name' => 'update pelunasan hutang']);
        Permission::create(['name' => 'delete pelunasan hutang']);

        Permission::create(['name' => 'create pelunasan piutang']);
        Permission::create(['name' => 'read pelunasan piutang']);
        Permission::create(['name' => 'detail pelunasan piutang']);
        Permission::create(['name' => 'edit pelunasan piutang']);
        Permission::create(['name' => 'update pelunasan piutang']);
        Permission::create(['name' => 'delete pelunasan piutang']);

        Permission::create(['name' => 'create cek/giro cair']);
        Permission::create(['name' => 'read cek/giro cair']);
        Permission::create(['name' => 'detail cek/giro cair']);
        Permission::create(['name' => 'edit cek/giro cair']);
        Permission::create(['name' => 'update cek/giro cair']);
        Permission::create(['name' => 'delete cek/giro cair']);

        Permission::create(['name' => 'create cek/giro tolak']);
        Permission::create(['name' => 'read cek/giro tolak']);
        Permission::create(['name' => 'detail cek/giro tolak']);
        Permission::create(['name' => 'edit cek/giro tolak']);
        Permission::create(['name' => 'update cek/giro tolak']);
        Permission::create(['name' => 'delete cek/giro tolak']);

        Permission::create(['name' => 'create biaya']);
        Permission::create(['name' => 'read biaya']);
        Permission::create(['name' => 'detail biaya']);
        Permission::create(['name' => 'edit biaya']);
        Permission::create(['name' => 'update biaya']);
        Permission::create(['name' => 'delete biaya']);


        // Laporan
        Permission::create(['name' => 'laporan adjustment plus']);
        Permission::create(['name' => 'laporan adjustment minus']);
        Permission::create(['name' => 'laporan pesanan pembelian']);
        Permission::create(['name' => 'laporan pembelian']);
        Permission::create(['name' => 'laporan retur pembelian']);
        Permission::create(['name' => 'laporan pesanan penjualan']);
        Permission::create(['name' => 'laporan penjualan']);
        Permission::create(['name' => 'laporan retur penjualan']);
        Permission::create(['name' => 'laporan pelunasan hutang']);
        Permission::create(['name' => 'laporan pelunasan piutang']);
        Permission::create(['name' => 'laporan saldo hutang']);
        Permission::create(['name' => 'laporan saldo piutang']);
        Permission::create(['name' => 'laporan biaya']);
        Permission::create(['name' => 'laporan stok barang']);
        Permission::create(['name' => 'laporan komisi salesman']);
        Permission::create(['name' => 'laporan cek/giro']);
        Permission::create(['name' => 'laporan gross profit']);
        Permission::create(['name' => 'laporan nett profit']);

        // Setting
        Permission::create(['name' => 'toko']);

        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'read user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'delete user']);


        // User
        $userAdmin = User::first();
        $userAdmin->assignRole('admin');
        $userAdmin->givePermissionTo(Permission::all());
        $userAdmin->revokePermissionTo('create direct penjualan');

        $userSales = User::find(2);
        $userSales->assignRole('salesman');
        $userSales->givePermissionTo([
            'create direct penjualan',
            'laporan komisi salesman',
            'laporan penjualan'
        ]);
    }
}
