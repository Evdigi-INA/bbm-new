@extends('layouts.dashboard')

@section('title', trans('user.title.tambah'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('user_add') }}

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
                        <h4 class="panel-title">{{ trans('user.title.tambah') }}</h4>
                    </div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('user.store') }}" method="post">
                            @csrf
                            @method('post')

                            <div class="row form-group">
                                <div class="col-md-6" style="margin-bottom: 1em;">
                                    <label class="control-label">Nama</label>
                                    <input type="text" name="name" class="form-control" placeholder="Nama" required />
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6" style="margin-bottom: 1em;">
                                    <label class="control-label">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email" required />
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="clearfix visible-md visible-lg"></div>

                                <div class="col-md-4" style="margin-bottom: 1em;">
                                    <label for="role" class="control-label">Role</label>
                                    <select name="role" class="form-control" id="role" required>
                                        <option value="" selected disabled>-- Pilih --</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4" style="margin-bottom: 1em;">
                                    <label for="salesman" class="control-label">Salesman</label>
                                    <select name="salesman" class="form-control" id="salesman" disabled>
                                        <option value="" selected disabled>-- Pilih --</option>
                                        @foreach ($salesman as $sales)
                                            <option value="{{ $sales->id }}">{{ ucfirst($sales->nama) }}</option>
                                        @endforeach
                                    </select>
                                    @error('salesman')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4" style="margin-bottom: 1em;">
                                    <label for="status" class="control-label">Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="1">Aktif</option>
                                        <option value="0">Nonaktif</option>
                                    </select>
                                    @error('status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6" style="margin-bottom: 1em;">
                                    <label class="control-label">Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password" />
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6" style="margin-bottom: 1em;">
                                    <label class="control-label">Ulangi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="Ulangi Password" />
                                    @error('password_confirmation')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            @include('setting.user._permissions')

                            <div class="form-group" style="margin-top: 1.5em;">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-sm btn-success"> Simpan</button>
                                    <a href="{{ route('user.index') }}" class="btn btn-sm btn-default"> Cancel
                                    </a>
                                </div>
                            </div>
                        </form>
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

@push('custom-js')
    <script>
        const salesman = $('#salesman')

        $('#role').change(function() {
            if ($(this).val() == 'salesman') {
                salesman.prop('disabled', false)
                salesman.prop('required', true)

                $('input:checkbox').prop('checked', false)
            } else {
                salesman.prop('disabled', true)
                salesman.prop('required', false)

                $('input:checkbox').prop('checked', true)
            }

            $('#salesman option:eq(0)').attr('selected', 'selected')
        })
    </script>
@endpush
