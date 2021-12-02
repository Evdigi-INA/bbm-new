@extends('layouts.dashboard')

@section('title', trans('dashboard.laporan.cek_giro'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('laporan_cek_giro') }}
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
                        <h4 class="panel-title">{{ trans('dashboard.laporan.cek_giro') }}</h4>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('cek-giro.laporan') }}" method="GET" style="margin-bottom: 1em;">
                            <div class="form-group row" style="margin-bottom: 1em;">
                                <div class="col-md-6">
                                    <label for="jenis_cek" class="control-label">Jenis Cek/Giro</label>
                                    <select name="jenis_cek" class="form-control" id="jenis_cek">
                                        <option value="" selected>All</option>
                                        @foreach ($jenisCekGiro as $item)
                                            <option value="{{ $item->id }}"
                                                {{ request()->query('jenis_cek') && request()->query('jenis_cek') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="status" class="control-label">Status</label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="" selected>All</option>
                                        @foreach ($statusCekGiro as $item)
                                            <option value="{{ $item->id }}"
                                                {{ request()->query('stautus') && request()->query('stautus') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fa fa-eye"></i> Cek
                            </button>
                            <a href="{{ route('cek-giro.laporan') }}"
                                class="btn btn-sm btn-default{{ request()->query() ? '' : ' disabled' }}">
                                <i class="fa fa-trash"></i> Reset
                            </a>
                            @if (count($laporan) > 0)
                                <a href="/laporan/cek-giro/pdf?jenis_cek={{ request()->query('jenis_cek') }}&status={{ request()->query('status') }}"
                                    target="_blank" class="btn btn-sm btn-info">
                                    <i class="fa fa-print"></i> Print
                                </a>
                            @endif
                        </form>

                        <div class="table-responsive">
                            <table class="table table-striped table-condensed data-table" style="margin-top: 1em;">
                                <thead>
                                    <tr>
                                        <th width="15">No.</th>
                                        <th>No Cek/Giro</th>
                                        <th>Tgl Cek/Giro</th>
                                        <th>Jenis</th>
                                        <th>Status</th>
                                        <th>No Ref</th>
                                        <th>Nama Ref</th>
                                        <th>Bank</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($laporan as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($item->pembelian)
                                                    {{ $item->pembelian->pembelian_pembayaran[0]->no_cek_giro }}
                                                @else
                                                    {{ $item->penjualan->penjualan_pembayaran[0]->no_cek_giro }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->pembelian)
                                                    {{ $item->pembelian->pembelian_pembayaran[0]->tgl_cek_giro->format('d F Y') }}
                                                @else
                                                    {{ $item->penjualan->penjualan_pembayaran[0]->tgl_cek_giro->format('d F Y') }}
                                                @endif
                                            </td>
                                            <td>{{ strtoupper($item->jenis_cek) }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>
                                                @if ($item->pembelian)
                                                    {{ $item->pembelian->kode }}
                                                @else
                                                    {{ $item->penjualan->kode }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->penjualan)
                                                    {{ $item->penjualan->pelanggan->nama_pelanggan }}
                                                @else
                                                    {{ $item->pembelian->supplier ? $item->pembelian->supplier->nama_supplier : 'Tanpa Supplier' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->pembelian)
                                                    {{ $item->pembelian->pembelian_pembayaran[0]->bank ? $item->pembelian->pembelian_pembayaran[0]->bank->nama : '-' }}
                                                @else
                                                    {{ $item->penjualan->penjualan_pembayaran[0]->bank ? $item->penjualan->penjualan_pembayaran[0]->bank->nama : '-' }}
                                                @endif
                                            </td>
                                            <td>
                                                {{ $item->pembelian ? $item->pembelian->matauang->kode : $item->penjualan->matauang->kode }}

                                                @if ($item->pembelian)
                                                    {{ number_format($item->pembelian->pembelian_pembayaran[0]->bayar) }}
                                                @else
                                                    {{ number_format($item->penjualan->penjualan_pembayaran[0]->bayar) }}
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">Data tidak ditemukan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- @dump($laporan) --}}
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
