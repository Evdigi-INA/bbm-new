@extends('layouts.dashboard')

@section('title', trans('salesman.title.tambah'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('salesman_add') }}
        <!-- begin row -->
        <div class="row">
            <!-- begin col-6 -->
            <div class="col-md-6">
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
                        <h4 class="panel-title">{{ trans('salesman.title.tambah') }}</h4>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('salesman.store') }}" method="post">
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
                                <label class="col-md-3 control-label">Nama</label>
                                <div class="col-md-9">
                                    <input type="text" name="nama" class="form-control" placeholder="Nama"
                                        value="{{ old('nama') }}" required />
                                    @error('nama')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Commission</label>
                                <div class="col-md-9">
                                    <input type="number" name="commission" class="form-control"
                                        value="{{ old('commission') }}" required />
                                    @error('commission')
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
                                    <a href="{{ route('salesman.index') }}" class="btn btn-sm btn-default"> Cancel
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
