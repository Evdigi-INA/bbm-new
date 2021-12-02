@if (auth()->user()->can('edit retur penjualan') ||
    auth()->user()->can('delete retur penjualan'))
    <td>
        @can('edit retur penjualan')
            <a href="{{ route('retur-penjualan.edit', $model->id) }}" class="btn btn-success btn-icon btn-circle">
                <i class="fa fa-edit"></i>
            </a>
        @endcan

        @can('detail retur penjualan')
            <a href="{{ route('retur-penjualan.show', $model->id) }}" class="btn btn-info btn-icon btn-circle">
                <i class="fa fa-eye"></i>
            </a>
        @endcan

        @can('delete retur penjualan')
            <form action="{{ route('retur-penjualan.destroy', $model->id) }}" method="post" class="d-inline"
                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                @csrf
                @method('delete')

                <button class="btn btn-danger btn-icon btn-circle">
                    <i class="ace-icon fa fa-trash"></i>
                </button>
            </form>
        @endcan
    </td>
@endif
