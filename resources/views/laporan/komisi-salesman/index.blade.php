@extends('layouts.dashboard')

@section('title', trans('dashboard.laporan.komisi_salesman'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('laporan_komisi_salesman') }}
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
                        <h4 class="panel-title">{{ trans('dashboard.laporan.komisi_salesman') }}</h4>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('komisi-salesman.laporan') }}" method="GET" style="margin-bottom: 1em;">
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
                                    <label for="salesman" class="control-label">Salesman</label>
                                    <select name="salesman" class="form-control" id="salesman"
                                        {{ auth()->user()->hasRole('salesman')
                                            ? 'readonly'
                                            : '' }}>
                                        @role('salesman')
                                            <option value="{{ auth()->user()->salesman->id }}" selected>
                                                {{ auth()->user()->salesman->nama }}
                                            </option>
                                        @else
                                            <option value="" selected>All</option>
                                            @forelse ($salesman as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ request()->query('salesman') && request()->query('salesman') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nama }}
                                                </option>
                                            @empty
                                                <option value="" selected disabled>Data tidak ditemukan</option>
                                            @endforelse
                                        @endrole

                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fa fa-eye"></i> Cek
                            </button>
                            <a href="{{ route('komisi-salesman.laporan') }}"
                                class="btn btn-sm btn-default{{ request()->query() ? '' : ' disabled' }}">
                                <i class="fa fa-trash"></i> Reset
                            </a>
                            @if (count($laporan) > 0)
                                <a href="{{ route('komisi-salesman.pdf', request()->query()) }}" target="_blank"
                                    class="btn btn-sm btn-info">
                                    <i class="fa fa-print"></i> Print
                                </a>
                            @endif
                        </form>

                        <table class="table table-striped table-condensed data-table" style="margin-top: 1em;">
                            <thead>
                                <tr>
                                    <th width="15">No.</th>
                                    <th>Kode Penjualan</th>
                                    @role('admin')
                                        <th>Kode Pelunasan</th>
                                    @endrole
                                    <th>Tanggal</th>
                                    <th>Salesman</th>
                                    <th>Nilai</th>
                                    <th>Rate</th>
                                    {{-- <th>Total</th> --}}
                                    <th>Komisi</th>
                                    <th>Total Komisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($laporan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->kode }}</td>
                                        @role('admin')
                                            <td>{{ $item->pelunasan_piutang ? $item->pelunasan_piutang->kode : $item->kode }}
                                            </td>
                                        @endrole
                                        <td>{{ $item->pelunasan_piutang ? $item->pelunasan_piutang->tanggal->format('d F Y') : $item->tanggal->format('d F Y') }}
                                        </td>
                                        <td>{{ $item->salesman->nama }}</td>
                                        <td>
                                            {{ $item->matauang->kode }}
                                            {{ $item->pelunasan_piutang ? number_format($item->pelunasan_piutang->bayar, 2, '.', ',') : number_format($item->total_penjualan, 2, '.', ',') }}
                                        </td>
                                        <td>{{ $item->rate }}</td>
                                        <td>1%</td>
                                        <td>
                                            {{ $item->matauang->kode }}
                                            {{ $item->pelunasan_piutang ? number_format($item->pelunasan_piutang->bayar * 0.01, 2, '.', ',') : number_format($item->total_penjualan * 0.01, 2, '.', ',') }}
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">Data tidak ditemukan</td>
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
