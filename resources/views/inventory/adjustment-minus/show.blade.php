@extends('layouts.dashboard')

@section('title', trans('adjustment_minus.title.edit'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('adjustment_minus_add') }}
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
                        <h4 class="panel-title">{{ trans('adjustment_Minus.title.edit') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group row" style="margin-bottom: 10px">
                            <div class="col-md-4">
                                <label class="control-label">Kode</label>

                                <input type="text" name="kode" class="form-control" placeholder="Kode" id="kode" required
                                    value="{{ $adjustmentMinus->kode }}" disabled />
                            </div>

                            <div class="col-md-4">
                                <label class="control-label">Tanggal</label>

                                <input type="date" name="tanggal" class="form-control" disabled
                                    value="{{ $adjustmentMinus->tanggal->format('Y-m-d') }}" />
                            </div>

                            <div class="col-md-4 mt-3">
                                <label class="control-label">Gudang</label>

                                <select name="gudang" class="form-control" disabled>
                                    <option value="{{ $adjustmentMinus->gudang_id }}">
                                        {{ $adjustmentMinus->gudang->nama }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        {{-- end form-group row --}}

                        <div class="row" style="margin-top: 1em;">
                            <div class="col-md-12">
                                <hr>
                            </div>

                            <div class="col-md-12">
                                <table class="table table-striped table-hover table-condensed">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Supplier</th>
                                            <th>Bentuk Kep. Stok</th>
                                            <th>Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total_qty = 0;
                                        @endphp
                                        @foreach ($adjustmentMinus->adjustment_minus_detail as $detail)
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
                                                    {{ number_format($detail->qty) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5">
                                                Total
                                            </th>
                                            <th>
                                                {{ number_format($total_qty) }}
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
