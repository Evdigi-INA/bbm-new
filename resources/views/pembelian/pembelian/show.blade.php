@extends('layouts.dashboard')

@section('title', trans('pembelian.title.show'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('pembelian_show') }}
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
                        <h4 class="panel-title">{{ trans('pembelian.title.show') }}</h4>
                    </div>

                    <div class="panel-body">
                        <div class="panel-body">
                            <div class="form-group row" style="margin-bottom: 1em;">
                                <div class="col-md-3">
                                    <label class="control-label">Kode</label>
                                    <input type="text" class="form-control" placeholder="Kode" id="kode" required
                                        value="{{ $pembelian->kode }}" readonly />
                                </div>

                                <div class="col-md-3">
                                    <label class="control-label">Tanggal</label>
                                    <input type="date" class="form-control" readonly
                                        value="{{ $pembelian->tanggal->format('Y-m-d') }}" />
                                </div>

                                <div class="col-md-3">
                                    <label class="control-label">Rate</label>
                                    <input type="number" step="any" name="rate" class="form-control" placeholder="Rate"
                                        value="{{ $pembelian->rate }}" readonly />
                                </div>

                                <div class="col-md-3">
                                    <label class="control-label">Kode P.O</label>
                                    <select class="form-control" readonly>
                                        <option
                                            value="{{ $pembelian->pesanan_pembelian ? $pembelian->pesanan_pembelian->kode : 'Tanpa P.O' }}">
                                            {{ $pembelian->pesanan_pembelian ? $pembelian->pesanan_pembelian->kode : 'Tanpa P.O' }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" style="margin-bottom: 1em;">
                                <div class="col-md-3">
                                    <label class="control-label">Supplier</label>
                                    <select class="form-control" readonly>
                                        <option value="{{ $pembelian->supplier_id }}">
                                            {{ $pembelian->supplier ? $pembelian->supplier->nama_supplier : 'Tanpa Supplier' }}
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="control-label">Mata Uang</label>
                                    <select id="matauang" class="form-control" readonly>
                                        <option value="{{ $pembelian->matauang_id }}">
                                            {{ $pembelian->matauang->kode . ' - ' . $pembelian->matauang->nama }}
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="control-label">Gudang</label>
                                    <select class="form-control" readonly>
                                        <option value="{{ $pembelian->gudang_id }}">
                                            {{ $pembelian->gudang->nama }}
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="control-label">Bentuk Kepemilikan</label>
                                    <select id="matauang" class="form-control" readonly>
                                        <option value="{{ $pembelian->bentuk_kepemilikan_stok }}">
                                            {{ $pembelian->bentuk_kepemilikan_stok }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" rows="5" readonly
                                    class="form-control">{{ $pembelian->keterangan }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                </div>

                                {{-- table barang --}}
                                <div class="col-md-12">
                                    <h4>{{ trans('pembelian.title.item_list') }}</h4>
                                    <div class="table-responsive" style="margin-bottom: 1em;">
                                        <table class="table table-striped table-condensed table-responsive" id="tbl_trx"
                                            width="100%">
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
                                                    <th>PPH</th>
                                                    <th>Biaya Masuk</th>
                                                    <th>Clr. Fee</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $total_qty = 0;
                                                    $total_diskon_persen = 0;
                                                @endphp
                                                @foreach ($pembelian->pembelian_detail as $detail)
                                                    @php
                                                        $total_qty += $detail->qty;
                                                        $total_diskon_persen += $detail->diskon_persen;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $detail->barang->kode }}</td>
                                                        <td>{{ $detail->barang->nama }}</td>
                                                        <td>
                                                            {{ $pembelian->matauang->kode . ' ' . $detail->harga }}
                                                        </td>
                                                        <td>
                                                            {{ $detail->qty }}
                                                        </td>
                                                        <td>
                                                            {{ $detail->diskon_persen . '%' }}
                                                        </td>
                                                        <td>
                                                            {{ $pembelian->matauang->kode . ' ' . $detail->diskon }}
                                                        </td>
                                                        <td>
                                                            {{ $pembelian->matauang->kode . ' ' . $detail->gross }}
                                                        </td>
                                                        <td>
                                                            {{ $pembelian->matauang->kode . ' ' . $detail->ppn }}
                                                        </td>
                                                        <td>
                                                            {{ $pembelian->matauang->kode . ' ' . $detail->pph }}
                                                        </td>
                                                        <td>
                                                            {{ $pembelian->matauang->kode . ' ' . $detail->biaya_masuk }}
                                                        </td>
                                                        <td>
                                                            {{ $pembelian->matauang->kode . ' ' . $detail->clr_fee }}
                                                        </td>
                                                        <td>
                                                            {{ $pembelian->matauang->kode . ' ' . $detail->netto }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="3">
                                                        Total
                                                    </th>
                                                    <th>
                                                        {{ $pembelian->matauang->kode . ' ' . $pembelian->subtotal }}
                                                    </th>
                                                    <th>{{ $total_qty }}</th>
                                                    <th>
                                                        {{ $total_diskon_persen . '%' }}
                                                    </th>
                                                    <th>
                                                        {{ $pembelian->matauang->kode . ' ' . $pembelian->total_diskon }}
                                                    </th>
                                                    <th>
                                                        {{ $pembelian->matauang->kode . ' ' . $pembelian->total_gross }}
                                                    </th>
                                                    <th>
                                                        {{ $pembelian->matauang->kode . ' ' . $pembelian->total_ppn }}
                                                    </th>
                                                    <th>
                                                        {{ $pembelian->matauang->kode . ' ' . $pembelian->total_pph }}
                                                    </th>
                                                    <th>
                                                        {{ $pembelian->matauang->kode . ' ' . $pembelian->total_biaya_masuk }}
                                                    </th>
                                                    <th>
                                                        {{ $pembelian->matauang->kode . ' ' . $pembelian->total_clr_fee }}
                                                    </th>
                                                    <th>
                                                        {{ $pembelian->matauang->kode . ' ' . $pembelian->total_netto }}
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                {{-- hr --}}
                                <div class="col-md-12">
                                    <hr>
                                </div>

                                {{-- table barang --}}
                                <div class="col-md-12">
                                    <h4>{{ trans('pembelian.title.payment_list') }}</h4>
                                    <table class="table table-striped table-hover table-condensed" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Jenis Pembayaran</th>
                                                <th>Bank</th>
                                                <th>Rekening</th>
                                                <th>No. Cek/Giro</th>
                                                <th>Tgl. Cek/Giro</th>
                                                <th>Bayar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $total = 0;
                                            @endphp
                                            @foreach ($pembelian->pembelian_pembayaran as $detail)
                                                @php
                                                    $total += $detail->bayar;
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $detail->jenis_pembayaran }}</td>
                                                    <td>{{ $detail->bank ? $detail->bank->nama : '-' }}</td>
                                                    <td>{{ $detail->rekening ? $detail->rekening->nomor_rekening . ' - ' . $detail->rekening->nama_rekening : '-' }}
                                                    </td>
                                                    <td>{{ $detail->no_cek_giro ?? '-' }}</td>
                                                    <td>{{ $detail->tgl_cek_giro ? $detail->tgl_cek_giro->format('d F Y') : '-' }}
                                                    </td>
                                                    <td>{{ $pembelian->matauang->kode . '  ' . $detail->bayar }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="6">Total</th>
                                                <th>{{ $pembelian->matauang->kode . '  ' . $total }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- end panel body --}}
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
