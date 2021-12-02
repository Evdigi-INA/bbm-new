@extends('layouts.dashboard')

@section('title', trans('perakitan_paket.title.show'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('perakitan_paket_show') }}
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
                                <select name="gudang" class="form-control" disabled>
                                    <option value="">{{ $perakitanPaket->gudang->nama }}</option>
                                </select>
                            </div>

                            {{-- paket --}}
                            <div class="col-md-4" style="margin-bottom: 1em">
                                <label for="paket_input">Paket</label>
                                <select id="paket_input" class="form-control" name="paket" disabled>
                                    <option value="">
                                        {{ $perakitanPaket->paket->kode . ' - ' . $perakitanPaket->paket->nama }}
                                    </option>
                                </select>
                            </div>

                            {{-- kuantitas --}}
                            <div class="col-md-4" style="margin-bottom: 1em">
                                <label for="kuantitas">Kuantitas Perakitan</label>
                                <input type="number" name="kuantitas" id="kuantitas_input" class="form-control"
                                    placeholder="Kuantitas Perakitan" min="1" value="{{ $perakitanPaket->kuantitas }}"
                                    disabled />
                            </div>

                            {{-- keterangan --}}
                            <div class="col-md-12" style="margin-bottom: 1em">
                                <label for="keterangan">Keterangan</label>
                                <textarea name="keterangan" id="keterangan_input" class="form-control"
                                    placeholder="Keterangan" rows="5"
                                    disabled>{{ $perakitanPaket->keterangan }}</textarea>
                            </div>
                        </div>

                        <hr>
                        <table class="table table-striped table-condensed" id="tbl_trx">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode - Nama Barang</th>
                                    <th>Bentuk Kep.</th>
                                    <th>Qty</th>
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
                                        <input type="hidden" class="bentuk_kepemilikan_hidden" name="bentuk_kepemilikan[]"
                                            value="{{ $detail->bentuk_kepemilikan_stok }}">
                                    </td>
                                    <td>
                                        {{ $detail->qty }}
                                        <input type="hidden" class="qty_hidden" name="qty[]"
                                            value="{{ $detail->qty }}">
                                    </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
