@if (auth()->user()->can('edit pesanan penjualan') ||
    auth()->user()->can('delete pesanan penjualan'))
    <td>
        @can('edit pesanan penjualan')
            <a href="{{ route('pesanan-penjualan.edit', $model->id) }}" class="btn btn-success btn-icon btn-circle">
                <i class="fa fa-edit"></i>
            </a>
        @endcan

        @can('detail pesanan penjualan')
            <a href="{{ route('pesanan-penjualan.show', $model->id) }}" class="btn btn-info btn-icon btn-circle">
                <i class="fa fa-eye"></i>
            </a>
        @endcan

        @can('delete pesanan penjualan')
            <form action="{{ route('pesanan-penjualan.destroy', $model->id) }}" method="post" class="d-inline"
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
