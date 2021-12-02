@extends('layouts.dashboard')

@section('title', trans('adjustment_plus.title.show'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('adjustment_plus_add') }}
        <!-- begin row -->
        <div class="row">
            <!-- begin col-10 -->
            <div class="col-md-10">
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
                        <h4 class="panel-title">{{ trans('adjustment_plus.title.tambah') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Kode</label>
                                    <input type="text" class="form-control" value="{{ $adjustmentPlus->kode }}"
                                        disabled />
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Tanggal</label>
                                    <input type="text" class="form-control"
                                        value="{{ $adjustmentPlus->tanggal->format('d m Y') }}" disabled />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Gudang</label>
                                    <select name="status" class="form-control" disabled>
                                        <option value="{{ $adjustmentPlus->gudang->id }}">
                                            {{ $adjustmentPlus->gudang->nama }}
                                        </option>
                                    </select>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-8">
                                        <label class="control-label">Mata Uang</label>
                                        <select name="status" class="form-control" disabled>
                                            <option value="{{ $adjustmentPlus->matauang->id }}">
                                                {{ $adjustmentPlus->matauang->kode . ' - ' . $adjustmentPlus->matauang->nama }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="control-label">Rate</label>
                                        <input type="text" class="form-control" value="{{ $adjustmentPlus->rate }}"
                                            disabled />
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end row --}}

                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 1em;">
                            <div class="col-md-12">
                                <table class="table table-striped table-hover table-condensed">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Supplier</th>
                                            <th>Bentuk Kep. Stok</th>
                                            <th>Harga</th>
                                            <th>Qty</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total_qty = 0;
                                        @endphp
                                        @foreach ($adjustmentPlus->adjustment_plus_detail as $detail)
                                            @php
                                                $total_qty += $detail->qty;
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $detail->barang->kode }}</td>
                                                <td>{{ $detail->barang->nama }}</td>
                                                <td>{{ $detail->supplier->nama_supplier }}</td>
                                                <td>{{ $detail->bentuk_kepemilikan_stok }}</td>
                                                <td>
                                                    {{ $adjustmentPlus->matauang->kode . ' ' . number_format($detail->harga, 2, '.', ',') }}
                                                </td>
                                                <td>
                                                    {{ $detail->qty }}
                                                </td>
                                                <td>
                                                    {{ $adjustmentPlus->matauang->kode . ' ' . number_format($detail->subtotal, 2, '.', ',') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="6">
                                                Total
                                            </th>
                                            <th>
                                                {{ $total_qty }}
                                            </th>
                                            <th>
                                                {{ $adjustmentPlus->matauang->kode . ' ' . number_format($adjustmentPlus->grand_total, 2, '.', ',') }}
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
            <!-- end col-10 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->
@endsection
