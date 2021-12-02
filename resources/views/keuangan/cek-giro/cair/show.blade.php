@extends('layouts.dashboard')

@section('title', trans('cek_giro_cair.title.edit'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('cek_giro_cair_edit') }}
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
                        <h4 class="panel-title">{{ trans('cek_giro_cair.title.header_entry') }}</h4>
                    </div>

                    <div class="panel-body">
                        <div class="form-group row" style="margin-bottom: 1em;">
                            <div class="col-md-4">
                                <label for="kode" class="control-label">Kode</label>
                                <input type="text" name="kode" class="form-control" placeholder="Kode" id="kode"
                                    value="{{ $cekGiroCair->kode }}" disabled />
                            </div>

                            <div class="col-md-4">
                                <label for="tanggal" class="control-label">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" disabled
                                    value="{{ $cekGiroCair->tanggal->format('Y-m-d') }}" id="tanggal" />
                            </div>

                            <div class="col-md-4">
                                <label for="no_cek_giro">No. Cek/Giro</label>
                                <select name="no_cek_giro" id="no_cek_giro" class="form-control" disabled>
                                    @if ($cekGiroCair->cek_giro->pembelian)
                                        <option
                                            value="{{ $cekGiroCair->cek_giro->pembelian->pembelian_pembayaran[0]->no_cek_giro }}">
                                            {{ $cekGiroCair->cek_giro->pembelian->pembelian_pembayaran[0]->no_cek_giro }}
                                        </option>
                                    @else
                                        <option
                                            value="{{ $cekGiroCair->cek_giro->penjualan->penjualan_pembayaran[0]->no_cek_giro }}">
                                            {{ $cekGiroCair->cek_giro->penjualan->penjualan_pembayaran[0]->no_cek_giro }}
                                        </option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-3">
                                <label for="jenis_cek_giro" class="control-label">Jenis Cek/Giro</label>
                                <input type="text" name="jenis_cek_giro" class="form-control" placeholder="Jenis Cek/Giro"
                                    id="jenis_cek_giro" value="{{ strtoupper($cekGiroCair->cek_giro->jenis_cek) }}"
                                    disabled />
                            </div>

                            <div class="col-md-3">
                                <label for="tgl_cek_giro" class="control-label">Tanggal Cek/Giro</label>
                                @if ($cekGiroCair->cek_giro->penjualan)
                                    <input type="text" name="tgl_cek_giro" id="tgl_cek_giro" class="form-control"
                                        placeholder="Nilai Cek/Giro"
                                        value="{{ $cekGiroCair->cek_giro->penjualan->penjualan_pembayaran[0]->tgl_cek_giro->format('d/m/Y') }}"
                                        disabled />
                                @else
                                    <input type="text" name="tgl_cek_giro" id="tgl_cek_giro" class="form-control"
                                        placeholder="Nilai Cek/Giro"
                                        value="{{ $cekGiroCair->cek_giro->pembelian->pembelian_pembayaran[0]->tgl_cek_giro->format('d/m/Y') }}"
                                        disabled />
                                @endif
                            </div>

                            <div class="col-md-3">
                                <label for="matauang" class="control-label">Mata Uang</label>
                                <input type="text" name="matauang" class="form-control" placeholder="Mata Uang"
                                    id="matauang" disabled
                                    value="{{ $cekGiroCair->cek_giro->pembelian ? $cekGiroCair->cek_giro->pembelian->matauang->kode : $cekGiroCair->cek_giro->penjualan->matauang->kode }}" />
                            </div>

                            <div class="col-md-3">
                                <label for="rate" class="control-label">Rate</label>
                                <input type="text" name="rate" class="form-control" placeholder="Rate" id="rate"
                                    value="{{ $cekGiroCair->cek_giro->pembelian ? $cekGiroCair->cek_giro->pembelian->rate : $cekGiroCair->cek_giro->penjualan->rate }}"
                                    disabled />
                            </div>

                            <div class="col-md-4" style="margin-top: 1em;">
                                <label for="dicairkan_ke" class="control-label">Dicairkan Ke</label>
                                <select name="dicairkan_ke" class="form-control" id="dicairkan_ke" disabled>
                                    <option value="{{ $cekGiroCair->dicairkan_ke }}">
                                        {{ $cekGiroCair->dicairkan_ke }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-4" style="margin-top: 1em;">
                                <label for="bank" class="control-label">Bank</label>
                                <select name="bank" class="form-control" id="bank" disabled>
                                    <option value="">{{ $cekGiroCair->bank ? $cekGiroCair->bank->nama : '-' }}</option>
                                </select>
                            </div>

                            <div class="col-md-4" style="margin-top: 1em;">
                                <label for="rekening" class="control-label">Rekening</label>
                                <select name="rekening" class="form-control" id="rekening" disabled>
                                    <option value="">
                                        {{ $cekGiroCair->rekening ? $cekGiroCair->rekening->nomor_rekening . ' - ' . $cekGiroCair->rekening->nama_rekening : '-' }}
                                    </option>
                                </select>
                            </div>
                        </div>
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
                        <h4 class="panel-title">{{ trans('cek_giro_cair.title.detail_info') }}</h4>
                    </div>

                    <div class="panel-body">
                        <div class="form-group row" style="margin-bottom: 10px">
                            {{-- Referensi Nomor --}}
                            <div class="col-md-4" style="margin-top: 1em;">
                                <label for="referensi_nomor">Referensi Nomor</label>
                                @if ($cekGiroCair->cek_giro->penjualan)
                                    <input type="text" step="any" name="referensi_nomor" id="referensi_nomor"
                                        class="form-control" placeholder="Referensi Nomor"
                                        value="{{ $cekGiroCair->cek_giro->penjualan->kode }}" disabled />
                                @else
                                    <input type="text" step="any" name="referensi_nomor" id="referensi_nomor"
                                        class="form-control" placeholder="Referensi Nomor"
                                        value="{{ $cekGiroCair->cek_giro->pembelian->kode }}" disabled />
                                @endif
                            </div>

                            {{-- Referensi Nama --}}
                            <div class="col-md-4" style="margin-top: 1em;">
                                <label for="referensi_nama">Referensi Nama</label>
                                @if ($cekGiroCair->cek_giro->penjualan)
                                    <input type="text" name="referensi_nama" id="referensi_nama" class="form-control"
                                        placeholder="Referensi Nama"
                                        value="{{ $cekGiroCair->cek_giro->penjualan->pelanggan->nama_pelanggan }}"
                                        disabled />
                                @else
                                    <input type="text" name="referensi_nama" id="referensi_nama" class="form-control"
                                        placeholder="Referensi Nama"
                                        value="{{ $cekGiroCair->cek_giro->pembelian->supplier ? $cekGiroCair->cek_giro->pembelian->supplier->nama_supplier : 'Tanpa Supplier' }}"
                                        disabled />
                                @endif
                            </div>

                            {{-- nilai_cek_giro --}}
                            <div class="col-md-4" style="margin-top: 1em;">
                                <label for="nilai_cek_giro">Nilai Cek/Giro</label>
                                @if ($cekGiroCair->cek_giro->penjualan)
                                    <input type="text" name="nilai_cek_giro" id="nilai_cek_giro" class="form-control"
                                        placeholder="Nilai Cek/Giro"
                                        value="{{ number_format($cekGiroCair->cek_giro->penjualan->penjualan_pembayaran[0]->bayar) }}"
                                        disabled />
                                @else
                                    <input type="text" name="nilai_cek_giro" id="nilai_cek_giro" class="form-control"
                                        placeholder="Nilai Cek/Giro"
                                        value="{{ number_format($cekGiroCair->cek_giro->pembelian->pembelian_pembayaran[0]->bayar) }}"
                                        disabled />
                                @endif
                            </div>

                            {{-- keterangan --}}
                            <div class="col-md-12" style="margin-top: 1em;">
                                <label for="keterangan">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" class="form-control" disabled
                                    placeholder="Keterangan" rows="5">{{ $cekGiroCair->keterangan }}</textarea>
                            </div>

                            <div class="col-md-12" style="margin-top: 1em;">
                                <a href="{{ route('cek-giro-cair.index') }}" class="btn btn-sm btn-success">Kembali</a>
                            </div>
                            {{-- </form> --}}
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
@endsection
