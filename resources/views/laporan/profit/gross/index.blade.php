@extends('layouts.dashboard')

@section('title', trans('dashboard.laporan.gross_profit'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('laporan_gross_profit') }}
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
                        <h4 class="panel-title">{{ trans('dashboard.laporan.gross') }}</h4>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('gross-profit.laporan') }}" method="GET" style="margin-bottom: 1em;">
                            <div class="form-group row" style="margin-bottom: 1em;">
                                <div class="col-md-4">
                                    <label for="dari_tanggal" class="control-label">Dari Tanggal</label>
                                    <input type="date" name="dari_tanggal" class="form-control" id="dari_tanggal"
                                        value="{{ request()->query('dari_tanggal') ? request()->query('dari_tanggal') : date('Y-m-d') }}"
                                        required />
                                </div>

                                <div class="col-md-4">
                                    <label for="sampai_tanggal" class="control-label">Sampai Tanggal</label>
                                    <input type="date" name="sampai_tanggal" class="form-control" id="sampai_tanggal"
                                        value="{{ request()->query('sampai_tanggal') ? request()->query('sampai_tanggal') : date('Y-m-d') }}"
                                        required />
                                </div>

                                <div class="col-md-4">
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
                                    <label for="salesman" class="control-label">Salesman</label>
                                    <select name="salesman" class="form-control" id="salesman">
                                        <option value="" selected>All</option>
                                        @forelse ($salesman as $item)
                                            <option value="{{ $item->id }}"
                                                {{ request()->query('salesman') && request()->query('salesman') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}
                                            </option>
                                        @empty
                                            <option value="" selected disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                </div>

                                {{-- <div class="col-md-4">
                                    <label for="barang" class="control-label">barang</label>
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
                                </div> --}}
                            </div>

                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fa fa-eye"></i> Cek
                            </button>
                            <a href="{{ route('gross-profit.laporan') }}"
                                class="btn btn-sm btn-default{{ request()->query() ? '' : ' disabled' }}">
                                <i class="fa fa-trash"></i> Reset
                            </a>
                            @if (count($laporan) > 0)
                                <a href="{{ route('gross-profit.pdf', request()->query()) }}" target="_blank"
                                    class="btn btn-sm btn-info">
                                    <i class="fa fa-print"></i> Print
                                </a>
                            @endif
                        </form>

                        <table class="table table-striped table-condensed data-table" style="margin-top: 1em;">
                            <thead>
                                <tr>
                                    <th width="15">No.</th>
                                    <th>Kode</th>
                                    <th>Tanggal</th>
                                    <th>Gudang</th>
                                    <th>Pelanggan</th>
                                    <th>Salesman</th>
                                    <th>Total Jual</th>
                                    <th>Gross Profit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($laporan as $item)
                                    {{-- @php
                                        $total_qty = 0;
                                        $total = 0;
                                    @endphp --}}
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <th>{{ $item->kode }}</th>
                                        <th>{{ $item->tanggal->format('d F Y') }}</th>
                                        <th>{{ $item->gudang->nama }}</th>
                                        <th>{{ $item->pelanggan->nama_pelanggan }}</th>
                                        <th>{{ $item->salesman->nama }}</th>
                                        <th>{{ $item->matauang->kode . ' ' . number_format($item->total_netto, 2, '.', ',') }}
                                        </th>
                                        <th>{{ $item->matauang->kode . ' ' . number_format($item->total_gross, 2, '.', ',') }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th colspan="3">Barang</th>
                                        <th>Qty</th>
                                        <th colspan="3">Harga Jual</th>
                                        {{-- <th colspan="2">Harga Beli</th> --}}
                                    </tr>
                                    @foreach ($item->penjualan_detail as $detail)
                                        <tr>
                                            <td></td>
                                            <td colspan="3">
                                                {{ $detail->barang->kode . ' - ' . $detail->barang->nama }}
                                            </td>
                                            <td>{{ $detail->qty }}</td>
                                            <td colspan="3">
                                                {{ $item->matauang->kode . ' ' . number_format($detail->harga, 2, '.', ',') }}
                                            </td>
                                            {{-- <td colspan="2">{{ $detail->barang->harga_beli }}</td> --}}
                                        </tr>
                                        {{-- @php
                                            $total_qty += $detail->qty;
                                        @endphp --}}
                                    @endforeach
                                    {{-- <tr>
                                        <th></th>
                                        <th>Total</th>
                                        <th>{{ $total_qty }}</th>
                                    </tr> --}}
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Data tidak ditemukan</td>
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
