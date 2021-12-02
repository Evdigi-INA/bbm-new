@extends('layouts.dashboard')

@section('title', trans('dashboard.laporan.retur_pembelian'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('laporan_retur_pembelian') }}
        <!-- begin row -->
        <div class="row">
            <!-- begin col-12 -->
            <div class="col-md-12">
                <!-- begin panel -->
                <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
                                data-click="panel-expand">
                                <i class="fa fa-expand"></i>
                            </a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success"
                                data-click="panel-reload"><i class="fa fa-repeat"></i>
                            </a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning"
                                data-click="panel-collapse">
                                <i class="fa fa-minus"></i>
                            </a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger"
                                data-click="panel-remove">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                        <h4 class="panel-title">{{ trans('dashboard.laporan.retur_pembelian') }}</h4>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('retur-pembelian.laporan') }}" method="GET" style="margin-bottom: 1em;">
                            <div class="form-group row" style="margin-bottom: 1em;">
                                <div class="col-md-6">
                                    <label for="dari_tanggal" class="control-label">Dari Tanggal</label>
                                    <input type="date" name="dari_tanggal" class="form-control" id="dari_tanggal"
                                        value="{{ request()->query('dari_tanggal') ? request()->query('dari_tanggal') : date('Y-m-d') }}"
                                        required />
                                </div>

                                <div class="col-md-6">
                                    <label for="sampai_tanggal" class="control-label">Sampai Tanggal</label>
                                    <input type="date" name="sampai_tanggal" class="form-control" id="sampai_tanggal"
                                        value="{{ request()->query('sampai_tanggal') ? request()->query('sampai_tanggal') : date('Y-m-d') }}"
                                        required />
                                </div>
                            </div>

                            <div class="form-group row" style="margin-bottom: 1em;">
                                <div class="col-md-6">
                                    <label for="gudang" class="control-label">Gudang</label>
                                    <select name="gudang" class="form-control" id="gudang">
                                        <option value="" selected>All</option>
                                        @forelse ($gudang as $item)
                                            <option value="{{ $item->id }}"
                                                {{ request()->query('gudang') && request()->query('gudang') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}
                                            </option>
                                        @empty
                                            <option value="" selected disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="supplier" class="control-label">Supplier</label>
                                    <select name="supplier" class="form-control" id="supplier">
                                        <option value="" selected>All</option>
                                        @forelse ($supplier as $item)
                                            <option value="{{ $item->id }}"
                                                {{ request()->query('supplier') && request()->query('supplier') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama_supplier }}
                                            </option>
                                        @empty
                                            <option value="" selected disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            {{-- <div class="form-group row" style="margin-bottom: 1em;">
                                <div class="col-md-6">
                                    <label for="barang" class="control-label">Barang</label>
                                    <select name="barang" class="form-control" id="barang">
                                        <option value="" selected>All</option>
                                        @forelse ($barang as $item)
                                            <option value="{{ $item->id }}"
                                                {{ request()->query('barang') && request()->query('barang') == $item->id ? 'selected' : '' }}>
                                                {{ $item->kode . ' - ' . $item->nama }}
                                            </option>
                                        @empty
                                            <option value="" selected disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="bentuk_kepemilikan_stok">Bentuk Kepemilikan Stok</label>
                                    <select name="bentuk_kepemilikan_stok" id="bentuk_kepemilikan_stok"
                                        class="form-control">
                                        <option value="" selected>All</option>
                                        @foreach ($bentukKepemilikanStok as $item)
                                            <option value="{{ $item->id }}"
                                                {{ request()->query('bentuk_kepemilikan_stok') && request()->query('bentuk_kepemilikan_stok') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}

                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fa fa-eye"></i> Cek
                            </button>
                            <a href="{{ route('retur-pembelian.laporan') }}"
                                class="btn btn-sm btn-default{{ request()->query() ? '' : ' disabled' }}">
                                <i class="fa fa-trash"></i> Reset
                            </a>
                            @if (count($laporan) > 0)
                                <a href="{{ route('retur-pembelian.pdf', request()->query()) }}" target="_blank"
                                    class="btn btn-sm btn-info">
                                    <i class="fa fa-print"></i> Print
                                </a>
                            @endif
                        </form>

                        <table class="table table-striped table-condensed" style="margin-top: 1em;">
                            <thead>
                                <tr>
                                    <th width="30">No.</th>
                                    <th colspan="2">Kode</th>
                                    <th colspan="2">Kode Pembelian</th>
                                    <th>Tanggal</th>
                                    <th colspan="2">Gudang</th>
                                    <th colspan="2">Supplier</th>
                                    <th>Rate</th>
                                </tr>
                            </thead>
                            @php
                                $grandtotal = 0;
                            @endphp
                            <tbody>
                                @forelse ($laporan as $item)
                                    @php
                                        $total_qty_beli = 0;
                                        $total_qty_retur = 0;
                                        $total = 0;
                                    @endphp
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <th colspan="2">{{ $item->kode }}</th>
                                        <th colspan="2">{{ $item->pembelian->kode }}</th>
                                        <th>{{ $item->tanggal->format('d F Y') }}</th>
                                        <th colspan="2">{{ $item->gudang->nama }}</th>
                                        <th colspan="2">
                                            {{ $item->pembelian->supplier ? $item->pembelian->supplier->nama_supplier : 'Tanpa Supplier' }}
                                        </th>
                                        <th>{{ $item->rate }}</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th>Barang</th>
                                        <th>Qty Beli</th>
                                        <th>Qty Retur</th>
                                        <th>Harga</th>
                                        <th>Disc</th>
                                        <th>PPN</th>
                                        <th>PPH</th>
                                        <th>B.Msk</th>
                                        <th>Clr.Fee</th>
                                        <th>Subtotal</th>
                                    </tr>
                                    @foreach ($item->retur_pembelian_detail as $detail)
                                        <tr>
                                            <td></td>
                                            <td>
                                                {{ $detail->barang->kode . ' - ' . $detail->barang->nama }}
                                            </td>
                                            <td>{{ $detail->qty_beli }}</td>
                                            <td>{{ $detail->qty_retur }}</td>
                                            <td>
                                                {{ $item->pembelian->matauang->kode . ' ' . number_format($detail->harga) }}
                                            </td>
                                            <td>
                                                {{ $item->pembelian->matauang->kode . ' ' . number_format($detail->diskon) }}
                                            </td>
                                            <td>
                                                {{ $item->pembelian->matauang->kode . ' ' . number_format($detail->ppn) }}
                                            </td>
                                            <td>
                                                {{ $item->pembelian->matauang->kode . ' ' . number_format($detail->pph) }}
                                            </td>
                                            <td>
                                                {{ $item->pembelian->matauang->kode . ' ' . number_format($detail->biaya_masuk) }}
                                            </td>
                                            <td>
                                                {{ $item->pembelian->matauang->kode . ' ' . number_format($detail->clr_fee) }}
                                            </td>
                                            <td>
                                                {{ $item->pembelian->matauang->kode . ' ' . number_format($detail->netto) }}
                                            </td>
                                        </tr>
                                        @php
                                            $total_qty_beli += $detail->qty_beli;
                                            $total_qty_retur += $detail->qty_retur;
                                            $total += $detail->subtotal;
                                            $grandtotal += $detail->subtotal;
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <th></th>
                                        <th>Total</th>
                                        <th>{{ $total_qty_beli }}</th>
                                        <th>{{ $total_qty_retur }}</th>
                                        <th>
                                            {{ $item->pembelian->matauang->kode . ' ' . number_format($item->total_gross) }}
                                        </th>
                                        <th>
                                            {{ $item->pembelian->matauang->kode . ' ' . number_format($item->total_diskon) }}
                                        </th>
                                        <th>
                                            {{ $item->pembelian->matauang->kode . ' ' . number_format($item->total_ppn) }}
                                        </th>
                                        <th>
                                            {{ $item->pembelian->matauang->kode . ' ' . number_format($item->total_pph) }}
                                        </th>
                                        <th>
                                            {{ $item->pembelian->matauang->kode . ' ' . number_format($item->total_biaya_masuk) }}
                                        </th>
                                        <th>
                                            {{ $item->pembelian->matauang->kode . ' ' . number_format($item->total_clr_fee) }}
                                        </th>
                                        <th>
                                            {{ $item->pembelian->matauang->kode . ' ' . number_format($item->total_netto) }}
                                        </th>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->
@endsection
