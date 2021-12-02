@extends('layouts.dashboard')

@section('title', trans('dashboard.laporan.saldo_piutang'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('laporan_saldo_piutang') }}
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
                        <h4 class="panel-title">{{ trans('dashboard.laporan.saldo_piutang') }}</h4>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('saldo-piutang.laporan') }}" method="GET" style="margin-bottom: 1em;">
                            <div class="form-group row" style="margin-bottom: 1em;">
                                <div class="col-md-4">
                                    <label for="per_tanggal" class="control-label">Per Tanggal</label>
                                    <input type="date" name="per_tanggal" class="form-control" id="per_tanggal"
                                        value="{{ request()->query('per_tanggal') ? request()->query('per_tanggal') : date('Y-m-d') }}"
                                        required />
                                </div>

                                <div class="col-md-4">
                                    <label for="matauang" class="control-label">Mata Uang</label>
                                    <select name="matauang" class="form-control" id="matauang">
                                        <option value="" selected>All</option>
                                        @forelse ($matauang as $item)
                                            <option value="{{ $item->id }}"
                                                {{ request()->query('matauang') && request()->query('matauang') == $item->id ? 'selected' : '' }}>
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
                            </div>

                            <div class="form-group row" style="margin-bottom: 1em;">
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

                                <div class="col-md-4">
                                    <label for="status" class="control-label">Status</label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="" selected>All</option>
                                        @forelse ($statusHutangPiutang as $item)
                                            <option value="{{ $item->id }}"
                                                {{ request()->query('status') && request()->query('status') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}
                                            </option>
                                        @empty
                                            <option value="" selected disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fa fa-eye"></i> Cek
                            </button>
                            <a href="{{ route('saldo-piutang.laporan') }}"
                                class="btn btn-sm btn-default{{ request()->query() ? '' : ' disabled' }}">
                                <i class="fa fa-trash"></i> Reset
                            </a>
                            @if (count($laporan) > 0)
                                <a href="{{ route('saldo-piutang.pdf', request()->query()) }}" target="_blank"
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
                                    <th>Pelanggan</th>
                                    <th>Salesman</th>
                                    <th>Status</th>
                                    <th>Umur</th>
                                    <th>Nilai Jual</th>
                                    <th>Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_nilai_jual = 0;
                                    $total_saldo_piutang = 0;
                                @endphp
                                @forelse ($laporan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->tanggal->format('d F Y') }}</td>
                                        <td>{{ $item->pelanggan ? $item->pelanggan->nama_pelanggan : 'Umum' }}
                                        </td>
                                        <td>{{ $item->salesman->nama }}
                                        </td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            {{ $item->tanggal->diffForHumans() }}
                                        </td>
                                        <td>{{ $item->matauang->kode . ' ' . number_format($item->total_netto) }}
                                        </td>
                                        <td>{{ $item->matauang->kode }}
                                            {{ count($item->penjualan_pembayaran) > 1 ? number_format($item->penjualan_pembayaran[0]->bayar) : 0 }}
                                        </td>
                                    </tr>
                                    @php
                                        $total_nilai_jual += $item->total_netto;
                                        $total_saldo_piutang += count($item->penjualan_pembayaran) > 1 ? $item->penjualan_pembayaran[0]->bayar : 0;
                                    @endphp
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="7">Total</th>
                                    <th>{{ number_format($total_nilai_jual) }}</th>
                                    <th>{{ number_format($total_saldo_piutang) }}</th>
                                </tr>
                            </tfoot>
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
