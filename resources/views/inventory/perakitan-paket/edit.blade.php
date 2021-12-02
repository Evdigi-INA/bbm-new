@extends('layouts.dashboard')

@section('title', trans('perakitan_paket.title.edit'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('perakitan_paket_edit') }}
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
                        <h4 class="panel-title">{{ trans('perakitan_paket.title.tambah') }} - Header</h4>
                    </div>

                    <div class="panel-body">
                        <form action="{{ route('perakitan-paket.update', $perakitanPaket->id) }}" method="POST">
                            @csrf

                            <div class="form-group row" style="margin-bottom: 10px">
                                <div class="col-md-6" style="margin-bottom: 1em">
                                    <label class="control-label">Kode</label>
                                    <input type="text" name="kode" class="form-control" placeholder="Kode" id="kode"
                                        value="{{ $perakitanPaket->kode }}" disabled readonly />
                                </div>

                                <div class="col-md-6" style="margin-bottom: 1em">
                                    <label class="control-label">Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control" disabled
                                        value="{{ $perakitanPaket->tanggal->format('Y-m-d') }}" />
                                </div>

                                <div class="col-md-4" style="margin-bottom: 1em">
                                    <label class="control-label">Gudang</label>

                                    <select name="gudang" class="form-control" required>
                                        @forelse ($gudang as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $perakitanPaket->gudang_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}</option>
                                        @empty
                                            <option value="" disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                </div>

                                {{-- paket --}}
                                <div class="col-md-4" style="margin-bottom: 1em">
                                    <label for="paket_input">Paket</label>
                                    <select id="paket_input" class="form-control" name="paket" required>
                                        @forelse ($paket as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $perakitanPaket->paket_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->kode . ' - ' . $item->nama }}
                                            </option>
                                        @empty
                                            <option value="" disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                </div>

                                {{-- kuantitas --}}
                                <div class="col-md-4" style="margin-bottom: 1em">
                                    <label for="kuantitas">Kuantitas Perakitan</label>
                                    <input type="number" name="kuantitas" id="kuantitas_input" class="form-control"
                                        placeholder="Kuantitas Perakitan" min="1"
                                        value="{{ $perakitanPaket->kuantitas }}" />
                                </div>

                                {{-- keterangan --}}
                                <div class="col-md-12" style="margin-bottom: 1em">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan_input" class="form-control"
                                        placeholder="Keterangan" rows="5">{{ $perakitanPaket->keterangan }}</textarea>
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
                                <i class="fa fa-plus"></i>
                            </a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger"
                                data-click="panel-remove">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                        <h4 class="panel-title">{{ trans('perakitan_paket.title.tambah') }} - List</h4>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-9">

                                <table class="table table-striped table-condensed" id="tbl_trx">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Kode - Nama Barang</th>
                                            <th>Bentuk Kep.</th>
                                            <th>Qty</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($perakitanPaket->perakitan_paket_detail as $detail)
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $detail->barang->kode . ' - ' . $detail->barang->nama }}
                                                <input type="hidden" class="kode_barang_hidden" name="barang[]"
                                                    value="{{ $detail->barang->id }}">
                                            </td>
                                            <td>
                                                {{ $detail->bentuk_kepemilikan_stok }}
                                                <input type="hidden" class="bentuk_kepemilikan_hidden"
                                                    name="bentuk_kepemilikan[]"
                                                    value="{{ $detail->bentuk_kepemilikan_stok }}">
                                            </td>
                                            <td>
                                                {{ $detail->qty }}
                                                <input type="hidden" class="qty_hidden" name="qty[]"
                                                    value="{{ $detail->qty }}">
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

                                <button class="btn btn-success" id="btn_simpan">Simpan</button>

                                <button class="btn btn-danger" id="btn_clear_table">Batal</button>
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
                                            placeholder="Qty" min="1" required />
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

@include('inventory.perakitan-paket.script.edit-js')
