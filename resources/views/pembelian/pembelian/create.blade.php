@extends('layouts.dashboard')

@section('title', trans('pembelian.title.tambah'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('pembelian_add') }}
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
                                <i class="fa fa-plus"></i>
                            </a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger"
                                data-click="panel-remove">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                        <h4 class="panel-title">{{ trans('pembelian.title.tambah') }} - Header</h4>
                    </div>

                    <div class="panel-body">
                        <form>
                            <div class="form-group row" style="margin-bottom: 10px">
                                <div class="col-md-3">
                                    <label class="control-label">Kode</label>
                                    <input type="text" name="kode" class="form-control" placeholder="Kode" id="kode"
                                        required readonly />
                                </div>

                                <div class="col-md-3">
                                    <label class="control-label">Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control" required
                                        value="{{ date('Y-m-d') }}" />
                                </div>

                                <div class="col-md-3">
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
                                {{-- end col-md-3 --}}

                                <div class="col-md-3">
                                    <label class="control-label">Kode P.O</label>
                                    <select name="kode_po" id="kode_po" class="form-control" required>
                                        <option value="" selected>Tanpa P.O</option>
                                        @forelse ($pesananPembelian as $item)
                                            <option value="{{ $item->id }}">{{ $item->kode }}</option>
                                        @empty
                                            <option value="" disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="control-label">Supplier</label>
                                    <select id="supplier" name="supplier" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        @forelse ($supplier as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_supplier }}</option>
                                        @empty
                                            <option value="" disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="control-label">Mata Uang</label>
                                    <select name="matauang" id="matauang" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        @forelse ($matauang as $item)
                                            <option value="{{ $item->id }}">{{ $item->kode }}</option>
                                        @empty
                                            <option value="" disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                </div>
                                {{-- end col-md-3 --}}

                                {{-- Bentuk stok --}}
                                <div class="col-md-3">
                                    <label for="bentuk_kepemilikan">Bentuk Kepemilikan Stok</label>
                                    <select name="bentuk_kepemilikan" id="bentuk_kepemilikan" class="form-control"
                                        required>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        <option value="Stok Sendiri">Stok Sendiri</option>
                                        <option value="Konsinyasi">Konsinyasi</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="control-label">Rate</label>
                                    <input type="number" step="any" name="rate" class="form-control" placeholder="Rate"
                                        required />
                                </div>
                            </div>

                            <div class="form-group" style="margin-top: 1em;">
                                <label class="control-label">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" rows="5" class="form-control"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-12 -->

            {{-- barang list --}}
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
                        <h4 class="panel-title">{{ trans('pembelian.title.tambah') }} - List</h4>
                    </div>

                    <div class="panel-body">
                        {{-- Form barang --}}
                        <form id="form_trx" method="POST">
                            <div class="row form-group">
                                {{-- barang --}}
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label for="kode_barang">Nama Barang</label>
                                    <select name="kode_barang" id="kode_barang_input" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Matauang Terlebih Dahulu--</option>
                                    </select>
                                </div>

                                {{-- Stok --}}
                                <div class="col-md-2" style="margin-bottom: 1em;">
                                    <label for="stok">Stok</label>
                                    <input type="number" step="any" name="stok" id="stok_input" class="form-control"
                                        disabled placeholder="Stok" />
                                </div>

                                {{-- Harga --}}
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label for="harga">Harga</label>
                                    <input type="number" step="any" name="harga" id="harga_input" class="form-control"
                                        required placeholder="Harga" />
                                </div>

                                {{-- Qty --}}
                                <div class="col-md-2" style="margin-bottom: 1em;">
                                    <label for="qty">Qty</label>
                                    <input type="number" step="any" name="qty" id="qty_input" class="form-control"
                                        required placeholder="Qty" />
                                </div>

                                {{-- Diskon% --}}
                                <div class="col-md-2" style="margin-bottom: 1em;">
                                    <label for="diskon_persen_input">Diskon%</label>
                                    <input type="number" step="any" name="diskon_persen_input" id="diskon_persen_input"
                                        class="form-control" placeholder="Diskon%" />
                                </div>

                                {{-- Diskon --}}
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label for="diskon">Diskon</label>
                                    <input type="number" step="any" name="diskon_input" id="diskon_input"
                                        class="form-control" readonly placeholder="0" />
                                </div>

                                {{-- Gross --}}
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label for="gross_input">Gross</label>
                                    <input type="number" step="any" name="gross" id="gross_input" class="form-control"
                                        readonly placeholder="0" />
                                </div>

                                {{-- ppn --}}
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label for="ppn">PPN</label>
                                    <input type="checkbox" id="checkbox_ppn" checked>
                                    <input type="number" step="any" name="ppn" id="ppn_input" class="form-control"
                                        readonly placeholder="0" />
                                </div>

                                {{-- PPH --}}
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label for="qty">PPH</label>
                                    <input type="checkbox" id="checkbox_pph" checked>
                                    <input type="number" step="any" name="pph" id="pph_input" class="form-control"
                                        readonly placeholder="0" />
                                </div>
                            </div>

                            <div class="row form-group">
                                {{-- Biaya Masuk --}}
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label for="biaya_masuk">Biaya Masuk</label>
                                    <input type="number" step="any" name="biaya_masuk" id="biaya_masuk_input"
                                        class="form-control" placeholder="Biaya Masuk" />
                                </div>

                                {{-- Clr. Fee --}}
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label for="clr_fee">Clr. Fee</label>
                                    <input type="number" step="any" name="clr_fee" id="clr_fee_input" class="form-control"
                                        placeholder="Clr. Fee" />
                                </div>

                                {{-- Netto --}}
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label for="netto">Netto</label>
                                    <input type="number" step="any" name="netto" id="netto_input" placeholder="0"
                                        class="form-control" value="0" readonly />
                                </div>

                                {{-- button --}}
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label>Button</label>
                                    <div class="form-control" style="border: none; padding:0">
                                        <input type="hidden" id="index_tr_brg">

                                        <button type="submit" class="btn btn-primary" id="btn_add_brg">
                                            <i class="fa fa-plus"></i> Add
                                        </button>

                                        <button type="button" class="btn btn-info" id="btn_update_brg"
                                            style="display: none" data-index="">
                                            <i class="fa fa-save"></i> Update
                                        </button>

                                        <button type="button" class="btn btn-warning" id="btn_clear_form_brg">
                                            <i class="fa fa-times"></i> Clear Form
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" style="margin-bottom: 1em;">
                                    <table class="table table-striped table-condensed table-responsive" id="tbl_trx"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Barang</th>
                                                <th>Harga</th>
                                                <th>Qty</th>
                                                <th>Disc%</th>
                                                <th>Disc</th>
                                                <th>Gross</th>
                                                <th>PPN</th>
                                                <th>PPH</th>
                                                <th>B. Msk</th>
                                                <th>Clr. Fee</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>

                                <div class="row form-group" id="total" style="margin-top: 1em;">
                                    {{-- subtotal --}}
                                    <div class="col-md-4">
                                        <label for="subtotal">Subtotal</label>
                                        <input type="text" step="any" name="subtotal" id="subtotal" class="form-control"
                                            placeholder="0" readonly />
                                    </div>

                                    {{-- Total PPH --}}
                                    <div class="col-md-4">
                                        <label for="total_pph">Total PPH</label>
                                        <input type="text" step="any" name="total_pph" id="total_pph"
                                            class="form-control" placeholder="0" readonly />
                                    </div>

                                    {{-- Total PPN --}}
                                    <div class="col-md-4">
                                        <label for="total_ppn">Total PPN</label>
                                        <input type="text" step="any" name="total_ppn" id="total_ppn"
                                            class="form-control" placeholder="0" readonly />
                                    </div>

                                    {{-- Total Diskon --}}
                                    <div class="col-md-4" style="margin-top: 1em;">
                                        <label for="total_diskon">Total Diskon</label>
                                        <input type="text" step="any" name="total_diskon" id="total_diskon"
                                            class="form-control" placeholder="0" readonly />
                                    </div>

                                    {{-- Total Biaya Masuk --}}
                                    <div class="col-md-4" style="margin-top: 1em;">
                                        <label for="total_biaya_masuk">Total Biaya Masuk</label>
                                        <input type="text" step="any" name="total_biaya_masuk" id="total_biaya_masuk"
                                            placeholder="0" class="form-control" readonly />
                                    </div>

                                    {{-- Total Gross --}}
                                    <div class="col-md-4" style="margin-top: 1em;">
                                        <label for="total_gross">Total Gross</label>
                                        <input type="text" step="any" name="total_gross" id="total_gross"
                                            class="form-control" placeholder="0" readonly />
                                    </div>

                                    {{-- Total Clr. Fee --}}
                                    <div class="col-md-4" style="margin-top: 1em;">
                                        <label for="total_clr_fee">Total Clr. Fee</label>
                                        <input type="text" step="any" name="total_clr_fee" id="total_clr_fee"
                                            class="form-control" placeholder="0" readonly />
                                    </div>

                                    {{-- Total Netto --}}
                                    <div class="col-md-4" style="margin-top: 1em;">
                                        <label for="total_netto">Total Netto</label>
                                        <input type="text" step="any" name="total_netto" id="total_netto"
                                            class="form-control" placeholder="0" readonly />
                                    </div>
                                </div>
                                {{-- end row form-group --}}
                            </div>
                            {{-- end col-md-12 --}}
                        </div>
                        {{-- end row --}}
                    </div>
                    {{-- end panel body --}}
                </div>
                <!-- end panel -->
            </div>
            {{-- end col-md-12 --}}

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
                        <h4 class="panel-title">{{ trans('pembelian.title.payment_list') }}</h4>
                    </div>

                    <div class="panel-body">
                        <div class="form-group row" style="margin-bottom: 10px">
                            <form id="form_payment">
                                {{-- Jenis Pembayaran --}}
                                <div class="col-md-4">
                                    <label class="control-label">Jenis Pembayaran</label>

                                    <select name="jenis_pembayaran" id="jenis_pembayaran_input" class="form-control"
                                        required>
                                        @forelse ($jenisPembayaran as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @empty
                                            <option value="" disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Bank</label>

                                    <select name="bank" id="bank_input" class="form-control" disabled>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        @forelse ($bank as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @empty
                                            <option value="" disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Rekening</label>

                                    <select name="rekening" id="rekening_input" class="form-control" disabled>
                                        <option value="" disabled selected>-- Pilih Bank Terlebih Dahulu --</option>
                                    </select>
                                </div>

                                {{-- No. Cek/Giro --}}
                                <div class="col-md-3" style="margin-top: 1em;">
                                    <label for="no_cek_giro">No. Cek/Giro </label>
                                    <input type="number" step="any" name="no_cek_giro" id="no_cek_giro_input"
                                        class="form-control" placeholder="No. Cek/Giro " disabled />
                                </div>

                                {{-- Tgl. Cek/Giro --}}
                                <div class="col-md-3" style="margin-top: 1em;">
                                    <label for="tgl_cek_giro">Tgl. Cek/Giro</label>
                                    <input type="date" step="any" name="tgl_cek_giro" id="tgl_cek_giro_input"
                                        class="form-control" placeholder="Tgl. Cek/Giro" disabled />
                                </div>

                                {{-- Bayar --}}
                                <div class="col-md-3" style="margin-top: 1em;">
                                    <label for="bayar">Bayar</label>
                                    <input type="number" step="any" name="bayar" id="bayar_input" class="form-control"
                                        required placeholder="Bayar" />
                                </div>

                                {{-- button --}}
                                <div class="col-md-3" style="margin-top: 1em;">
                                    <label>Button</label>
                                    <div class="form-control" style="border: none; padding:0">
                                        <input type="hidden" id="index_tr_payment">

                                        <button type="submit" class="btn btn-primary" id="btn_add_payment" disabled>
                                            <i class="fa fa-plus"></i> Add
                                        </button>

                                        <button type="button" class="btn btn-info" id="btn_update_payment"
                                            style="display: none" data-index="">
                                            <i class="fa fa-save"></i> Update
                                        </button>

                                        <button type="button" class="btn btn-warning" id="btn_clear_form_payment" disabled>
                                            <i class="fa fa-times"></i> Clear Form
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                            </div>

                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-condensed table-responsive" id="tbl_payment"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Jenis Pembayaran</th>
                                                <th>Bank</th>
                                                <th>Rekening</th>
                                                <th>No. Cek/Giro</th>
                                                <th>Tgl. Cek/Giro</th>
                                                <th>Bayar</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                        {{-- <tfoot>
                                            <tr>
                                                <th colspan="6"><strong>Total</strong></th>
                                                <th><strong id="total_payment">0</strong></th>
                                            </tr>
                                        </tfoot> --}}
                                    </table>
                                </div>

                                {{-- Total --}}
                                <div class="row form-group">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3"></div>

                                    <div class="col-md-3" style="margin-top: 1em;">
                                        <label for="total_payment">Total </label>
                                        <input type="text" step="any" name="total_payment" id="total_payment_input"
                                            class="form-control" readonly placeholder="0 " />
                                    </div>

                                    {{-- button --}}
                                    <div class="col-md-3" style="margin-top: 1em;">
                                        <label>Button</label>
                                        <div class="form-control" style="border: none; padding:0">
                                            <button class="btn btn-success" id="btn_simpan" disabled>Simpan</button>

                                            <button class="btn btn-danger" id="btn_clear_table" disabled>Batal</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- end col-md-12 --}}

                            {{-- <div class="col-md-12">

                            </div> --}}
                        </div>

                    </div>
                    {{-- end panel-body --}}
                </div>
                {{-- panel-inverse --}}
            </div>
            {{-- end col-md-12 --}}
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->
    <input type="hidden" id="stok">
    <input type="hidden" id="min_stok">
@endsection

@include('pembelian.pembelian.script.create-js')
