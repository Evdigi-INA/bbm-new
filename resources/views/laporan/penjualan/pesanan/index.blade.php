@extends('layouts.dashboard')

@section('title', trans('dashboard.laporan.pesanan_penjualan'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('laporan_pesanan_penjualan') }}
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
                        <h4 class="panel-title">{{ trans('dashboard.laporan.pesanan_penjualan') }}</h4>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('pesanan-penjualan.laporan') }}" method="GET" style="margin-bottom: 1em;">
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
                                <div class="col-md-4">
                                    <label for="status" class="control-label">Status</label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="" selected>All</option>
                                        @forelse ($statusPo as $item)
                                            <option value="{{ $item->id }}"
                                                {{ request()->query('status') && request()->query('status') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}
                                            </option>
                                        @empty
                                            <option value="" selected disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="pelanggan" class="control-label">Pelanggan</label>
                                    <select name="pelanggan" class="form-control" id="pelanggan">
                                        <option value="" selected>All</option>
                                        @forelse ($pelanggan as $item)
                                            <option value="{{ $item->id }}"
                                                {{ request()->query('pelanggan') && request()->query('pelanggan') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama_pelanggan }}
                                            </option>
                                        @empty
                                            <option value="" selected disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-4">
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
                            <a href="{{ route('pesanan-penjualan.laporan') }}"
                                class="btn btn-sm btn-default{{ request()->query() ? '' : ' disabled' }}">
                                <i class="fa fa-trash"></i> Reset
                            </a>
                            @if (count($laporan) > 0)
                                <a href="{{ route('pesanan-penjualan.pdf', request()->query()) }}" target="_blank"
                                    class="btn btn-sm btn-info">
                                    <i class="fa fa-print"></i> Print
                                </a>
                            @endif
                        </form>

                        <table class="table table-striped table-condensed data-table" style="margin-top: 1em;">
                            <thead>
                                <tr>
                                    <th width="30">No.</th>
                                    <th colspan="3">Kode</th>
                                    <th colspan="3">Tanggal</th>
                                    <th colspan="3">Pelanggan</th>
                                    <th>Rate</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            @php
                                $grandtotal = 0;
                            @endphp
                            <tbody>
                                @forelse ($laporan as $item)
                                    @php
                                        $total_qty = 0;
                                        $total = 0;
                                    @endphp
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <th colspan="3">{{ $item->kode }}</th>
                                        <th colspan="3">{{ $item->tanggal->format('d F Y') }}</th>
                                        <th colspan="3">
                                            {{ $item->pelanggan ? $item->pelanggan->nama_pelanggan : 'Tanpa pelanggan' }}
                                        </th>
                                        <th>{{ $item->rate }}</th>
                                        <th>{{ $item->status }}</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th colspan="3">Barang</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Disc</th>
                                        <th>PPN</th>
                                        <th>PPH</th>
                                        <th>B.Msk</th>
                                        <th>Clr.Fee</th>
                                        <th>Subtotal</th>
                                    </tr>
                                    @foreach ($item->pesanan_penjualan_detail as $detail)
                                        <tr>
                                            <td></td>
                                            <td colspan="3">
                                                {{ $detail->barang->kode . ' - ' . $detail->barang->nama }}
                                            </td>
                                            <td>{{ $detail->qty }}</td>
                                            <td>
                                                {{ $item->matauang->kode . ' ' . number_format($detail->harga, 2, '.', ',') }}
                                            </td>
                                            <td>
                                                {{ $item->matauang->kode . ' ' . number_format($detail->diskon, 2, '.', ',') }}
                                            </td>
                                            <td>
                                                {{ $item->matauang->kode . ' ' . number_format($detail->ppn, 2, '.', ',') }}
                                            </td>
                                            <td>
                                                {{ $item->matauang->kode . ' ' . number_format($detail->pph, 2, '.', ',') }}
                                            </td>
                                            <td>
                                                {{ $item->matauang->kode . ' ' . number_format($detail->biaya_masuk, 2, '.', ',') }}
                                            </td>
                                            <td>
                                                {{ $item->matauang->kode . ' ' . number_format($detail->clr_fee, 2, '.', ',') }}
                                            </td>
                                            <td>
                                                {{ $item->matauang->kode . ' ' . number_format($detail->netto, 2, '.', ',') }}
                                            </td>
                                        </tr>
                                        @php
                                            $total_qty += $detail->qty;
                                            $total += $detail->subtotal;
                                            $grandtotal += $detail->subtotal;
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <th></th>
                                        <th colspan="3">Total</th>
                                        <th>{{ $total_qty }}</th>
                                        <th>
                                            {{ $item->matauang->kode . ' ' . number_format($item->total_gross, 2, '.', ',') }}
                                        </th>
                                        <th>
                                            {{ $item->matauang->kode . ' ' . number_format($item->total_diskon, 2, '.', ',') }}
                                        </th>
                                        <th>
                                            {{ $item->matauang->kode . ' ' . number_format($item->total_ppn, 2, '.', ',') }}
                                        </th>
                                        <th>
                                            {{ $item->matauang->kode . ' ' . number_format($item->total_pph, 2, '.', ',') }}
                                        </th>
                                        <th>
                                            {{ $item->matauang->kode . ' ' . number_format($item->total_biaya_masuk, 2, '.', ',') }}
                                        </th>
                                        <th>
                                            {{ $item->matauang->kode . ' ' . number_format($item->total_clr_fee, 2, '.', ',') }}
                                        </th>
                                        <th>
                                            {{ $item->matauang->kode . ' ' . number_format($item->total_netto, 2, '.', ',') }}
                                        </th>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            {{-- <tfoot>
                                    <tr>
                                        <th></th>
                                        <th colspan="4">GRANDTOTAL</th>
                                        <,>{{ $item->matauang->kode . '  ' . number_format($grandtotal) }}</, 2, '.', ','th>
                                    </tr>
                                </tfoot> --}}
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
