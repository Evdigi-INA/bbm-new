@extends('layouts.dashboard')

@section('title', trans('pelunasan_piutang.title.show'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('pelunasan_piutang_show') }}
        <!-- begin row -->
        <div class="row">
            <form>
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
                            <h4 class="panel-title">{{ trans('pelunasan_piutang.title.tambah') }} - Header</h4>
                        </div>

                        <div class="panel-body">
                            <div class="form-group row" style="margin-bottom: 1em;">
                                <div class="col-md-4">
                                    <label for="kode" class="control-label">Kode</label>
                                    <input type="text" name="kode" class="form-control" placeholder="Kode" id="kode"
                                        value="{{ $pelunasanPiutang->kode }}" readonly />
                                </div>

                                <div class="col-md-4">
                                    <label for="tanggal" class="control-label">Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control" required
                                        value="{{ $pelunasanPiutang->tanggal->format('Y-m-d') }}" id="tanggal" disabled />
                                </div>

                                <div class="col-md-4">
                                    <label for="rate" class="control-label">Rate</label>
                                    <input type="number" name="rate" class="form-control" placeholder="Rate" id="rate"
                                        value="{{ $pelunasanPiutang->rate }}" required disabled />
                                </div>
                            </div>

                            <hr>

                            <h4>{{ trans('pelunasan_piutang.title.item_list') }}</h4>

                            <div class="table-responsive">
                                <table class="table table-striped table-condensed" id="tbl_trx">
                                    <thead>
                                        <tr>
                                            <th width="10">No.</th>
                                            <th>Kode Penjualan</th>
                                            <th>Tanggal</th>
                                            <th>Pelanggan</th>
                                            <th>Matauang</th>
                                            <th>Piutang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total_piutang = 0;
                                        @endphp
                                        @foreach ($pelunasanPiutang->pelunasan_piutang_detail as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    {{ $item->penjualan->kode }}
                                                </td>
                                                <td>
                                                    {{ $item->penjualan->tanggal->format('d/m/Y') }}
                                                </td>
                                                <td>
                                                    {{ $item->penjualan->pelanggan ? $item->penjualan->pelanggan->nama_pelanggan : '-' }}
                                                </td>
                                                <td> {{ $item->penjualan->matauang->nama }}
                                                </td>
                                                <td> {{ number_format($item->penjualan->total_netto) }}
                                                </td>
                                            </tr>
                                            @php
                                                $total_piutang += $item->penjualan->total_netto;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5">Total</th>
                                            <th>{{ number_format($total_piutang) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <hr>

                            <h4>{{ trans('pelunasan_piutang.title.payment_list') }}</h4>

                            <div class="form-group row" style="margin-bottom: 10px">
                                {{-- Jenis Pembayaran --}}
                                <div class="col-md-4">
                                    <label class="control-label">Jenis Pembayaran</label>
                                    <select name="jenis_pembayaran" id="jenis_pembayaran" class="form-control" readonly>
                                        <option value="{{ $pelunasanPiutang->jenis_pembayaran }}">
                                            {{ $pelunasanPiutang->jenis_pembayaran }}
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Bank</label>
                                    <select name="bank" id="bank" class="form-control" readonly>
                                        <option
                                            value="{{ $pelunasanPiutang->bank ? $pelunasanPiutang->bank->nama : '' }}">
                                            {{ $pelunasanPiutang->bank ? $pelunasanPiutang->bank->nama : '-' }}
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Rekening</label>
                                    <select name="rekening" id="rekening" class="form-control" readonly>
                                        <option
                                            value="{{ $pelunasanPiutang->rekening_bank ? $pelunasanPiutang->rekening_bank->nomor_rekening . ' - ' . $pelunasanPiutang->rekening_bank->nama_rekening : '' }}">
                                            {{ $pelunasanPiutang->rekening_bank ? $pelunasanPiutang->rekening_bank->nomor_rekening . ' - ' . $pelunasanPiutang->rekening_bank->nama_rekening : '-' }}
                                        </option>
                                    </select>
                                </div>

                                {{-- No. Cek/Giro --}}
                                <div class="col-md-4" style="margin-top: 1em;">
                                    <label for="no_cek_giro">No. Cek/Giro </label>
                                    <input type="number" step="any" name="no_cek_giro" id="no_cek_giro"
                                        class="form-control" placeholder="No. Cek/Giro " readonly
                                        value="{{ $pelunasanPiutang->no_cek_giro }}" />
                                </div>

                                {{-- Tgl. Cek/Giro --}}
                                <div class="col-md-4" style="margin-top: 1em;">
                                    <label for="tgl_cek_giro">Tgl. Cek/Giro</label>
                                    <input type="date" name="tgl_cek_giro" id="tgl_cek_giro" class="form-control"
                                        placeholder="Tgl. Cek/Giro" value="{{ $pelunasanPiutang->tgl_cek_giro }}"
                                        readonly />
                                </div>

                                {{-- Bayar --}}
                                <div class="col-md-4" style="margin-top: 1em;">
                                    <label for="bayar">Bayar</label>
                                    <input type="text" name="bayar" id="bayar" class="form-control" placeholder="Bayar"
                                        value="{{ number_format($pelunasanPiutang->bayar) }}" readonly />
                                </div>

                                {{-- keterangan --}}
                                <div class="col-md-12" style="margin-top: 1em;">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control" readonly
                                        placeholder="Keterangan" rows="5">{{ $pelunasanPiutang->keterangan }}</textarea>
                                </div>

                                <div class="col-md-12" style="margin-top: 1em;">
                                    <a href="{{ route('pelunasan-piutang.index') }}"
                                        class="btn btn-sm btn-default">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-12 -->
            </form>
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->
@endsection
