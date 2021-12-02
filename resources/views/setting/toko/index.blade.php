@extends('layouts.dashboard')

@section('title', trans('toko.title.index'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('toko') }}

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
                        <h4 class="panel-title">{{ trans('toko.title.index') }}</h4>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('toko.update', ['toko' => $toko->id]) }}"
                            method="post" novalidate>
                            @csrf
                            @method('put')

                            <div class="form-group row">
                                <div class="col-md-4" style="margin-bottom: 0.5em;">
                                    <label for="nama" class="control-label">Nama Toko</label>

                                    <input type="text" name="nama" class="form-control" placeholder="nama"
                                        value="{{ old('nama') ? old('nama') : $toko->nama }}" id="nama" required />
                                    @error('nama')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4" style="margin-bottom: 0.5em;">
                                    <label for="telp1" class="control-label">Telp 1</label>

                                    <input type="tel" name="telp1" class="form-control" placeholder="telp1"
                                        value="{{ old('telp1') ? old('telp1') : $toko->telp1 }}" id="telp1" required />
                                    @error('telp1')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4" style="margin-bottom: 0.5em;">
                                    <label for="telp2" class="control-label">Telp 2</label>

                                    <input type="tel" name="telp2" class="form-control" placeholder="telp2"
                                        value="{{ old('telp2') ? old('telp2') : $toko->telp2 }}" id="telp2" required />
                                    @error('telp2')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4" style="margin-bottom: 0.5em;">
                                    <label for="email" class="control-label">Email</label>

                                    <input type="email" name="email" class="form-control" placeholder="Email"
                                        value="{{ old('email') ? old('email') : $toko->email }}" id="email" required />
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4" style="margin-bottom: 0.5em;">
                                    <label for="website" class="control-label">Website</label>

                                    <input type="url" name="website" class="form-control" placeholder="Website"
                                        value="{{ old('website') ? old('website') : $toko->website }}" id="website"
                                        required />
                                    @error('website')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4" style="margin-bottom: 0.5em;">
                                    <label for="fax" class="control-label">Fax</label>

                                    <input type="text" name="fax" class="form-control" placeholder="Fax"
                                        value="{{ old('fax') ? old('fax') : $toko->fax }}" id="fax" required />
                                    @error('fax')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4" style="margin-bottom: 0.5em;">
                                    <label for="npwp" class="control-label">NPWP</label>

                                    <input type="number" name="npwp" class="form-control" placeholder="NPWP"
                                        value="{{ old('npwp') ? old('npwp') : $toko->npwp }}" id="npwp" required />
                                    @error('npwp')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4" style="margin-bottom: 0.5em;">
                                    <label for="nppkp" class="control-label">NPPKP</label>

                                    <input type="number" name="nppkp" class="form-control" placeholder="NPPKP"
                                        value="{{ old('nppkp') ? old('nppkp') : $toko->nppkp }}" id="nppkp" required />
                                    @error('nppkp')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4" style="margin-bottom: 0.5em;">
                                    <label for="tgl_pkp" class="control-label">Tanggal PKP</label>

                                    <input type="date" name="tgl_pkp" class="form-control" placeholder="tgl_pkp"
                                        value="{{ old('tgl_pkp') ? old('tgl_pkp') : $toko->tgl_pkp }}" id="tgl_pkp"
                                        required />
                                    @error('tgl_pkp')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4" style="margin-bottom: 0.5em;">
                                    <label for="deskripsi" class="control-label">Deskripsi Usaha</label>

                                    <textarea name="deskripsi" class="form-control" placeholder="Deskripsi Usaha"
                                        id="deskripsi" rows="6"
                                        required>{{ old('deskripsi') ? old('deskripsi') : $toko->deskripsi }}</textarea>
                                    @error('deskripsi')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4" style="margin-bottom: 0.5em;">
                                    <label for="alamat" class="control-label">Alamat</label>

                                    <textarea name="alamat" class="form-control" placeholder="alamat" id="alamat" rows="6"
                                        required>{{ old('alamat') ? old('alamat') : $toko->alamat }}</textarea>
                                    @error('alamat')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <div class="row form-group">
                                        <div class="col-md-12" style="margin-bottom: 0.5em;">
                                            <label for="kota" class="control-label">Kota</label>

                                            <input type="text" name="kota" class="form-control" placeholder="Kota"
                                                value="{{ old('kota') ? old('kota') : $toko->kota }}" id="kota"
                                                required />
                                            @error('kota')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-12" style="margin-bottom: 0.5em;">
                                            <label for="kode_pos" class="control-label">Kode Pos</label>

                                            <input type="number" name="kode_pos" class="form-control"
                                                placeholder="Kode Pos"
                                                value="{{ old('kode_pos') ? old('kode_pos') : $toko->kode_pos }}"
                                                id="kode_pos" required />
                                            @error('kode_pos')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row" style="margin-top: 1em;">
                                <div class="col-md-12">
                                    <button class="btn btn-success" type="submit">Simpan</button>
                                </div>
                            </div>
                            {{-- form-group row --}}
                        </form>
                    </div>
                    {{-- panel-body --}}
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-6 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->
@endsection
