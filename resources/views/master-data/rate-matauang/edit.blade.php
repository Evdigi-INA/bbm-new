@extends('layouts.dashboard')

@section('title', 'Edit Rate Mata Uang')

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('rate_matauang_edit') }}

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
                                data-click="panel-reload">
                                <i class="fa fa-repeat"></i>
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
                        <h4 class="panel-title">{{ trans('rate_matauang.title.edit') }}</h4>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('rate-matauang.update', $rateMataUang->id) }}"
                            method="post">
                            @csrf
                            @method('put')

                            <div class="form-group">
                                <label class="col-md-3 control-label">Tanggal</label>
                                <div class="col-md-9">
                                    <input type="date" name="tanggal"
                                        class="form-control @error('tanggal') is-invalid  @enderror"
                                        value="{{ old('tanggal') ? old('tanggal') : $rateMataUang->tanggal }}" required />
                                    @error('tanggal')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Mata Uang Asing</label>
                                <div class="col-md-9">
                                    <select name="matauang_id" class="form-control" required>
                                        @forelse ($matauang as $data)
                                            <option value="{{ $data->id }}"
                                                {{ $rateMataUang->matauang_asing->id == $data->id ? 'selected' : '' }}>
                                                {{ $data->nama }}</option>
                                        @empty
                                            <option value="" disabled>Mata uang tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                    @error('matauang_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Mata Uang Default</label>
                                <div class="col-md-9">
                                    <select name="matauang_default" class="form-control" required>
                                        @forelse ($matauang as $data)
                                            <option value="{{ $data->id }}"
                                                {{ $rateMataUang->mata_uang_default->id == $data->id ?? 'selected' }}>
                                                {{ $data->nama }}</option>
                                        @empty
                                            <option value="" disabled>Mata uang tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                    @error('matauang_default')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Rate</label>
                                <div class="col-md-9">
                                    <input type="number" name="rate" class="form-control"
                                        value="{{ old('rate') ? old('rate') : $rateMataUang->rate }}" required />
                                    @error('rate')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-9">
                                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>

                                    <a href="{{ route('matauang.index') }}" class="btn btn-sm btn-default"> Cancel
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
