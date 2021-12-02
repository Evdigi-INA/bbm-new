@extends('layouts.dashboard')

@section('title', trans('adjustment_minus.title.tambah'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('adjustment_minus_add') }}
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
                        <h4 class="panel-title">{{ trans('adjustment_minus.title.tambah') }} - Header</h4>
                    </div>

                    <div class="panel-body">
                        <form action="{{ route('adjustment-minus.store') }}" method="POST">
                            @csrf

                            <div class="form-group row" style="margin-bottom: 10px">
                                <div class="col-md-4">
                                    <label class="control-label">Kode</label>

                                    <input type="text" name="kode" class="form-control" placeholder="Kode" id="kode"
                                        required readonly />
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Tanggal</label>

                                    <input type="date" name="tanggal" class="form-control" required
                                        value="{{ date('Y-m-d') }}" />
                                </div>

                                <div class="col-md-4 mt-3">
                                    <label class="control-label">Gudang</label>

                                    <select name="gudang" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        @forelse ($gudang as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @empty
                                            <option value="" disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                        </form>
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
                        <h4 class="panel-title">{{ trans('adjustment_minus.title.tambah') }} - List</h4>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-9">

                                <table class="table table-striped table-condensed" id="tbl_trx">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Kode - Nama Barang</th>
                                            <th>Supplier</th>
                                            <th>Bentuk Kep.</th>
                                            <th>Qty</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>

                                <button class="btn btn-success" id="btn_simpan" disabled>Simpan</button>

                                <button class="btn btn-danger" id="btn_clear_table" disabled>Batal</button>
                            </div>

                            {{-- Form barang --}}
                            <div class="col-md-3">
                                <form id="form_trx" method="POST">
                                    <div class="form-group">
                                        <label for="kode_barang">Nama Barang</label>
                                        <select name="kode_barang" id="kode_barang_input" class="form-control" required>
                                            <option value="" disabled selected>-- Pilih --</option>
                                            @forelse ($barang as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->kode . ' - ' . $item->nama }}
                                                </option>
                                            @empty
                                                <option value="" disabled>Data tidak ditemukan</option>
                                            @endforelse
                                        </select>
                                    </div>

                                    {{-- stok --}}
                                    <div class="form-group">
                                        <label for="stok">Stok</label>
                                        <input type="number" name="stok" id="stok_input" class="form-control" min="1"
                                            placeholder="Stok" disabled />
                                    </div>

                                    {{-- Supplier --}}
                                    <div class="form-group">
                                        <label for="supplier_input">Supplier</label>
                                        <select id="supplier_input" class="form-control" required>
                                            @forelse ($supplier as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->nama_supplier }}
                                                </option>
                                            @empty
                                                <option value="" disabled>Data tidak ditemukan</option>
                                            @endforelse
                                        </select>
                                    </div>

                                    {{-- Bentuk stok --}}
                                    <div class="form-group">
                                        <label for="bentuk_kepemilikan_input">Bentuk Kepemilikan Stok</label>
                                        <select name="bentuk_kepemilikan_input" id="bentuk_kepemilikan_input"
                                            class="form-control" required>
                                            <option value="" disabled selected>-- Pilih --</option>
                                            <option value="Stok Sendiri">Stok Sendiri</option>
                                            <option value="Konsinyasi">Konsinyasi</option>
                                        </select>
                                    </div>

                                    {{-- Qty --}}
                                    <div class="form-group">
                                        <label for="qty">Qty</label>
                                        <input type="number" name="qty" id="qty_input" class="form-control"
                                            placeholder="Qty" min="1" />
                                    </div>

                                    <input type="hidden" id="index_tr">

                                    <button type="submit" class="btn btn-primary" id="btn_add">
                                        <i class="fa fa-plus"></i> Add
                                    </button>

                                    <button type="button" class="btn btn-info" id="btn_update" style="display: none"
                                        data-index="">
                                        <i class="fa fa-save"></i> Update
                                    </button>

                                    <button type="button" class="btn btn-warning" id="btn_clear_form">
                                        <i class="fa fa-times"></i> Clear Form
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end panel -->
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->
    <input type="hidden" id="stok">
    <input type="hidden" id="min_stok">
@endsection

@include('inventory.adjustment-minus.script.create-js')
