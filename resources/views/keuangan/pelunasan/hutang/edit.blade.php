@extends('layouts.dashboard')

@section('title', trans('pelunasan_hutang.title.edit'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('pelunasan_hutang_edit') }}
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
                            <h4 class="panel-title">{{ trans('pelunasan_hutang.title.tambah') }} - Header</h4>
                        </div>

                        <div class="panel-body">
                            <div class="form-group row" style="margin-bottom: 1em;">
                                <div class="col-md-4">
                                    <label for="kode" class="control-label">Kode</label>
                                    <input type="text" name="kode" class="form-control" placeholder="Kode" id="kode"
                                        value="{{ $pelunasanHutang->kode }}" readonly />
                                </div>

                                <div class="col-md-4">
                                    <label for="tanggal" class="control-label">Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control" required
                                        value="{{ $pelunasanHutang->tanggal->format('Y-m-d') }}" id="tanggal" disabled />
                                </div>

                                <div class="col-md-4">
                                    <label for="rate" class="control-label">Rate</label>
                                    <input type="number" name="rate" class="form-control" placeholder="Rate" id="rate"
                                        value="{{ $pelunasanHutang->rate }}" required disabled />
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
                            <h4 class="panel-title">{{ trans('pelunasan_hutang.title.tambah') }} - List</h4>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <table class="table table-striped table-condensed" id="tbl_trx">
                                        <thead>
                                            <tr>
                                                <th width="10">No.</th>
                                                <th>Kode Pembelian</th>
                                                <th>Tanggal</th>
                                                <th>Supplier</th>
                                                <th>Matauang</th>
                                                <th>Hutang</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pelunasanHutang->pelunasan_hutang_detail as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        {{ $item->pembelian->kode }}
                                                        <input type="hidden" class="kode_pembelian_hidden"
                                                            name="kode_pembelian[]" value="{{ $item->pembelian->id }}">
                                                    </td>
                                                    <td>
                                                        {{ $item->pembelian->tanggal->format('d/m/Y') }}
                                                        <input type="hidden" class="tgl_pembelian_hidden"
                                                            name="tgl_pembelian[]"
                                                            value="{{ $item->pembelian->tanggal->format('d/m/Y') }}">
                                                    </td>
                                                    <td>
                                                        {{ $item->pembelian->supplier ? $item->pembelian->supplier->nama_supplier : '-' }}
                                                        <input type="hidden" class="supplier_hidden" name="supplier[]"
                                                            value="{{ $item->pembelian->supplier ? $item->pembelian->supplier->nama_supplier : '-' }}">
                                                    </td>
                                                    <td> {{ $item->pembelian->matauang->nama }}
                                                        <input type="hidden" class="matauang_hidden" name="matauang[]"
                                                            value="{{ $item->pembelian->matauang->nama }}">
                                                    </td>
                                                    <td> {{ number_format($item->pembelian->total_netto) }}
                                                        <input type="hidden" class="hutang_hidden" name="hutang[]"
                                                            value="{{ $item->pembelian->total_netto }}">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-xs btn_edit">
                                                            <i class="fa fa-edit"></i>
                                                        </button>

                                                        <button type="button" class="btn btn-danger btn-xs btn_hapus">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="total_hutang" class="control-label">Total Hutang</label>
                                                <input type="text" id="total_hutang" name="total_hutang"
                                                    class="form-control" placeholder="Total Hutang" id="total_hutang"
                                                    disabled />

                                                <input type="hidden" id="total_hutang_hidden" name="total_hutang_hidden">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="pembelian">Kode Pembelian</label>
                                        <select name="pembelian" id="kode_pembelian" class="form-control" required>
                                            <option value="" disabled selected>-- Pilih --</option>
                                            @forelse ($pembelianBelumLunas as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->kode }}
                                                </option>
                                            @empty
                                                <option value="" disabled>Data tidak ditemukan</option>
                                            @endforelse
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="tgl_pembelian" class="control-label">Tanggal Pembelian</label>
                                        <input type="text" name="tgl_pembelian" class="form-control"
                                            placeholder="Tanggal Pembelian" id="tgl_pembelian" readonly />
                                    </div>

                                    <div class="form-group">
                                        <label for="matauang" class="control-label">Mata Uang</label>
                                        <input type="text" name="matauang" class="form-control" placeholder="Mata Uang"
                                            id="matauang" readonly />
                                    </div>

                                    <div class="form-group">
                                        <label for="hutang" class="control-label">Hutang</label>
                                        <input type="text" name="hutang" class="form-control" placeholder="Hutang"
                                            id="hutang" readonly />
                                    </div>

                                    <div class="form-group">
                                        <label for="supplier" class="control-label">Supplier</label>
                                        <input type="text" name="supplier" class="form-control" placeholder="Supplier"
                                            id="supplier" readonly />
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
                            <h4 class="panel-title">{{ trans('pelunasan_hutang.title.payment_list') }}</h4>
                        </div>

                        <div class="panel-body">
                            <div class="form-group row" style="margin-bottom: 10px">
                                {{-- Jenis Pembayaran --}}
                                <div class="col-md-4">
                                    <label class="control-label">Jenis Pembayaran</label>
                                    <select name="jenis_pembayaran" id="jenis_pembayaran" class="form-control" required>
                                        @forelse ($jenisPembayaran as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $pelunasanHutang->jenis_pembayaran == $item->nama ? 'selected' : '' }}>
                                                {{ $item->nama }}</option>
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
                                            <option value="{{ $item->id }}"
                                                {{ $pelunasanHutang->bank && $pelunasanHutang->bank->id == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}</option>
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
                                        class="form-control" placeholder="No. Cek/Giro " disabled
                                        value="{{ $pelunasanHutang->no_cek_giro }}" />
                                    @error('no_cek_giro')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Tgl. Cek/Giro --}}
                                <div class="col-md-4" style="margin-top: 1em;">
                                    <label for="tgl_cek_giro">Tgl. Cek/Giro</label>
                                    <input type="date" name="tgl_cek_giro" id="tgl_cek_giro" class="form-control"
                                        placeholder="Tgl. Cek/Giro" value="{{ $pelunasanHutang->tgl_cek_giro }}"
                                        disabled />
                                    @error('tgl_cek_giro')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Bayar --}}
                                <div class="col-md-4" style="margin-top: 1em;">
                                    <label for="bayar">Bayar</label>
                                    <input type="number" step="any" name="bayar" id="bayar" class="form-control" required
                                        placeholder="Bayar" value="{{ $pelunasanHutang->bayar }}" />
                                    @error('bayar')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- keterangan --}}
                                <div class="col-md-12" style="margin-top: 1em;">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control" required
                                        placeholder="Keterangan" rows="5">{{ $pelunasanHutang->keterangan }}</textarea>
                                    @error('keterangan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12" style="margin-top: 1em;">
                                    <button type="submit" id="btn_simpan" class="btn btn-sm btn-success">Simpan</button>
                                </div>
                            </div>
                        </div>
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
@include('keuangan.pelunasan.hutang.script.edit-js')
