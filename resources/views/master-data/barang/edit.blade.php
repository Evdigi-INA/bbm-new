@extends('layouts.dashboard')

@section('title', trans('barang.title.edit'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('barang_edit') }}

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
                        <h4 class="panel-title">{{ trans('barang.title.edit') }}</h4>
                    </div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('barang.update', $barang->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <div class="form-group">
                                <label class="col-md-3 control-label">Kode</label>
                                <div class="col-md-9">
                                    <input type="text" name="kode" class="form-control" placeholder="Kode"
                                        value="{{ old('kode') ? old('kode') : $barang->kode }}" required />
                                    @error('kode')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Nama</label>
                                <div class="col-md-9">
                                    <input type="text" name="nama" class="form-control" placeholder="Nama"
                                        value="{{ old('nama') ? old('nama') : $barang->nama }}" required />
                                    @error('nama')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Jenis</label>
                                <div class="col-md-9">
                                    <select name="jenis" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        <option value="1" {{ old('jenis') && old('jenis') == 1 ? 'selected' : '' }}
                                            {{ $barang->jenis == 1 ? 'selected' : '' }}>Barang
                                        </option>
                                        <option value="2" {{ old('jenis') && old('jenis') == 2 ? 'selected' : '' }}
                                            {{ $barang->jenis == 2 ? 'selected' : '' }}>Paket
                                        </option>
                                    </select>
                                    @error('jenis')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Kategori</label>
                                <div class="col-md-9">
                                    <select name="kategori" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        @forelse($kategori as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('kategori') && old('kategori') == $item->id ? 'selected' : $item->id }}
                                                {{ $barang->kategori_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}
                                            </option>
                                        @empty
                                            <option value="" disabled selected>Data tidak ditemukan
                                            <option>
                                        @endforelse
                                    </select>
                                    @error('kategori')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Satuan</label>
                                <div class="col-md-9">
                                    <select name="satuan" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        @forelse($satuan as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('satuan') && old('satuan') == $item->id ? 'selected' : $item->id }}
                                                {{ $barang->satuan_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}</option>
                                        @empty
                                            <option value="" disabled selected>Data tidak ditemukan
                                            <option>
                                        @endforelse
                                    </select>
                                    @error('satuan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Harga Beli</label>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select name="harga_beli_matauang" class="form-control" required>
                                                <option value="" disabled selected>-- Pilih --</option>
                                                @forelse($matauang as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('harga_beli_matauang') && old('harga_beli_matauang') == $item->id ? 'selected' : $item->id }}
                                                        {{ $barang->harga_beli_matauang == $item->id ? 'selected' : '' }}>
                                                        {{ $item->nama }}</option>
                                                @empty
                                                    <option value="" disabled selected>Data tidak ditemukan
                                                    <option>
                                                @endforelse
                                            </select>
                                            @error('harga_beli_matauang')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" min="1" name="harga_beli" placeholder="Harga Beli"
                                                class="form-control" required
                                                value="{{ old('kode') ? old('kode') : $barang->harga_beli }}">
                                            @error('harga_beli')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Harga Jual</label>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select name="harga_jual_matauang" class="form-control" required>
                                                <option value="" disabled selected>-- Pilih --</option>
                                                @forelse($matauang as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('harga_jual_matauang') && old('harga_jual_matauang') == $item->id ? 'selected' : $item->id }}
                                                        {{ $barang->harga_jual_matauang == $item->id ? 'selected' : '' }}>
                                                        {{ $item->nama }}
                                                    </option>
                                                @empty
                                                    <option value="" disabled selected>Data tidak ditemukan
                                                    <option>
                                                @endforelse
                                            </select>
                                            @error('harga_jual_matauang')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <input type="number" min="1" name="harga_jual" placeholder="Harga Jual"
                                                class="form-control"
                                                value="{{ old('harga_jual') ? old('harga_jual') : $barang->harga_jual }}"
                                                required>
                                            @error('harga_jual')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <input type="number" min="1" name="harga_jual_min" placeholder="Harga Jual Min."
                                                class="form-control"
                                                value="{{ old('harga_jual_min') ? old('harga_jual_min') : $barang->harga_jual_min }}"
                                                required>
                                            @error('harga_jual_min')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Stok</label>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input type="number" min="1" name="stok" placeholder="Stok"
                                                value="{{ old('stok') ? old('stok') : $barang->stok }}"
                                                class="form-control" required>
                                            @error('stok')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" min="1" name="min_stok" placeholder="Min. Stok"
                                                value="{{ old('min_stok') ? old('min_stok') : $barang->min_stok }}"
                                                class="form-control" required>
                                            @error('min_stok')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Status</label>
                                <div class="col-md-9">
                                    <select name="status" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih --</option>

                                        <option value="Y" {{ old('status') && old('status') == 'Y' ? 'selected' : '' }}
                                            {{ $barang->status == 'Y' ? 'selected' : '' }}>
                                            Aktif
                                        </option>

                                        <option value="N" {{ old('status') && old('status') == 'N' ? 'selected' : '' }}
                                            {{ $barang->status == 'N' ? 'selected' : '' }}>
                                            No
                                        </option>
                                    </select>
                                    @error('status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="gambar">Gambar</label>

                                <div class="col-md-4 text-center">
                                    <img src="{{ asset('storage/img/barang/' . $barang->gambar) }}" alt="gambar"
                                        class="img-fluid rounded" style="width: 150px; height: 120px; object-fit: cover;">
                                </div>

                                <div class="col-md-5">
                                    <input type="file" name="gambar" id="gambar" class="form-control">
                                    <small class="text-secondary">Biarkan kosong jika tidak ingin diganti.</small>

                                    @error('gambar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-9">
                                    <button type="submit" class="btn btn-sm btn-success"> Simpan</button>
                                    <a href="{{ route('barang.index') }}" class="btn btn-sm btn-default"> Cancel
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-10 -->



            <div class="col-md-10">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                @endif
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->
@endsection
