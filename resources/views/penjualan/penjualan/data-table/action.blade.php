@if (auth()->user()->can('edit penjualan') ||
    auth()->user()->can('delete penjualan'))
    <td>
        @can('edit penjualan')
            <a href="{{ route('penjualan.edit', $model->id) }}" class="btn btn-success btn-icon btn-circle">
                <i class="fa fa-edit"></i>
            </a>
        @endcan

        @can('detail penjualan')
            <a href="{{ route('penjualan.show', $model->id) }}" class="btn btn-info btn-icon btn-circle">
                <i class="fa fa-eye"></i>
            </a>
        @endcan

        @can('delete penjualan')
            <form action="{{ route('penjualan.destroy', $model->id) }}" method="post" class="d-inline"
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
