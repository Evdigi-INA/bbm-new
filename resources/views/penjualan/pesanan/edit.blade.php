@extends('layouts.dashboard')

@section('title', trans('pesanan_penjualan.title.edit'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('pesanan_penjualan_edit') }}
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
                        <h4 class="panel-title">{{ trans('pesanan_penjualan.title.edit') }} - Header</h4>
                    </div>

                    <div class="panel-body">
                        <form>
                            <div class="form-group row" style="margin-bottom: 10px">
                                <div class="col-md-4">
                                    <label class="control-label">Kode</label>

                                    <input type="text" name="kode" class="form-control" placeholder="Kode" id="kode"
                                        value="{{ $pesananPenjualan->kode }}" required readonly />
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control" required
                                        value="{{ date('Y-m-d') }}" readonly />
                                </div>

                                {{-- <div class="col-md-4">
                                    <label class="control-label">Gudang</label>
                                    <select name="gudang" id="gudang" class="form-control" required>
                                        @forelse ($gudang as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $pesananPenjualan->gudang_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}</option>
                                        @empty
                                            <option value="" disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Salesman</label>
                                    <select id="salesman" name="salesman" class="form-control" required>
                                        @forelse ($salesman as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $pesananPenjualan->salesman_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}</option>
                                        @empty
                                            <option value="" disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                </div> --}}

                                <div class="col-md-4">
                                    <label class="control-label">Mata Uang</label>

                                    <select name="matauang" id="matauang" class="form-control" readonly>
                                        <option value="{{ $pesananPenjualan->matauang_id }}">
                                            {{ $pesananPenjualan->matauang->kode }}
                                        </option>
                                    </select>
                                </div>
                                {{-- end col-md-4 --}}
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label class="control-label">Pelanggan</label>

                                    <select name="pelanggan" id="pelanggan" class="form-control" required>
                                        @forelse ($pelanggan as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $pesananPenjualan->pelanggan_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama_pelanggan }}</option>
                                        @empty
                                            <option value="" disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                </div>

                                {{-- Bentuk stok --}}
                                <div class="col-md-4">
                                    <label for="bentuk_kepemilikan">Bentuk Kepemilikan Stok</label>
                                    <select name="bentuk_kepemilikan" id="bentuk_kepemilikan" class="form-control"
                                        required>
                                        <option value="Stok Sendiri">Stok Sendiri</option>
                                        <option value="Konsinyasi">Konsinyasi</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Rate</label>
                                    <input type="number" step="any" name="rate" class="form-control" placeholder="Rate"
                                        value="{{ $pesananPenjualan->rate }}" readonly />
                                </div>
                            </div>

                            <div class="form-group row" style="margin-top: 1em;">
                                <div class="col-md-6">
                                    <label class="control-label">Alamat Penerima</label>
                                    <textarea name="alamat" id="alamat" rows="5"
                                        class="form-control">{{ $pesananPenjualan->alamat }}</textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="control-label">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" rows="5"
                                        class="form-control">{{ $pesananPenjualan->keterangan }}</textarea>
                                </div>
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
                        <h4 class="panel-title">{{ trans('penjualan.title.edit') }} - List</h4>
                    </div>

                    <div class="panel-body">
                        {{-- Form barang --}}
                        <form id="form_trx" method="POST">
                            <div class="row form-group">
                                {{-- barang --}}
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label for="kode_barang">Nama Barang</label>
                                    <select name="kode_barang" id="kode_barang_input" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Matauang Terlebih Dahulu --</option>
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
                                <div class="col-md-2" style="margin-bottom: 1em;">
                                    <label for="diskon">Diskon</label>
                                    <input type="number" step="any" name="diskon_input" id="diskon_input"
                                        class="form-control" readonly placeholder="0" />
                                </div>

                                {{-- Gross --}}
                                <div class="col-md-2" style="margin-bottom: 1em;">
                                    <label for="gross_input">Gross</label>
                                    <input type="number" step="any" name="gross" id="gross_input" class="form-control"
                                        readonly placeholder="0" />
                                </div>

                                {{-- ppn --}}
                                <div class="col-md-2" style="margin-bottom: 1em;">
                                    <label for="ppn">PPN</label>
                                    <input type="checkbox" id="checkbox_ppn" checked>
                                    <input type="number" step="any" name="ppn" id="ppn_input" class="form-control"
                                        readonly placeholder="0" />
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
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pesananPenjualan->pesanan_penjualan_detail as $detail)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        {{ $detail->barang->kode . ' - ' . $detail->barang->nama }}
                                                        <input type="hidden" class="kode_barang_hidden" name="barang[]"
                                                            value="{{ $detail->barang->id }}">
                                                    </td>
                                                    <td>
                                                        {{ number_format($detail->harga) }}
                                                        <input type="hidden" class="harga_hidden" name="harga[]"
                                                            value="{{ $detail->harga }}">
                                                    </td>
                                                    <td>
                                                        {{ $detail->qty }}
                                                        <input type="hidden" class="qty_hidden" name="qty[]"
                                                            value="{{ $detail->qty }}">
                                                    </td>
                                                    <td>
                                                        {{ number_format($detail->diskon_persen) }}%
                                                        <input type="hidden" class="diskon_persen_hidden"
                                                            name="diskon_persen[]" value="{{ $detail->diskon_persen }}">
                                                    </td>
                                                    <td>
                                                        {{ number_format($detail->diskon) }}
                                                        <input type="hidden" class="diskon_hidden" name="diskon[]"
                                                            value="{{ $detail->diskon }}">
                                                    </td>
                                                    <td>
                                                        {{ number_format($detail->gross) }}
                                                        <input type="hidden" name="gross[]" class="gross_hidden"
                                                            value="{{ $detail->gross }}">
                                                    </td>
                                                    <td>
                                                        {{ number_format($detail->ppn) }}
                                                        <input type="hidden" class="ppn_hidden" name="ppn[]"
                                                            value="{{ $detail->ppn }}">
                                                    </td>
                                                    <td>
                                                        {{ number_format($detail->netto) }}
                                                        <input type="hidden" class="netto_hidden" name="netto[]"
                                                            value="{{ $detail->netto }}">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-xs btn_edit_brg">
                                                            <i class="fa fa-edit"></i>
                                                        </button>

                                                        <button type="button" class="btn btn-danger btn-xs btn_hapus_brg">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row form-group" id="total" style="margin-top: 1em;">
                                    {{-- subtotal --}}
                                    <div class="col-md-3" style="margin-top: 1em;">
                                        <label for="subtotal">Subtotal</label>
                                        <input type="text" step="any" name="subtotal" id="subtotal" class="form-control"
                                            placeholder="0" readonly />
                                    </div>

                                    {{-- Total Diskon --}}
                                    <div class="col-md-3" style="margin-top: 1em;">
                                        <label for="total_diskon">Total Diskon</label>
                                        <input type="text" step="any" name="total_diskon" id="total_diskon"
                                            class="form-control" placeholder="0" readonly />
                                    </div>

                                    {{-- Total PPN --}}
                                    <div class="col-md-3" style="margin-top: 1em;">
                                        <label for="total_ppn">Total PPN</label>
                                        <input type="text" step="any" name="total_ppn" id="total_ppn"
                                            class="form-control" placeholder="0" readonly />
                                    </div>

                                    {{-- Total Gross --}}
                                    <div class="col-md-3" style="margin-top: 1em;">
                                        <label for="total_gross">Total Gross</label>
                                        <input type="text" step="any" name="total_gross" id="total_gross"
                                            class="form-control" placeholder="0" readonly />
                                    </div>

                                    {{-- Total Netto --}}
                                    <div class="col-md-3" style="margin-top: 1em;">
                                        <label for="total_netto">Total Netto</label>
                                        <input type="text" step="any" name="total_netto" id="total_netto"
                                            class="form-control" placeholder="0" readonly />
                                    </div>

                                    {{-- Biaya Kirim --}}
                                    <div class="col-md-3" style="margin-top: 1em;">
                                        <label for="total_biaya_kirim">Biaya Kirim</label>
                                        <input type="number" step="any" name="total_biaya_kirim" id="total_biaya_kirim"
                                            class="form-control" placeholder="0"
                                            value="{{ $pesananPenjualan->total_biaya_kirim }}" />
                                    </div>

                                    {{-- Total penjualan --}}
                                    <div class="col-md-3" style="margin-top: 1em;">
                                        <label for="total_penjualan">Total Penjualan</label>
                                        <input type="text" step="any" name="total_penjualan" id="total_penjualan"
                                            class="form-control" placeholder="0" readonly />
                                    </div>

                                    {{-- button --}}
                                    <div class="col-md-3" style="margin-top: 1em;">
                                        <label>Button</label>
                                        <div class="form-control" style="border: none; padding:0">
                                            <button class="btn btn-success" id="btn_simpan">Simpan</button>

                                            <button class="btn btn-danger" id="btn_clear_table">Batal</button>
                                        </div>
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
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->
    <input type="hidden" id="stok">
    <input type="hidden" id="min_stok">
@endsection

@include('penjualan.pesanan.script.edit-js')
