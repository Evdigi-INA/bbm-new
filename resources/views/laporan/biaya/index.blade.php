@extends('layouts.dashboard')

@section('title', trans('dashboard.laporan.biaya'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('laporan_biaya') }}
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
                        <h4 class="panel-title">{{ trans('dashboard.laporan.biaya') }}</h4>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('biaya.laporan') }}" method="GET" style="margin-bottom: 1em;">
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
                                    <label for="kas_bank" class="control-label">Kas/Bank</label>
                                    <select name="kas_bank" class="form-control" id="kas_bank">
                                        <option value="">All</option>
                                        <option value="Kas" {{ request()->query('kas_bank') == 'Kas' ? 'selected' : '' }}>
                                            Kas</option>
                                        @foreach ($bank as $item)
                                            <option value="{{ $item->id }}"
                                                {{ request()->query('kas_bank') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fa fa-eye"></i> Cek
                            </button>
                            <a href="{{ route('biaya.laporan') }}"
                                class="btn btn-sm btn-default{{ request()->query() ? '' : ' disabled' }}">
                                <i class="fa fa-trash"></i> Reset
                            </a>
                            @if (count($laporan) > 0)
                                <a href="{{ route('biaya.pdf', request()->query()) }}" target="_blank"
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
                                    <th>Jenis Transaksi</th>
                                    <th>Kas/Bank</th>
                                    <th>Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $grand_total = 0;
                                    $total_jumlah = 0;
                                @endphp
                                @forelse ($laporan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->tanggal->format('d F Y') }}</td>
                                        <td>{{ $item->jenis_transaksi }}</td>
                                        <td>
                                            {{ $item->kas_bank }}
                                            @if ($item->kas_bank == 'Bank')
                                                <br>
                                                {{ $item->bank->nama }}
                                                <br>
                                                Rekening:
                                                {{ $item->rekening->nomor_rekening . ' - ' . $item->rekening->nama_rekening }}
                                            @endif
                                        </td>
                                        <th>{{ $item->rate }}</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th colspan="2">Deskripsi</th>
                                        <th>Jumlah</th>
                                        <th colspan="2">Subtotal</th>
                                    </tr>
                                    @foreach ($item->biaya_detail as $detail)
                                        <tr>
                                            <td></td>
                                            <td colspan="2">{{ $detail->deskripsi }}</td>
                                            <td>
                                                @if ($item->jenis_transaksi == 'Pengeluaran')
                                                    -
                                                @endif
                                                {{ $item->matauang->kode . ' ' . number_format($detail->jumlah) }}
                                            </td>
                                            <td colspan="2">
                                                @if ($item->jenis_transaksi == 'Pengeluaran')
                                                    -
                                                @endif
                                                {{ $item->matauang->kode . ' ' . number_format($detail->jumlah * $item->rate) }}
                                            </td>
                                        </tr>
                                        @php
                                            $total_jumlah += $detail->jumlah;
                                            $grand_total += $detail->jumlah * $item->rate;
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <th></th>
                                        <th colspan="2">Total</th>
                                        <th>
                                            @if ($item->jenis_transaksi == 'Pengeluaran')
                                                -
                                            @endif
                                            {{ $item->matauang->kode . ' ' . number_format($total_jumlah) }}
                                        </th>
                                        <th colspan="2">
                                            @if ($item->jenis_transaksi == 'Pengeluaran')
                                                -
                                            @endif
                                            {{ $item->matauang->kode . ' ' . number_format($grand_total) }}
                                        </th>
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
