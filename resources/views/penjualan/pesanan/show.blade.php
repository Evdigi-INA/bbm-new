@extends('layouts.dashboard')

@section('title', trans('pesanan_penjualan.title.show'))

@section('content')
    @php
    $matauang = $pesananPenjualan->matauang->kode;
    @endphp
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('pesanan_penjualan_show') }}
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
                        <h4 class="panel-title">{{ trans('pesanan_penjualan.title.show') }} - Header</h4>
                    </div>

                    <div class="panel-body">
                        <form>
                            <div class="form-group row" style="margin-bottom: 10px">
                                <div class="col-md-4">
                                    <label class="control-label">Kode</label>

                                    <input type="text" name="kode" class="form-control" placeholder="Kode" id="kode"
                                        value="{{ $pesananPenjualan->kode }}" readonly />
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Tanggal</label>

                                    <input type="date" name="tanggal" class="form-control"
                                        value="{{ $pesananPenjualan->tanggal->format('Y-m-d') }}" readonly />
                                </div>

                                {{-- <div class="col-md-4">
                                    <label class="control-label">Gudang</label>

                                    <select name="gudang" id="gudang" class="form-control" readonly>
                                        <option value="{{ $pesananPenjualan->gudang->id }}">
                                            {{ $pesananPenjualan->gudang->nama }}
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Salesman</label>

                                    <select id="salesman" name="salesman" class="form-control" readonly>
                                        <option value="{{ $pesananPenjualan->salesman->id }}">
                                            {{ $pesananPenjualan->salesman->nama }}
                                        </option>
                                    </select>
                                </div> --}}

                                <div class="col-md-4">
                                    <label class="control-label">Mata Uang</label>

                                    <select name="matauang" id="matauang" class="form-control" readonly>
                                        <option value="{{ $pesananPenjualan->matauang->id }}">
                                            {{ $pesananPenjualan->matauang->nama }}
                                        </option>
                                    </select>
                                </div>
                                {{-- end col-md-4 --}}
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label class="control-label">Pelanggan</label>

                                    <select name="pelanggan" id="pelanggan" class="form-control" readonly>
                                        <option value="{{ $pesananPenjualan->pelanggan->id }}">
                                            {{ $pesananPenjualan->pelanggan->nama_pelanggan }}
                                        </option>
                                    </select>
                                </div>

                                {{-- Bentuk stok --}}
                                <div class="col-md-4">
                                    <label for="bentuk_kepemilikan">Bentuk Kepemilikan Stok</label>
                                    <select name="bentuk_kepemilikan" id="bentuk_kepemilikan" class="form-control"
                                        readonly>
                                        <option value="{{ $pesananPenjualan->bentuk_kepemilikan_stok }}">
                                            {{ $pesananPenjualan->bentuk_kepemilikan_stok }}
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Rate</label>
                                    <input type="number" step="any" name="rate" class="form-control"
                                        value="{{ $pesananPenjualan->rate }}" placeholder="Rate" readonly />
                                </div>
                            </div>

                            <div class="form-group row" style="margin-top: 1em;">
                                <div class="col-md-6">
                                    <label class="control-label">Alamat Penerima</label>
                                    <textarea name="alamat" id="alamat" rows="5" class="form-control"
                                        readonly>{{ $pesananPenjualan->alamat }}</textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="control-label">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" rows="5" class="form-control"
                                        readonly>{{ $pesananPenjualan->keterangan }}</textarea>
                                </div>
                            </div>
                        </form>

                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                            </div>

                            {{-- table barang --}}
                            <div class="col-md-12">
                                <h4>{{ trans('penjualan.title.item_list') }}</h4>
                                <table class="table table-striped table-hover table-condensed" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Harga</th>
                                            <th>Qty</th>
                                            <th>Disc%</th>
                                            <th>Disc</th>
                                            <th>Gross</th>
                                            <th>PPN</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total_qty = 0;
                                            $total_diskon_persen = 0;
                                        @endphp
                                        @foreach ($pesananPenjualan->pesanan_penjualan_detail as $detail)
                                            @php
                                                $total_qty += $detail->qty;
                                                $total_diskon_persen += $detail->diskon_persen;
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $detail->barang->kode }}</td>
                                                <td>{{ $detail->barang->nama }}</td>
                                                <td>
                                                    {{ $matauang . ' ' . number_format($detail->harga) }}
                                                </td>
                                                <td>
                                                    {{ $detail->qty }}
                                                </td>
                                                <td>
                                                    {{ $detail->diskon_persen . '%' }}
                                                </td>
                                                <td>
                                                    {{ $matauang . ' ' . number_format($detail->diskon) }}
                                                </td>
                                                <td>
                                                    {{ $matauang . ' ' . number_format($detail->gross) }}
                                                </td>
                                                <td>
                                                    {{ $matauang . ' ' . number_format($detail->ppn) }}
                                                </td>
                                                <td>
                                                    {{ $matauang . ' ' . number_format($detail->netto) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="9">Biaya Kirim</th>
                                            <th>
                                                {{ $matauang . ' ' . number_format($pesananPenjualan->total_biaya_kirim) }}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">
                                                Total
                                            </th>
                                            <th>
                                                {{ $matauang . ' ' . number_format($pesananPenjualan->subtotal) }}
                                            </th>
                                            <th>{{ $total_qty }}</th>
                                            <th>
                                                {{ $total_diskon_persen . '%' }}
                                            </th>
                                            <th>
                                                {{ $matauang . ' ' . number_format($pesananPenjualan->total_diskon) }}
                                            </th>
                                            <th>
                                                {{ $matauang . ' ' . number_format($pesananPenjualan->total_gross) }}
                                            </th>
                                            <th>
                                                {{ $matauang . ' ' . number_format($pesananPenjualan->total_ppn) }}
                                            </th>
                                            <th>
                                                {{ $matauang . ' ' . number_format($pesananPenjualan->total_penjualan) }}
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
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
@endsection
