@extends('layouts.dashboard')

@section('title', trans('pelanggan.title.edit'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('pelanggan_edit') }}

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
                        <h4 class="panel-title">{{ trans('pelanggan.title.edit') }}</h4>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('pelanggan.update', $pelanggan->id) }}"
                            method="post">
                            @csrf
                            @method('put')

                            <div class="form-group">
                                <label class="col-md-3 control-label">Kode</label>
                                <div class="col-md-9">
                                    <input type="text" name="kode" class="form-control" placeholder="Kode"
                                        value="{{ old('kode') ? old('kode') : $pelanggan->kode }}" required />
                                    @error('kode')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Nama pelanggan</label>
                                <div class="col-md-9">
                                    <input type="text" name="nama_pelanggan" class="form-control"
                                        placeholder="Nama pelanggan"
                                        value="{{ old('nama_pelanggan') ? old('nama_pelanggan') : $pelanggan->nama_pelanggan }}"
                                        required />
                                    @error('nama_pelanggan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">NPWP</label>
                                <div class="col-md-9">
                                    <input type="text" name="npwp" class="form-control" placeholder="NPWP"
                                        value="{{ old('npwp') ? old('npwp') : $pelanggan->npwp }}" required />
                                    @error('npwp')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">NPPKP</label>
                                <div class="col-md-9">
                                    <input type="text" name="nppkp" class="form-control" placeholder="NPPKP"
                                        value="{{ old('nppkp') ? old('nppkp') : $pelanggan->nppkp }}" required />
                                    @error('nppkp')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Tanggal PKP</label>
                                <div class="col-md-9">
                                    <input type="date" name="tgl_pkp" class="form-control" placeholder="Tanggal PKP"
                                        value="{{ old('tgl_pkp') ? old('tgl_pkp') : $pelanggan->tgl_pkp }}" required />
                                    @error('tgl_pkp')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Area</label>
                                <div class="col-md-9">
                                    <select name="area" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        @forelse ($area as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $pelanggan->area_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}</option>
                                        @empty
                                            <option value="" disabled selected>Area tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                    @error('area')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Alamat</label>
                                <div class="col-md-9">
                                    <textarea name="alamat" class="form-control" placeholder="Alamat" rows="8"
                                        required>{{ old('alamat') ? old('alamat') : $pelanggan->alamat }}</textarea>
                                    @error('alamat')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Kota</label>
                                <div class="col-md-9">
                                    <input type="text" name="kota" class="form-control" placeholder="Kota"
                                        value="{{ old('kota') ? old('kota') : $pelanggan->kota }}" required />
                                    @error('kota')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Kode Pos</label>
                                <div class="col-md-9">
                                    <input type="text" name="kode_pos" class="form-control" placeholder="Kode Pos"
                                        value="{{ old('kode_pos') ? old('kode_pos') : $pelanggan->kode_pos }}"
                                        required />
                                    @error('kode_pos')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Telp 1</label>
                                <div class="col-md-9">
                                    <input type="text" name="telp1" class="form-control" placeholder="Telp 1"
                                        value="{{ old('telp1') ? old('telp1') : $pelanggan->telp1 }}" required />
                                    @error('telp1')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Telp 2</label>
                                <div class="col-md-9">
                                    <input type="text" name="telp2" class="form-control" placeholder="Telp 2"
                                        value="{{ old('telp2') ? old('telp2') : $pelanggan->telp2 }}" required />
                                    @error('telp2')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Nama Kontak</label>
                                <div class="col-md-9">
                                    <input type="text" name="nama_kontak" class="form-control" placeholder="Nama Kontak"
                                        value="{{ old('nama_kontak') ? old('telp2') : $pelanggan->telp2 }}" required />
                                    @error('nama_kontak')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Telp. Kontak</label>
                                <div class="col-md-9">
                                    <input type="text" name="telp_kontak" class="form-control" placeholder="Telp. Kontak"
                                        value="{{ old('telp_kontak') ? old('telp_kontak') : $pelanggan->telp_kontak }}"
                                        required />
                                    @error('telp_kontak')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">TOP</label>
                                <div class="col-md-9">
                                    <input type="number" name="top" class="form-control" placeholder="TOP"
                                        value="{{ old('top') ? old('top') : $pelanggan->top }}" required />
                                    @error('top')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Status</label>
                                <div class="col-md-9">
                                    <select name="status" class="form-control" required>
                                        <option value="Y" {{ $pelanggan->status == 'Y' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="N" {{ $pelanggan->status == 'N' ? 'selected' : '' }}>No</option>
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
                                    <a href="{{ route('pelanggan.index') }}" class="btn btn-sm btn-default"> Cancel
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
