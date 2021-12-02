@extends('layouts.dashboard')

@section('title', trans('profile.title.edit'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('profile') }}
        <!-- begin row -->
        <div class="row">
            <!-- begin col-8 -->
            <div class="col-md-8">
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
                        <h4 class="panel-title">{{ trans('profile.title.edit') }}</h4>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('profile.store') }}" method="post" enctype="multipart/form-data"
                            novalidate>
                            @csrf

                            <div class="row">
                                <div class="col-md-4">
                                    <h4>Profile</h4>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="control-label">Nama</label>
                                        <input type="text" name="name" class="form-control" placeholder="Nama" required
                                            value="{{ auth()->user()->name }}" />
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                        <input type="email" name="email" class="form-control" placeholder="Email"
                                            value="{{ auth()->user()->email }}" required />
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-md-4 text-center">
                                            @if (auth()->user()->foto != null)
                                                <img src="{{ asset('storage/img/foto/' . auth()->user()->foto) }}"
                                                    alt="Avatar" class="img-fluid rounded"
                                                    style="width: 100%; height: 100px; object-fit: cover; border-radius: 3px;">
                                            @else
                                                <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim(auth()->user()->email))) }}&s=200"
                                                    alt="Avatar" class="img-fluid rounded"
                                                    style="width: 120px; height: 100px; object-fit: cover; border-radius: 3px;">
                                            @endif
                                        </div>

                                        <div class="col-md-8 mt-1">
                                            <label for="foto">Foto</label>
                                            <input type="file" name="foto" id="foto" class="form-control ">
                                            <small class="text-secondary">Biarkan kosong jika tidak ingin diganti.</small>
                                            <div></div>
                                            @error('foto')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <h4>Password</h4>
                                    <small>Biarkan kosong jika tidak ingin diganti.</small>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="control-label">Password Sekarang</label>
                                        <input type="password" name="current_password" class="form-control"
                                            placeholder="Password Sekarang" required />
                                        @error('current_password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Password Baru</label>
                                        <input type="password" name="password" class="form-control" placeholder="Password"
                                            required />
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Ulangi Password Baru</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            placeholder="Ulangi Password" required />
                                        @error('password_confirmation')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="control-label"></label>

                                <button type="submit" class="btn btn-sm btn-success"> Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-8 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->
@endsection
