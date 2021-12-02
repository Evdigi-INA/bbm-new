@extends('layouts.dashboard')

@section('title', trans('biaya.title.show'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('biaya_show') }}
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
                        <h4 class="panel-title">{{ trans('biaya.title.header_entry') }}</h4>
                    </div>

                    <div class="panel-body">
                        <div class="form-group row" style="margin-bottom: 1em;">
                            <div class="col-md-3">
                                <label for="kode" class="control-label">Kode</label>
                                <input type="text" name="kode" class="form-control" placeholder="Kode" id="kode"
                                    value="{{ $biaya->kode }}" disabled />
                            </div>

                            <div class="col-md-3">
                                <label for="tanggal" class="control-label">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" disabled
                                    value="{{ $biaya->tanggal->format('Y-m-d') }}" id="tanggal" />
                            </div>

                            <div class="col-md-3">
                                <label for="jenis_transaksi" class="control-label">Jenis Transaksi</label>
                                <select name="jenis_transaksi" class="form-control" id="jenis_transaksi" disabled>
                                    <option value="" disabled selected>{{ $biaya->jenis_transaksi }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="kas_bank" class="control-label">Kas/Bank</label>
                                <select name="kas_bank" class="form-control" id="kas_bank" disabled>
                                    <option value="" disabled selected>{{ $biaya->kas_bank }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-3">
                                <label for="bank" class="control-label">Bank</label>
                                <select name="bank" class="form-control" id="bank" disabled>
                                    <option value="" disabled selected>{{ $biaya->bank ? $biaya->bank->nama : '-' }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="rekening" class="control-label">Rekening</label>
                                <select name="rekening" class="form-control" id="rekening" disabled>
                                    <option value="" disabled selected>
                                        {{ $biaya->rekening ? $biaya->rekening->nomor_rekening . ' - ' . $biaya->rekening->nama_rekening : '-' }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="matauang" class="control-label">Mata uang</label>
                                <select name="matauang" class="form-control" id="matauang" disabled>
                                    <option value="" disabled selected>{{ $biaya->matauang->nama }}</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="rate" class="control-label">Rate</label>
                                <input type="number" name="rate" class="form-control" placeholder="Rate" id="rate"
                                    value="{{ $biaya->rate }}" disabled />
                            </div>

                            {{-- keterangan --}}
                            <div class="col-md-12" style="margin-top: 1em;">
                                <label for="keterangan">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" class="form-control" disabled
                                    placeholder="Keterangan" rows="5">{{ $biaya->keterangan }}</textarea>
                            </div>
                        </div>

                        <hr>
                        <h4>Detail</h4>

                        <table class="table table-striped table-condensed" id="tbl_trx">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Deskripsi</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($biaya->biaya_detail as $detail)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $detail->deskripsi }}
                                            <input type="hidden" class="deskripsi_hidden" name="deskripsi[]"
                                                value="{{ $detail->deskripsi }}">
                                        </td>
                                        <td>
                                            {{ $biaya->matauang->kode . ' ' . number_format($detail->jumlah) }}
                                            <input type="hidden" class="jumlah_hidden" name="jumlah[]"
                                                value="{{ $detail->jumlah }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2">Grandtotal</th>
                                    <th>{{ $biaya->matauang->kode . ' ' . number_format($biaya->total) }}</th>
                                </tr>
                            </tfoot>
                        </table>

                        <a href="{{ route('biaya.index') }}" class="btn btn-sm btn-default">Kembali</a>
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
