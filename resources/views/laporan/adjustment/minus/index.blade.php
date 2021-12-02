@extends('layouts.dashboard')

@section('title', trans('dashboard.laporan.adjustment_minus'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('laporan_adjustment_minus') }}
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
                        <h4 class="panel-title">{{ trans('dashboard.laporan.adjustment_minus') }}</h4>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('adjustment-minus.laporan') }}" method="GET" style="margin-bottom: 1em;">
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
                            <a href="{{ route('adjustment-minus.laporan') }}"
                                class="btn btn-sm btn-default{{ request()->query() ? '' : ' disabled' }}">
                                <i class="fa fa-trash"></i> Reset
                            </a>
                            @if (count($laporan) > 0)
                                <a href="{{ route('adjustment-minus.pdf', request()->query()) }}" target="_blank"
                                    class="btn btn-sm btn-info">
                                    <i class="fa fa-print"></i> Print
                                </a>
                            @endif
                        </form>

                        <table class="table table-striped table-condensed data-table" style="margin-top: 1em;">
                            <thead>
                                <tr>
                                    <th width="30">No.</th>
                                    <th colspan="2">Kode</th>
                                    <th colspan="2">Tanggal</th>
                                    <th>Gudang</th>
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
                                        <th colspan="2">{{ $item->kode }}</th>
                                        <th colspan="2">{{ $item->tanggal->format('d F Y') }}</th>
                                        <th>{{ $item->gudang->nama }}</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th colspan="2">Barang</th>
                                        <th colspan="2">Supplier</th>
                                        <th>Qty</th>
                                    </tr>
                                    @foreach ($item->adjustment_minus_detail as $detail)
                                        <tr>
                                            <td></td>
                                            <td colspan="2">
                                                {{ $detail->barang->kode . ' - ' . $detail->barang->nama }}
                                            </td>
                                            <td colspan="2">{{ $detail->supplier->nama_supplier }}</td>
                                            <td>{{ $detail->qty }}</td>
                                        </tr>
                                        @php
                                            $total_qty += $detail->qty;
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <th></th>
                                        <th colspan="4">Total</th>
                                        <th>{{ $total_qty }}</th>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Data tidak ditemukan</td>
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
