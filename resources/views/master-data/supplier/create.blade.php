@extends('layouts.dashboard')

@section('title', trans('supplier.title.tambah'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('supplier_add') }}
        <!-- begin row -->
        <div class="row">
            <!-- begin col-6 -->
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
                        <h4 class="panel-title">{{ trans('supplier.title.tambah') }}</h4>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('supplier.store') }}" method="post">
                            @csrf

                            <div class="form-group">
                                <label class="col-md-3 control-label">Kode</label>
                                <div class="col-md-9">
                                    <input type="text" name="kode" class="form-control" placeholder="Kode"
                                        value="{{ old('kode') }}" required />
                                    @error('kode')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Nama Supplier</label>
                                <div class="col-md-9">
                                    <input type="text" name="nama_supplier" class="form-control"
                                        placeholder="Nama Supplier" value="{{ old('nama_supplier') }}" required />
                                    @error('nama_supplier')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">NPWP</label>
                                <div class="col-md-9">
                                    <input type="text" name="npwp" class="form-control" placeholder="NPWP"
                                        value="{{ old('npwp') }}" required />
                                    @error('npwp')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">NPPKP</label>
                                <div class="col-md-9">
                                    <input type="text" name="nppkp" class="form-control" placeholder="NPPKP"
                                        value="{{ old('nppkp') }}" required />
                                    @error('nppkp')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Tanggal PKP</label>
                                <div class="col-md-9">
                                    <input type="date" name="tgl_pkp" class="form-control" placeholder="Tanggal PKP"
                                        value="{{ old('tgl_pkp') }}" required />
                                    @error('tgl_pkp')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Alamat</label>
                                <div class="col-md-9">
                                    <textarea name="alamat" class="form-control" placeholder="Alamat" rows="8"
                                        required>{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Kota</label>
                                <div class="col-md-9">
                                    <input type="text" name="kota" class="form-control" placeholder="Kota"
                                        value="{{ old('kota') }}" required />
                                    @error('kota')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Kode Pos</label>
                                <div class="col-md-9">
                                    <input type="text" name="kode_pos" class="form-control" placeholder="Kode Pos"
                                        value="{{ old('kode_pos') }}" required />
                                    @error('kode_pos')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Telp 1</label>
                                <div class="col-md-9">
                                    <input type="text" name="telp1" class="form-control" placeholder="Telp 1"
                                        value="{{ old('telp1') }}" required />
                                    @error('telp1')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Telp 2</label>
                                <div class="col-md-9">
                                    <input type="text" name="telp2" class="form-control" placeholder="Telp 2"
                                        value="{{ old('telp2') }}" required />
                                    @error('telp2')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Nama Kontak</label>
                                <div class="col-md-9">
                                    <input type="text" name="nama_kontak" class="form-control" placeholder="Nama Kontak"
                                        value="{{ old('nama_kontak') }}" required />
                                    @error('nama_kontak')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Telp. Kontak</label>
                                <div class="col-md-9">
                                    <input type="text" name="telp_kontak" class="form-control" placeholder="Telp. Kontak"
                                        value="{{ old('telp_kontak') }}" required />
                                    @error('telp_kontak')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">TOP</label>
                                <div class="col-md-9">
                                    <input type="number" name="top" class="form-control" placeholder="TOP"
                                        value="{{ old('top') }}" required />
                                    @error('top')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Status</label>
                                <div class="col-md-9">
                                    <select name="status" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        <option value="Y">Aktif</option>
                                        <option value="N">No</option>
                                    </select>
                                    @error('status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-9">
                                    <button type="submit" class="btn btn-sm btn-success"> Simpan</button>
                                    <a href="{{ route('supplier.index') }}" class="btn btn-sm btn-default"> Cancel
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-6 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->
@endsection
