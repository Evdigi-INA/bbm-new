@extends('layouts.dashboard')

@section('title', trans('direct_sales.title.tambah'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('direct_sales_add') }}
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
                        <h4 class="panel-title">{{ trans('direct_sales.title.tambah') }} - Header</h4>
                    </div>

                    <div class="panel-body">
                        <form>
                            <div class="form-group row">
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label class="control-label">Mata Uang</label>
                                    <select name="matauang" id="matauang" class="form-control" required>
                                        @forelse ($matauang as $item)
                                            <option value="{{ $item->id }}">{{ $item->kode }}</option>
                                        @empty
                                            <option value="" disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label class="control-label">Pelanggan</label>
                                    <select name="pelanggan" id="pelanggan" class="form-control" required>
                                        <option value="" selected disabled>-- Pilih --</option>
                                        @forelse ($pelanggan as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_pelanggan }}</option>
                                        @empty
                                            <option value="" disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label class="control-label">Gudang</label>
                                    <select name="gudang" id="gudang" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        @forelse ($gudang as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @empty
                                            <option value="" disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                </div>

                                {{-- Bentuk stok --}}
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label for="bentuk_kepemilikan">Bentuk Stok</label>
                                    <select name="bentuk_kepemilikan" id="bentuk_kepemilikan" class="form-control"
                                        required>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        <option value="Stok Sendiri">Stok Sendiri</option>
                                        <option value="Konsinyasi">Konsinyasi</option>
                                    </select>
                                </div>
                            </div>
                        </form>

                        <hr style="margin-top: 1em; margin-bottom: 0;">

                        <div class="row">
                            <div class="col-md-6">
                                <h4>List Barang</h4>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="search" name="search"
                                        placeholder="Cari Barang...">
                                </div>
                                <div class="row" id="list-barang">

                                </div>
                            </div>

                            <div class="col-md-6">
                                <h4>Cart</h4>
                                <div class="alert alert-info mb-3" role="alert">
                                    <strong style="font-size: 20px" id="grand_total">
                                        GRAND TOTAL: 0,-
                                    </strong>
                                    <input type="hidden" name="grand_total" id="grand_total_input">
                                </div>

                                <div class="table-responsive" style="margin-bottom: 1em;">
                                    <table class="table table-striped table-condensed table-responsive" id="tbl_trx"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th width="5">#</th>
                                                <th>Barang</th>
                                                <th>Qty</th>
                                                <th>Subtotal</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>

                                <button class="btn btn-danger" id="btn_clear_table" disabled>Batal</button>

                                <button class="btn btn-success" id="btn_simpan" disabled>Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Cart <span id="hash"></span>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_barang_modal">Barang</label>
                        <input type="text" class="form-control" id="nama_barang_modal" disabled>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="harga_modal">Harga</label>
                                <input type="number" class="form-control" id="harga_modal">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="qty_modal">Qty</label>
                                <input type="number" class="form-control" id="qty_modal">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="diskon_persen_modal">Diskon%</label>
                                <input type="number" class="form-control" min="0" id="diskon_persen_modal">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="diskon_modal">Diskon</label>
                                <input type="number" class="form-control" id="diskon_modal" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gross_modal">Gross</label>
                                <input type="number" class="form-control" id="gross_modal" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ppn_modal">PPN</label>
                                <input type="checkbox" id="checkbox_ppn">
                                <input type="number" class="form-control" id="ppn_modal" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="netto_modal">Netto</label>
                        <input type="text" class="form-control" id="netto_modal" disabled>
                        <input type="hidden" id="tr_index">
                        <input type="hidden" id="stok_modal">
                        <input type="hidden" id="id_barang_modal">
                        <input type="hidden" id="matauang_modal">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn_update">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-css')
    <style>
        .col-md-4:nth-child(3n+1) {
            clear: left;
        }

        #list-barang {
            max-height: 485px;
            overflow-y: auto;
        }

        .p_nama_barang {
            margin-bottom: 0;
            /* line-height: 10px; */
            /* font-weight: bold; */
        }

        .card {
            -webkit-transition-duration: 0.3s;
            transition-duration: 0.3s;
            -webkit-transition-property: transform;
            transition-property: transform;
            -webkit-transition-timing-function: ease-out;
            transition-timing-function: ease-out;
            cursor: grab;
            margin-bottom: 1em;
        }

        /* On mouse-over, add a deeper shadow */
        .card:hover {
            -webkit-transform: translateY(5px);
            transform: translateY(5px);
        }

    </style>
@endpush

@include('penjualan.direct.script.create-js')
