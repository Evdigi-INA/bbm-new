@extends('layouts.dashboard')

@section('title', trans('dashboard.laporan.pelunasan_hutang'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('laporan_pelunasan_hutang') }}
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
                        <h4 class="panel-title">{{ trans('dashboard.laporan.pelunasan_hutang') }}</h4>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('pelunasan-hutang.laporan') }}" method="GET" style="margin-bottom: 1em;">
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
                                    <label for="pembelian" class="control-label">Pembelian</label>
                                    <select name="pembelian" class="form-control" id="pembelian">
                                        <option value="" selected>All</option>
                                        @forelse ($semuaPembelian as $item)
                                            <option value="{{ $item->id }}"
                                                {{ request()->query('pembelian') && request()->query('pembelian') == $item->id ? 'selected' : '' }}>
                                                {{ $item->kode }}
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

                            <div class="form-group row" style="margin-bottom: 1em;">
                                <div class="col-md-6">
                                    <label for="matauang" class="control-label">Mata uang</label>
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

                                <div class="col-md-6">
                                    <label for="jenis_pembayaran">Jenis Pembayaran</label>
                                    <select name="jenis_pembayaran" id="jenis_pembayaran" class="form-control">
                                        <option value="" selected>All</option>
                                        @foreach ($jenisPembayaran as $item)
                                            <option value="{{ $item->id }}"
                                                {{ request()->query('jenis_pembayaran') && request()->query('jenis_pembayaran') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fa fa-eye"></i> Cek
                            </button>
                            <a href="{{ route('pelunasan-hutang.laporan') }}"
                                class="btn btn-sm btn-default{{ request()->query() ? '' : ' disabled' }}">
                                <i class="fa fa-trash"></i> Reset
                            </a>
                            @if (count($laporan) > 0)
                                <a href="{{ route('pelunasan-hutang.pdf', request()->query()) }}" target="_blank"
                                    class="btn btn-sm btn-info">
                                    <i class="fa fa-print"></i> Print
                                </a>
                            @endif
                        </form>

                        <table class="table table-striped table-condensed data-table" style="margin-top: 1em;">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode</th>
                                    <th>Kode Pembelian</th>
                                    <th>Supplier</th>
                                    <th>Jenis Pembayaran</th>
                                    <th>Nilai</th>
                                    <th>Rate</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $total_nilai = 0;
                                    $grand_total = 0;
                                @endphp
                                @forelse ($laporan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->pembelian->kode }}</td>
                                        <td>{{ $item->pembelian->supplier ? $item->pembelian->supplier->nama_supplier : 'Tanpa Supplier' }}
                                        </td>
                                        <td>
                                            {{ $item->jenis_pembayaran }}
                                            @if ($item->jenis_pembayaran == 'Transfer')
                                                <br>
                                                Bank: {{ $item->bank->nama }}
                                                <br>
                                                Rekening:
                                                {{ $item->rekening_bank->nomor_rekening . ' - ' . $item->rekening_bank->nama_rekening }}
                                            @endif

                                            @if ($item->jenis_pembayaran == 'Giro')
                                                <br>
                                                No Cek/Giro: {{ $item->no_cek_giro }}
                                                <br>
                                                Tgl Cek/Giro:
                                                {{ $item->tgl_cek_giro }}
                                            @endif
                                        </td>
                                        <td>{{ $item->pembelian->matauang->kode . ' ' . number_format($item->bayar) }}
                                        </td>
                                        <td>{{ $item->rate }}</td>
                                        <td>{{ $item->pembelian->matauang->kode . ' ' . number_format($item->bayar * $item->rate) }}
                                        </td>
                                    </tr>
                                    @php
                                        $total_nilai += $item->bayar;
                                        $grand_total += $item->bayar * $item->rate;
                                    @endphp
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            {{-- @if ($laporan)
                                <tfoot>
                                    <tr>
                                        <th colspan="5">Total</th>
                                        <th colspan="2">{{ number_format($total_nilai) }}</th>
                                        <th>{{ number_format($grand_total) }}</th>
                                    </tr>
                                </tfoot>
                            @endif --}}
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
