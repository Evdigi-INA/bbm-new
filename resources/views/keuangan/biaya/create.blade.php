@extends('layouts.dashboard')

@section('title', trans('biaya.title.tambah'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('biaya_add') }}
        <!-- begin row -->
        <div class="row">
            <form action="{{ route('biaya.store') }}" method="post">
                @csrf
                @method('post')

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
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            @endif

                            <div class="form-group row" style="margin-bottom: 1em;">
                                <div class="col-md-3">
                                    <label for="kode" class="control-label">Kode</label>
                                    <input type="text" name="kode" class="form-control" placeholder="Kode" id="kode"
                                        readonly />
                                    @error('kode')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="tanggal" class="control-label">Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control" required
                                        value="{{ date('Y-m-d') }}" id="tanggal" />
                                    @error('tanggal')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="jenis_transaksi" class="control-label">Jenis Transaksi</label>
                                    <select name="jenis_transaksi" class="form-control" id="jenis_transaksi" required>
                                        @foreach ($jenisTransaksi as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('jenis_transaksi')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="kas_bank" class="control-label">Kas/Bank</label>
                                    <select name="kas_bank" class="form-control" id="kas_bank" required>
                                        {{-- sama kaya dicairkan ke: bank/kas --}}
                                        @foreach ($dicairkanKe as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('kas_bank')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label for="bank" class="control-label">Bank</label>
                                    <select name="bank" class="form-control" id="bank" disabled>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        @foreach ($bank as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('bank')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="rekening" class="control-label">Rekening</label>
                                    <select name="rekening" class="form-control" id="rekening" disabled>
                                        <option value="" selected disabled>-- Plih bank terlebih dahulu --</option>
                                    </select>
                                    @error('rekening')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="matauang" class="control-label">Mata uang</label>
                                    <select name="matauang" class="form-control" id="matauang" required>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        @foreach ($matauang as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('matauang')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="rate" class="control-label">Rate</label>
                                    <input type="number" name="rate" class="form-control" placeholder="Rate" id="rate"
                                        required />
                                    @error('rate')
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
                            <h4 class="panel-title">{{ trans('biaya.title.detail_info') }}</h4>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="alert alert-info mb-3" role="alert">
                                        <strong style="font-size: 20px" id="grand_total">
                                            GRANDTOTAL: 0,-
                                        </strong>
                                        <input type="hidden" name="grand_total" id="grand_total_input">
                                    </div>

                                    <table class="table table-striped table-condensed" id="tbl_trx">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Jumlah</th>
                                                <th>Deskripsi</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>

                                    <button type="submit" id="btn_simpan" class="btn btn-sm btn-success"
                                        disabled>Simpan</button>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="jumlah" class="control-label">Jumlah</label>
                                        <input type="number" class="form-control" placeholder="Jumlah" id="jumlah" />
                                        @error('jumlah')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="deskripsi" class="control-label">Deskripsi</label>
                                        <textarea id="deskripsi" class="form-control" placeholder="Deskripsi"
                                            rows="5"></textarea>
                                        @error('deskripsi')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <input type="hidden" id="index_tr">

                                    <button type="button" class="btn btn-primary" id="btn_add" disabled>
                                        <i class="fa fa-plus"></i> Add
                                    </button>

                                    <button type="button" class="btn btn-info" id="btn_update" style="display: none"
                                        disabled>
                                        <i class="fa fa-save"></i> Update
                                    </button>

                                    <button type="button" class="btn btn-warning" id="btn_clear_form" disabled>
                                        <i class="fa fa-times"></i> Clear Form
                                    </button>
                                </div>
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

@include('keuangan.biaya.script.create-js')
