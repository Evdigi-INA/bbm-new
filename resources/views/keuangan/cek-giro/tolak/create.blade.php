@extends('layouts.dashboard')

@section('title', trans('cek_giro_tolak.title.tambah'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('cek_giro_tolak_add') }}
        <!-- begin row -->
        <div class="row">
            <form action="{{ route('cek-giro-tolak.store') }}" method="post">
                @csrf
                @method('post')

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
                            <h4 class="panel-title">{{ trans('cek_giro_tolak.title.header_entry') }}</h4>
                        </div>

                        <div class="panel-body">
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            @endif

                            <div class="form-group row" style="margin-bottom: 1em;">
                                <div class="col-md-4">
                                    <label for="kode" class="control-label">Kode</label>
                                    <input type="text" name="kode" class="form-control" placeholder="Kode" id="kode"
                                        readonly />
                                    @error('kode')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="tanggal" class="control-label">Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control" required
                                        value="{{ date('Y-m-d') }}" id="tanggal" />
                                    @error('tanggal')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="no_cek_giro">No. Cek/Giro</label>
                                    <select name="no_cek_giro" id="no_cek_giro" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        @forelse ($cekGiroBelumLunas as $item)
                                            @if ($item->pembelian)
                                                @foreach ($item->pembelian->pembelian_pembayaran as $bayar)
                                                    <option value="{{ $item->id }}">
                                                        {{ $bayar->no_cek_giro }}
                                                    </option>
                                                @endforeach
                                            @else
                                                @foreach ($item->penjualan->penjualan_pembayaran as $bayar)
                                                    <option value="{{ $item->id }}">
                                                        {{ $bayar->no_cek_giro }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        @empty
                                            <option value="" disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                    @error('pembelian')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label for="jenis_cek_giro" class="control-label">Jenis Cek/Giro</label>
                                    <input type="text" name="jenis_cek_giro" class="form-control"
                                        placeholder="Jenis Cek/Giro" id="jenis_cek_giro" disabled />
                                    @error('jenis_cek_giro')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="tgl_cek_giro" class="control-label">Tanggal Cek/Giro</label>
                                    <input type="text" name="tgl_cek_giro" class="form-control"
                                        placeholder="Tanggal Cek/Giro" id="tgl_cek_giro" disabled />
                                    @error('tgl_cek_giro')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="matauang" class="control-label">Mata Uang</label>
                                    <input type="text" name="matauang" class="form-control" placeholder="Mata Uang"
                                        id="matauang" disabled />
                                    @error('matauang')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="rate" class="control-label">Rate</label>
                                    <input type="text" name="rate" class="form-control" placeholder="Rate" id="rate"
                                        disabled />
                                    @error('rate')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
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
                            <h4 class="panel-title">{{ trans('cek_giro_tolak.title.detail_info') }}</h4>
                        </div>

                        <div class="panel-body">
                            <div class="form-group row" style="margin-bottom: 10px">
                                {{-- Referensi Nomor --}}
                                <div class="col-md-4" style="margin-top: 1em;">
                                    <label for="referensi_nomor">Referensi Nomor </label>
                                    <input type="text" step="any" name="referensi_nomor" id="referensi_nomor"
                                        class="form-control" placeholder="Referensi Nomor " disabled />
                                    @error('referensi_nomor')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Referensi Nama --}}
                                <div class="col-md-4" style="margin-top: 1em;">
                                    <label for="referensi_nama">Referensi Nama</label>
                                    <input type="text" name="referensi_nama" id="referensi_nama" class="form-control"
                                        placeholder="Referensi Nama" disabled />
                                    @error('referensi_nama')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- nilai_cek_giro --}}
                                <div class="col-md-4" style="margin-top: 1em;">
                                    <label for="nilai_cek_giro">Nilai Cek/Giro</label>
                                    <input type="text" step="any" name="nilai_cek_giro" id="nilai_cek_giro"
                                        class="form-control" placeholder="Nilai Cek/Giro" disabled />
                                    @error('nilai_cek_giro')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- keterangan --}}
                                <div class="col-md-12" style="margin-top: 1em;">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control" required
                                        placeholder="Keterangan" rows="5"></textarea>
                                    @error('keterangan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12" style="margin-top: 1em;">
                                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                                </div>
                                {{-- </form> --}}
                            </div>
                        </div>
                        {{-- end panel-body --}}
                    </div>
                    {{-- panel-inverse --}}
                </div>
                {{-- end col-md-12 --}}
            </form>
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->
@endsection

@push('custom-js')
    <script>
        get_kode()

        $('#no_cek_giro').change(function() {
            // tipe cek in/out | pembelian/penjualan
            let tipe_cek_giro = []
            let nama = ''
            let jenis_cek_giro = $('#jenis_cek_giro')
            let tgl_cek_giro = $('#tgl_cek_giro')
            let matauang = $('#matauang')
            let rate = $('#rate')
            let referensi_nama = $('#referensi_nama')
            let referensi_nomor = $('#referensi_nomor')
            let nilai_cek_giro = $('#nilai_cek_giro')

            $.ajax({
                url: "/keuangan/cek-giro-tolak/get-cek-giro-by-id/" + $(this).val(),
                type: 'GET',
                success: function(data) {
                    if (data.penjualan) {
                        tipe_cek_giro = data.penjualan.penjualan_pembayaran
                        nama = data.penjualan.pelanggan.nama_pelanggan
                    } else {
                        tipe_cek_giro = data.pembelian.pembelian_pembayaran
                        nama = data.pembelian.supplier ? data.pembelian.supplier.nama_supplier :
                            'Tanpa Supplier'
                    }

                    jenis_cek_giro.val('Loading...')
                    tgl_cek_giro.val('Loading...')
                    matauang.val('Loading...')
                    rate.val('Loading...')
                    referensi_nama.val('Loading...')
                    referensi_nomor.val('Loading...')
                    nilai_cek_giro.val('Loading...')

                    setTimeout(() => {
                        jenis_cek_giro.val(data.jenis_cek.toString().toUpperCase())

                        let format_date = new Date(tipe_cek_giro[0].tgl_cek_giro)

                        tgl_cek_giro.val(format_date.toLocaleDateString('id-ID'))
                        referensi_nama.val(nama)

                        matauang.val(
                            data.penjualan ? data.penjualan.matauang.kode :
                            data.pembelian.matauang.kode
                        )

                        rate.val(
                            data.penjualan ? data.penjualan.rate :
                            data.pembelian.rate
                        )

                        referensi_nomor.val(
                            data.penjualan ? data.penjualan.kode :
                            data.pembelian.kode
                        )

                        nilai_cek_giro.val(tipe_cek_giro[0].bayar)
                    }, 1500);
                }
            })
        })

        $('#tanggal').change(function() {
            get_kode()
        })

        function get_kode() {
            $.ajax({
                url: "/keuangan/cek-giro-tolak/generate-kode/" + $('input[name="tanggal"]').val(),
                type: 'GET',
                success: function(data) {
                    $('input[name="kode"]').val('Loading...')

                    setTimeout(() => {
                        $('input[name="kode"]').val(data)
                    }, 1000)
                }
            })
        }
    </script>
@endpush
