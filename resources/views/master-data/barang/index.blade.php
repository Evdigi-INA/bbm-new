@extends('layouts.dashboard')

@section('title', trans('barang.title.index'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('barang') }}
        <!-- begin row -->
        <div class="row">
            <!-- begin col-12 -->
            <div class="col-md-12">
                <!-- begin panel -->
                <div class="panel panel-inverse">
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
                        <a href="{{ route('barang.create') }}" class="btn btn-success{{ !auth()->user()->can('create barang') ? ' disabled' : '' }}">
                            <i class="fa fa-plus-square-o"></i> {{ trans('barang.button.tambah') }}
                        </a>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped data-table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Gambar</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Jenis</th>
                                        <th>Kategori</th>
                                        <th>Satuan</th>
                                        <th>Harga Beli</th>
                                        <th>Harga Jual</th>
                                        <th>Harga Min. Jual</th>
                                        <th>Stok</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        @if (auth()->user()->can('edit barang') ||
        auth()->user()->can('delete barang'))
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                            </table>
                        </div>
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
        const action =
            '{{ auth()->user()->can('edit barang') ||
auth()->user()->can('delete barang')
    ? 'yes yes yes'
    : '' }}'

        let columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'gambar',
                name: 'gambar',
                orderable: false,
                searchable: false,
                render: function(data, type, full, meta) {
                    return `<img src="${data}" alt="gambar barang" class="img-fluid rounded"
                    style = "width: 60px; height: 60px; object-fit: cover; border-radius: 3px;" > `;
                }
            }, {
                data: 'kode',
                name: 'kode'
            }, {
                data: 'nama',
                name: 'nama'
            }, {
                data: 'jenis',
                name: 'jenis'
            }, {
                data: 'kategori',
                name: 'kategori'
            }, {
                data: 'satuan',
                name: 'satuan'
            }, {
                data: 'harga_beli',
                name: 'harga_beli'
            }, {
                data: 'harga_jual',
                name: 'harga_jual'
            }, {
                data: 'harga_jual_min',
                name: 'harga_jual_min'
            }, {
                data: 'stok',
                name: 'stok'
            }, {
                data: 'status',
                name: 'status'
            }, {
                data: 'created_at',
                name: 'created_at'
            }, {
                data: 'updated_at',
                name: 'updated_at'
            }
        ]

        if (action) {
            columns.push({
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            })
        }

        $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('barang.index') }}",
            columns: columns,
        });
    </script>
@endpush
