@extends('layouts.dashboard')

@section('title', trans('pelunasan_piutang.title.tambah'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('pelunasan_piutang_add') }}
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
                                        readonly />
                                    @error('kode')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="tanggal" class="control-label">Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control" required
                                        value="{{ date('Y-m-d') }}" id="tanggal" />
                                    @error('tanggal')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="rate" class="control-label">Rate</label>
                                    <input type="number" name="rate" class="form-control" placeholder="Rate" id="rate"
                                        autofocus required />
                                    @error('rate')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-12 -->

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
                            <h4 class="panel-title">{{ trans('pelunasan_piutang.title.tambah') }} - List</h4>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <table class="table table-striped table-condensed" id="tbl_trx">
                                        <thead>
                                            <tr>
                                                <th width="10">No.</th>
                                                <th>Kode Penjualan</th>
                                                <th>Tanggal</th>
                                                <th>Pelanggan</th>
                                                <th>Matauang</th>
                                                <th>Piutang</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="total_piutang" class="control-label">Total Piutang</label>
                                                <input type="text" id="total_piutang" name="total_piutang"
                                                    class="form-control" placeholder="Total Hutang" id="total_piutang"
                                                    disabled />

                                                <input type="hidden" id="total_piutang_hidden" name="total_piutang_hidden">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="kode_penjualan">Kode Penjualan</label>
                                        <select name="kode_penjualan" id="kode_penjualan" class="form-control" required>
                                            <option value="" disabled selected>-- Pilih --</option>
                                            @forelse ($penjualanBelumLunas as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->kode }}
                                                </option>
                                            @empty
                                                <option value="" disabled>Data tidak ditemukan</option>
                                            @endforelse
                                        </select>
                                        @error('penjualan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="tgl_penjualan" class="control-label">Tanggal penjualan</label>
                                        <input type="text" name="tgl_penjualan" class="form-control"
                                            placeholder="Tanggal penjualan" id="tgl_penjualan" readonly />
                                        @error('tgl_penjualan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="pelanggan" class="control-label">Pelanggan</label>
                                        <input type="text" name="pelanggan" class="form-control" placeholder="Pelanggan"
                                            id="pelanggan" readonly />
                                        @error('pelanggan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="piutang" class="control-label">Piutang</label>
                                        <input type="text" name="piutang" class="form-control" placeholder="Saldo piutang"
                                            id="piutang" readonly />
                                        @error('piutang')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="matauang" class="control-label">Mata Uang</label>
                                        <input type="text" name="matauang" class="form-control" placeholder="Mata Uang"
                                            id="matauang" readonly />
                                        @error('matauang')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <input type="hidden" id="index_tr">

                                    <button type="button" class="btn btn-primary" id="btn_add" disabled>
                                        <i class="fa fa-plus"></i> Add
                                    </button>

                                    <button type="button" class="btn btn-info" id="btn_update" style="display: none"
                                        data-index="">
                                        <i class="fa fa-save"></i> Update
                                    </button>

                                    <button type="button" class="btn btn-warning" id="btn_clear_form" disabled>
                                        <i class="fa fa-times"></i> Clear Form
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-12 -->

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
                            <h4 class="panel-title">{{ trans('pelunasan_piutang.title.payment_list') }}</h4>
                        </div>

                        <div class="panel-body">
                            <div class="form-group row" style="margin-bottom: 10px">
                                {{-- <form id="form_payment"> --}}
                                {{-- Jenis Pembayaran --}}
                                <div class="col-md-4">
                                    <label class="control-label">Jenis Pembayaran</label>

                                    <select name="jenis_pembayaran" id="jenis_pembayaran" class="form-control" required>
                                        @forelse ($jenisPembayaran as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @empty
                                            <option value="" disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                    @error('jenis_pembayaran')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Bank</label>

                                    <select name="bank" id="bank" class="form-control" disabled>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        @forelse ($bank as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @empty
                                            <option value="" disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                    @error('bank')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Rekening</label>
                                    <select name="rekening" id="rekening" class="form-control" disabled>
                                        <option value="" disabled selected>-- Pilih Bank Terlebih Dahulu --</option>
                                    </select>
                                    @error('rekening')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- No. Cek/Giro --}}
                                <div class="col-md-4" style="margin-top: 1em;">
                                    <label for="no_cek_giro">No. Cek/Giro </label>
                                    <input type="number" step="any" name="no_cek_giro" id="no_cek_giro"
                                        class="form-control" placeholder="No. Cek/Giro " disabled />
                                    @error('no_cek_giro')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Tgl. Cek/Giro --}}
                                <div class="col-md-4" style="margin-top: 1em;">
                                    <label for="tgl_cek_giro">Tgl. Cek/Giro</label>
                                    <input type="date" name="tgl_cek_giro" id="tgl_cek_giro" class="form-control"
                                        placeholder="Tgl. Cek/Giro" disabled />
                                    @error('tgl_cek_giro')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Bayar --}}
                                <div class="col-md-4" style="margin-top: 1em;">
                                    <label for="bayar">Bayar</label>
                                    <input type="number" step="any" name="bayar" id="bayar" class="form-control" required
                                        placeholder="Bayar" />
                                    @error('bayar')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- keterangan --}}
                                <div class="col-md-12" style="margin-top: 1em;">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control" required
                                        placeholder="Keterangan" rows="5"></textarea>
                                    @error('keterangan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12" style="margin-top: 1em;">
                                    <button type="submit" id="btn_simpan" class="btn btn-sm btn-success"
                                        disabled>Simpan</button>
                                    {{-- <a href="{{ route('pelunasan-piutang.index') }}" class="btn btn-sm btn-default">
                                            Cancel
                                        </a> --}}
                                </div>
                                {{-- </form> --}}
                            </div>
                        </div>
                        {{-- end panel-body --}}
                    </div>
                    {{-- panel-inverse --}}
                </div>
                {{-- end col-md-12 --}}
            </form>
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->
@endsection

@include('keuangan.pelunasan.piutang.script.create-js')
