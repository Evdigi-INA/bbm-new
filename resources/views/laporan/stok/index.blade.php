@extends('layouts.dashboard')

@section('title', trans('dashboard.laporan.stok_barang'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('laporan_stok_barang') }}
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
                        <h4 class="panel-title">{{ trans('dashboard.laporan.stok_barang') }}</h4>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('stok-barang.laporan') }}" method="GET" style="margin-bottom: 1em;">
                            <div class="form-group row" style="margin-bottom: 1em;">
                                <div class="col-md-6">
                                    <label for="per_tanggal" class="control-label">Per Tanggal</label>
                                    <input type="date" name="per_tanggal" class="form-control" id="per_tanggal"
                                        value="{{ request()->query('per_tanggal') ? request()->query('per_tanggal') : date('Y-m-d') }}"
                                        required />
                                </div>

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
                            </div>

                            <div class="form-group row" style="margin-bottom: 1em;">
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
                            </div>

                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fa fa-eye"></i> Cek
                            </button>
                            <a href="{{ route('stok-barang.laporan') }}"
                                class="btn btn-sm btn-default{{ request()->query() ? '' : ' disabled' }}">
                                <i class="fa fa-trash"></i> Reset
                            </a>
                            @if (count($laporan) > 0)
                                <a href="{{ route('stok-barang.pdf', request()->query()) }}" target="_blank"
                                    class="btn btn-sm btn-info">
                                    <i class="fa fa-print"></i> Print
                                </a>
                            @endif
                        </form>

                        <div class="table-responsive">
                            <table class="table table-striped table-condensed data-table" style="margin-top: 1em;">
                                <thead>
                                    <tr>
                                        <th width="15">No.</th>
                                        <th>Kode</th>
                                        <th>Barang</th>
                                        <th>Gudang</th>
                                        {{-- <th>Tipe</th> --}}
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Total</th>
                                        <th>Harga Stok</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                        $grandtotal_beli = 0;
                                        $total_qty_beli = 0;
                                        $total_harga_beli = 0;
                                        $total_harga_stok_beli = 0;

                                        $grandtotal_retur_beli = 0;
                                        $total_qty_retur_beli = 0;
                                        $total_harga_retur_beli = 0;
                                        $total_harga_stok_retur_beli = 0;

                                        $grandtotal_jual = 0;
                                        $total_qty_jual = 0;
                                        $total_harga_jual = 0;
                                        $total_harga_stok_jual = 0;

                                        $grandtotal_retur_jual = 0;
                                        $total_qty_retur_jual = 0;
                                        $total_harga_retur_jual = 0;
                                        $total_harga_stok_retur_jual = 0;

                                        $grandtotal_adjustment_plus = 0;
                                        $total_qty_adjustment_plus = 0;
                                        $total_harga_adjustment_plus = 0;
                                        $total_harga_stok_adjustment_plus = 0;

                                        $grandtotal_adjustment_minus = 0;
                                        $total_qty_adjustment_minus = 0;
                                        $total_harga_adjustment_minus = 0;
                                        $total_harga_stok_adjustment_minus = 0;

                                        $no = 1;
                                    @endphp
                                    @if (count($laporan) > 0)
                                        @foreach ($laporan['stok_beli'] as $item)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $item->pembelian->kode }}</td>
                                                <td>{{ $item->barang->kode . ' - ' . $item->barang->nama }}</td>
                                                <td>{{ $item->pembelian->gudang->nama }}</td>
                                                {{-- <td>Purch</td> --}}
                                                <td> {{ $item->qty }}</td>
                                                <td>{{ number_format($item->harga) }}</td>
                                                <td>{{ number_format($item->pembelian->total_netto) }}</td>
                                                <td>{{ number_format($item->pembelian->total_netto / $item->qty) }}</td>
                                            </tr>
                                            @php
                                                $grandtotal_beli += $item->pembelian->total_netto;
                                                $total_qty_beli += $item->qty;
                                                $total_harga_beli += $item->harga;
                                                $total_harga_stok_beli += $item->pembelian->total_netto / $item->qty;
                                            @endphp
                                        @endforeach

                                        @foreach ($laporan['stok_retur_beli'] as $item)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $item->retur_pembelian->kode }}</td>
                                                <td>{{ $item->barang->kode . ' - ' . $item->barang->nama }}</td>
                                                <td>{{ $item->retur_pembelian->gudang->nama }}</td>
                                                {{-- <td>Return Purch</td> --}}
                                                <td>-{{ $item->qty_retur }}</td>
                                                <td>
                                                    {{ number_format($item->harga) }}
                                                </td>
                                                <td>{{ number_format($item->retur_pembelian->total_netto) }}</td>
                                                <td>-
                                                    {{ number_format($item->retur_pembelian->total_netto / $item->qty_retur) }}
                                                </td>
                                            </tr>
                                            @php
                                                $grandtotal_retur_beli += $item->retur_pembelian->total_netto;
                                                $total_qty_retur_beli += $item->qty_retur;
                                                $total_harga_retur_beli += $item->harga;
                                                $total_harga_stok_retur_beli += $item->retur_pembelian->total_netto / $item->qty_retur;
                                            @endphp
                                        @endforeach

                                        @foreach ($laporan['stok_jual'] as $item)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $item->penjualan->kode }}</td>
                                                <td>{{ $item->barang->kode . ' - ' . $item->barang->nama }}</td>
                                                <td>{{ $item->penjualan->gudang->nama }}</td>
                                                {{-- <td>Sale</td> --}}
                                                <td>-{{ $item->qty }}</td>
                                                <td>{{ number_format($item->harga) }}</td>
                                                <td>{{ number_format($item->penjualan->total_netto) }}</td>
                                                <td> {{ number_format($item->penjualan->total_netto / $item->qty) }}</td>
                                            </tr>
                                            @php
                                                $grandtotal_jual += $item->penjualan->total_netto;
                                                $total_qty_jual += $item->qty;
                                                $total_harga_jual += $item->harga;
                                                $total_harga_stok_jual += $item->penjualan->total_netto / $item->qty;
                                            @endphp
                                        @endforeach

                                        @foreach ($laporan['stok_retur_jual'] as $item)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $item->retur_penjualan->kode }}</td>
                                                <td>{{ $item->barang->kode . ' - ' . $item->barang->nama }}</td>
                                                <td>{{ $item->retur_penjualan->gudang->nama }}</td>
                                                {{-- <td>Return Sale</td> --}}
                                                <td> {{ $item->qty_retur }}</td>
                                                <td>{{ number_format($item->harga) }}</td>
                                                <td>{{ number_format($item->retur_penjualan->total_netto) }}</td>
                                                <td>{{ number_format($item->retur_penjualan->total_netto / $item->qty_retur) }}
                                                </td>
                                            </tr>
                                            @php
                                                $grandtotal_retur_jual += $item->retur_penjualan->total_netto;
                                                $total_qty_retur_jual += $item->qty_retur;
                                                $total_harga_retur_jual += $item->harga;
                                                $total_harga_stok_retur_jual += $item->retur_penjualan->total_netto / $item->qty_retur;
                                            @endphp
                                        @endforeach

                                        @foreach ($laporan['stok_adjustment_plus'] as $item)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $item->adjustment_plus->kode }}</td>
                                                <td>{{ $item->barang->kode . ' - ' . $item->barang->nama }}</td>
                                                <td>{{ $item->adjustment_plus->gudang->nama }}</td>
                                                {{-- <td>Adj Plus</td> --}}
                                                <td> {{ $item->qty }}</td>
                                                <td>{{ number_format($item->harga) }}</td>
                                                <td>{{ number_format($item->adjustment_plus->grand_total) }}</td>
                                                <td>{{ number_format($item->adjustment_plus->grand_total / $item->qty) }}
                                                </td>
                                            </tr>
                                            @php
                                                $grandtotal_adjustment_plus += $item->grand_total;
                                                $total_qty_adjustment_plus += $item->qty;
                                                $total_harga_adjustment_plus += $item->harga;
                                                $total_harga_stok_adjustment_plus += $item->adjustment_plus->grand_total / $item->qty;
                                            @endphp
                                        @endforeach

                                        @foreach ($laporan['stok_adjustment_minus'] as $item)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $item->adjustment_minus->kode }}</td>
                                                <td>{{ $item->barang->kode . ' - ' . $item->barang->nama }}</td>
                                                <td>{{ $item->adjustment_minus->gudang->nama }}</td>
                                                {{-- <td>Adj Min</td> --}}
                                                <td>-{{ $item->qty }}</td>
                                                <td>{{ number_format($item->barang->harga_beli) }}</td>
                                                <td>-{{ number_format($item->barang->harga_beli * $item->qty) }}
                                                </td>
                                                <td>-{{ number_format(($item->barang->harga_beli * $item->qty) / $item->qty) }}
                                                </td>
                                            </tr>
                                            @php
                                                $grandtotal_adjustment_minus += $item->barang->harga_beli * $item->qty;
                                                $total_qty_adjustment_minus += $item->qty;
                                                $total_harga_adjustment_minus += $item->barang->harga_beli;
                                                $total_harga_stok_adjustment_minus += ($item->barang->harga_beli * $item->qty) / $item->qty;
                                            @endphp
                                        @endforeach
                                    @endif
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th colspan="4">Total</th>
                                        <th>
                                            {{ $total_qty_beli + $total_qty_adjustment_plus + $total_qty_retur_jual - $total_qty_jual - $total_qty_retur_beli - $total_qty_adjustment_minus }}
                                        </th>
                                        <th>
                                            {{ number_format($total_harga_beli + $total_harga_adjustment_plus + $total_harga_retur_jual - $total_harga_jual - $total_harga_retur_beli - $total_harga_adjustment_minus) }}
                                        </th>
                                        <th>
                                            {{ number_format($grandtotal_beli + $grandtotal_adjustment_plus + $grandtotal_retur_jual - $grandtotal_jual - $grandtotal_retur_beli - $grandtotal_adjustment_minus) }}
                                        </th>
                                        <th>
                                            {{ number_format($total_harga_stok_beli + $total_harga_stok_adjustment_plus + $total_harga_stok_retur_jual - $total_harga_stok_jual - $total_harga_stok_retur_beli - $total_harga_stok_adjustment_minus) }}
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>

                            {{-- <div>
                                <p>QTY JUAL: {{ $total_qty_jual }}</p>
                                <p>QTY BELI: {{ $total_qty_beli }}</p>
                                <p>QTY AP: {{ $total_qty_adjustment_plus }}</p>
                                <p>QTY AM: {{ $total_qty_adjustment_minus }}</p>
                                <p>QTY RET BELI: {{ $total_qty_retur_beli }}</p>
                                <p>QTY RET JUAL{{ $total_qty_retur_jual }}</p>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->

    {{-- @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Data tidak ditemukan</td>
                                    </tr> --}}
@endsection
