<div id="sidebar" class="sidebar">
    <div data-scrollbar="true" data-height="100%">
        <ul class="nav">
            <li class="nav-profile">
                <div class="image">
                    <a href="javascript:;">
                        @if (auth()->user()->foto != null)
                            <img src="{{ asset('storage/img/foto/' . auth()->user()->foto) }}" alt="Avatar"
                                class="img-fluid rounded" style="width: 40px; height: 40px; object-fit: cover;">
                        @else
                            <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim(auth()->user()->email))) }}&s=40"
                                alt="Avatar" class="img-fluid rounded"
                                style="width: 40px; height: 40px; object-fit: cover;">
                        @endif
                    </a>
                </div>
                <div class="info">
                    {{ Auth::user()->name }}
                    <small>{{ Auth::user()->email }}</small>
                </div>
            </li>
        </ul>
        <ul class="nav">
            <li class="nav-header">Navigation</li>
            {{-- menu dashboard --}}
            @role('admin')
                <li class="{{ set_active('dashboard.index') }}">
                    <a href="{{ route('dashboard.index') }}">
                        <i class="fa fa-laptop"></i>
                        <span>{{ trans('dashboard.link.dashboard') }}</span>
                    </a>
                </li>

                {{-- menu master data --}}
                <li class="has-sub{{ request()->is('masterdata*') ? ' active' : '' }}">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="fa fa-list"></i>
                        <span>{{ trans('dashboard.menu.master') }}</span>
                    </a>
                    <ul class="sub-menu" style="display: none;">
                        <li class="{{ set_active('matauang*') }}">
                            <a href="{{ route('matauang.index') }}">
                                {{ trans('dashboard.menu.matauang') }}
                            </a>
                        </li>
                        <li class="{{ set_active('rate-matauang*') }}">
                            <a href="{{ route('rate-matauang.index') }}">
                                {{ trans('dashboard.menu.rate_matauang') }}
                            </a>
                        </li>

                        <li class="{{ set_active('bank*') }}">
                            <a href="{{ route('bank.index') }}">
                                {{ trans('dashboard.menu.bank') }}
                            </a>
                        </li>

                        <li class="{{ set_active('rekening-bank*') }}">
                            <a href="{{ route('rekening-bank.index') }}">
                                {{ trans('dashboard.menu.rekening_bank') }}
                            </a>
                        </li>

                        <li class="{{ set_active('supplier*') }}">
                            <a href="{{ route('supplier.index') }}">
                                {{ trans('dashboard.menu.supplier') }}
                            </a>
                        </li>

                        <li class="{{ set_active('area*') }}">
                            <a href="{{ route('area.index') }}">
                                {{ trans('dashboard.menu.area') }}
                            </a>
                        </li>

                        <li class="{{ set_active('satuan-barang*') }}">
                            <a
                                href="{{ route('satuan-barang.index') }}">{{ trans('dashboard.menu.satuan_barang') }}</a>
                        </li>

                        <li class="{{ set_active('pelanggan*') }}">
                            <a href="{{ route('pelanggan.index') }}">
                                {{ trans('dashboard.menu.pelanggan') }}
                            </a>
                        </li>

                        <li class="{{ set_active('salesman*') }}">
                            <a href="{{ route('salesman.index') }}">
                                {{ trans('dashboard.menu.salesman') }}
                            </a>
                        </li>

                        <li class="{{ set_active('gudang*') }}">
                            <a href="{{ route('gudang.index') }}">
                                {{ trans('dashboard.menu.gudang') }}
                            </a>
                        </li>

                        <li class="{{ set_active('kategori*') }}">
                            <a href="{{ route('kategori.index') }}">
                                {{ trans('dashboard.menu.kategori') }}
                            </a>
                        </li>

                        <li class="{{ set_active('barang*') }}">
                            <a href="{{ route('barang.index') }}">
                                {{ trans('dashboard.menu.barang') }}
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- menu inventory --}}
                <li class="has-sub{{ request()->is('inventory*') ? ' active' : '' }}">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="fa fa-archive"></i>
                        <span>{{ trans('dashboard.menu.inventory') }}</span>
                    </a>
                    <ul class="sub-menu" style="display: none;">
                        <li class="{{ set_active('adjustment-plus*') }}">
                            <a href="{{ route('adjustment-plus.index') }}">
                                {{ trans('dashboard.menu.adjustment_plus') }}
                            </a>
                        </li>

                        <li class="{{ set_active('adjustment-minus*') }}">
                            <a href="{{ route('adjustment-minus.index') }}">
                                {{ trans('dashboard.menu.adjustment_minus') }}
                            </a>
                        </li>

                        <li class="{{ set_active('perakitan-paket*') }}">
                            <a href="{{ route('perakitan-paket.index') }}">
                                {{ trans('dashboard.menu.perakitan_paket') }}
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- menu pembelian --}}
                <li class="has-sub{{ request()->is('beli*') ? ' active' : '' }}">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="fa fa-briefcase"></i>
                        <span>{{ trans('dashboard.menu.pembelian') }}</span>
                    </a>
                    <ul class="sub-menu" style="display: none;">
                        <li class="{{ set_active('pesanan-pembelian*') }}">
                            <a href="{{ route('pesanan-pembelian.index') }}">
                                {{ trans('dashboard.menu.pesanan_pembelian') }}
                            </a>
                        </li>

                        <li class="{{ request()->is('beli/pembelian*') ? ' active' : '' }}">
                            <a href="{{ route('pembelian.index') }}">
                                {{ trans('dashboard.menu.pembelian') }}
                            </a>
                        </li>

                        <li class="{{ set_active('retur-pembelian*') }}">
                            <a href="{{ route('retur-pembelian.index') }}">
                                {{ trans('dashboard.menu.retur_pembelian') }}
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- menu penjualan --}}
                <li class="has-sub{{ request()->is('jual*') ? ' active' : '' }}">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="fa fa-shopping-cart"></i>
                        <span>{{ trans('dashboard.menu.penjualan') }}</span>
                    </a>
                    <ul class="sub-menu" style="display: none;">
                        <li class="{{ set_active('pesanan-penjualan*') }}">
                            <a href="{{ route('pesanan-penjualan.index') }}">
                                {{ trans('dashboard.menu.pesanan_penjualan') }}
                            </a>
                        </li>

                        <li class="{{ request()->is('jual/penjualan*') ? ' active' : '' }}">
                            <a href="{{ route('penjualan.index') }}">
                                {{ trans('dashboard.menu.penjualan') }}
                            </a>
                        </li>

                        <li class="{{ set_active('retur-penjualan*') }}">
                            <a href="{{ route('retur-penjualan.index') }}">
                                {{ trans('dashboard.menu.retur_penjualan') }}
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- menu keuangan --}}
                <li class="has-sub{{ request()->is('keuangan*') ? ' active' : '' }}">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="fa fa-money"></i>
                        <span>{{ trans('dashboard.menu.keuangan') }}</span>
                    </a>
                    <ul class="sub-menu" style="display: none;">
                        <li class="{{ set_active('pelunasan-hutang*') }}">
                            <a href="{{ route('pelunasan-hutang.index') }}">
                                {{ trans('dashboard.menu.pelunasan_hutang') }}
                            </a>
                        </li>

                        <li class="{{ set_active('pelunasan-piutang*') }}">
                            <a href="{{ route('pelunasan-piutang.index') }}">
                                {{ trans('dashboard.menu.pelunasan_piutang') }}
                            </a>
                        </li>

                        <li class="{{ set_active('cek-giro-cair*') }}">
                            <a href="{{ route('cek-giro-cair.index') }}">
                                {{ trans('dashboard.menu.cek_giro_cair') }}
                            </a>
                        </li>

                        <li class="{{ set_active('cek-giro-tolak*') }}">
                            <a href="{{ route('cek-giro-tolak.index') }}">
                                {{ trans('dashboard.menu.cek_giro_tolak') }}
                            </a>
                        </li>

                        <li class="{{ set_active('biaya*') }}">
                            <a href="{{ route('biaya.index') }}">
                                {{ trans('dashboard.menu.biaya') }}
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- menu Laporan --}}
                <li class="has-sub{{ request()->is('laporan*') ? ' active' : '' }}">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="fa fa-book"></i>
                        <span>{{ trans('dashboard.menu.laporan') }}</span>
                    </a>
                    <ul class="sub-menu" style="display: none;">
                        <li class="{{ set_active('adjustment-plus.laporan*') }}">
                            <a href="{{ route('adjustment-plus.laporan') }}">
                                {{ trans('dashboard.laporan.adjustment_plus') }}
                            </a>
                        </li>

                        <li class="{{ set_active('adjustment-minus.laporan*') }}">
                            <a href="{{ route('adjustment-minus.laporan') }}">
                                {{ trans('dashboard.laporan.adjustment_minus') }}
                            </a>
                        </li>

                        <li class="{{ set_active('pesanan-pembelian.laporan*') }}">
                            <a href="{{ route('pesanan-pembelian.laporan') }}">
                                {{ trans('dashboard.laporan.pesanan_pembelian') }}
                            </a>
                        </li>

                        <li class="{{ set_active('pembelian.laporan') }}">
                            <a href="{{ route('pembelian.laporan') }}">
                                {{ trans('dashboard.laporan.pembelian') }}
                            </a>
                        </li>

                        <li class="{{ set_active('retur-pembelian.laporan') }}">
                            <a href="{{ route('retur-pembelian.laporan') }}">
                                {{ trans('dashboard.laporan.retur_pembelian') }}
                            </a>
                        </li>

                        <li class="{{ set_active('pesanan-penjualan.laporan') }}">
                            <a href="{{ route('pesanan-penjualan.laporan') }}">
                                {{ trans('dashboard.laporan.pesanan_penjualan') }}
                            </a>
                        </li>

                        <li class="{{ set_active('penjualan.laporan') }}">
                            <a href="{{ route('penjualan.laporan') }}">
                                {{ trans('dashboard.laporan.penjualan') }}
                            </a>
                        </li>

                        <li class="{{ set_active('retur-penjualan.laporan') }}">
                            <a href="{{ route('retur-penjualan.laporan') }}">
                                {{ trans('dashboard.laporan.retur_penjualan') }}
                            </a>
                        </li>

                        <li class="{{ set_active('pelunasan-hutang.laporan') }}">
                            <a href="{{ route('pelunasan-hutang.laporan') }}">
                                {{ trans('dashboard.laporan.pelunasan_hutang') }}
                            </a>
                        </li>

                        <li class="{{ set_active('pelunasan-piutang.laporan') }}">
                            <a href="{{ route('pelunasan-piutang.laporan') }}">
                                {{ trans('dashboard.laporan.pelunasan_piutang') }}
                            </a>
                        </li>

                        <li class="{{ set_active('biaya.laporan') }}">
                            <a href="{{ route('biaya.laporan') }}">
                                {{ trans('dashboard.laporan.biaya') }}
                            </a>
                        </li>

                        <li class="{{ set_active('saldo-hutang.laporan') }}">
                            <a href="{{ route('saldo-hutang.laporan') }}">
                                {{ trans('dashboard.laporan.saldo_hutang') }}
                            </a>
                        </li>

                        <li class="{{ set_active('saldo-piutang.laporan') }}">
                            <a href="{{ route('saldo-piutang.laporan') }}">
                                {{ trans('dashboard.laporan.saldo_piutang') }}
                            </a>
                        </li>

                        <li class="{{ set_active('stok-barang*') }}">
                            <a href="{{ route('stok-barang.laporan') }}">
                                {{ trans('dashboard.laporan.stok_barang') }}
                            </a>
                        </li>

                        <li class="{{ set_active('komisi-salesman*') }}">
                            <a href="{{ route('komisi-salesman.laporan') }}">
                                {{ trans('dashboard.laporan.komisi_salesman') }}
                            </a>
                        </li>

                        <li class="{{ set_active('cek-giro*') }}">
                            <a href="{{ route('cek-giro.laporan') }}">
                                {{ trans('dashboard.laporan.cek_giro') }}
                            </a>
                        </li>

                        <li class="{{ set_active('gross-profit*') }}">
                            <a href="{{ route('gross-profit.laporan') }}">
                                {{ trans('dashboard.laporan.gross_profit') }}
                            </a>
                        </li>

                        <li class="{{ set_active('nett-profit*') }}">
                            <a href="{{ route('nett-profit.laporan') }}">
                                {{ trans('dashboard.laporan.nett_profit') }}
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- menu Setting --}}
                <li class="has-sub{{ request()->is('setting*') ? ' active' : '' }}">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="fa fa-gear"></i>
                        <span>{{ trans('dashboard.menu.setting') }}</span>
                    </a>
                    <ul class="sub-menu" style="display: none;">
                        <li class="{{ set_active('toko*') }}">
                            <a href="{{ route('toko.index') }}">
                                {{ trans('dashboard.menu.toko') }}
                            </a>
                        </li>

                        <li class="{{ set_active('user*') }}">
                            <a href="{{ route('user.index') }}">
                                {{ trans('dashboard.menu.user') }}
                            </a>
                        </li>
                    </ul>
                </li>
            @endrole

            @role('salesman')
                <li
                    class="has-sub
                {{ request()->is('jual*') ? ' active' : '' }}
                {{ request()->is('laporan*') ? ' active' : '' }}
                ">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="fa fa-cart-plus"></i>
                        <span> {{ trans('dashboard.menu.penjualan') }}</span>
                    </a>
                    <ul class="sub-menu" style="display: none;">
                        <li class="{{ set_active('direct-penjuala*') }}">
                            <a href="{{ route('direct-penjualan.create') }}">
                                {{ trans('dashboard.menu.direct_sales') }}
                            </a>
                        </li>

                        <li class="{{ set_active('komisi-salesman.laporan*') }}">
                            <a href="{{ route('komisi-salesman.laporan') }}">
                                {{ trans('dashboard.laporan.komisi_salesman') }}
                            </a>
                        </li>

                        <li class="{{ set_active('penjualan.laporan*') }}">
                            <a href="{{ route('penjualan.laporan') }}">
                                {{ trans('dashboard.laporan.penjualan') }}
                            </a>
                        </li>

                    </ul>
                </li>
            @endrole

            {{-- menu Akun --}}
            <li class="has-sub{{ request()->is('akun*') ? ' active' : '' }}">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-user"></i>
                    <span>{{ trans('dashboard.menu.akun') }}</span>
                </a>
                <ul class="sub-menu" style="display: none;">
                    <li class="{{ set_active('profile*') }}">
                        <a href="{{ route('profile.index') }}">
                            {{ trans('dashboard.menu.profile') }}
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form-sidebar').submit();">
                            Logout
                        </a>

                        <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST"
                            class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify">
                    <i class="fa fa-angle-double-left"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="sidebar-bg"></div>
