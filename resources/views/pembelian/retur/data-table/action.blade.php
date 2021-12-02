@if (auth()->user()->can('edit retur pembelian') ||
    auth()->user()->can('delete retur pembelian'))
    <td>
        @can('edit retur pembelian')
            <a href="{{ route('retur-pembelian.edit', $model->id) }}" class="btn btn-success btn-icon btn-circle">
                <i class="fa fa-edit"></i>
            </a>
        @endcan

        @can('detail retur pembelian')
            <a href="{{ route('retur-pembelian.show', $model->id) }}" class="btn btn-info btn-icon btn-circle">
                <i class="fa fa-eye"></i>
            </a>
        @endcan

        @can('delete retur pembelian')
            <form action="{{ route('retur-pembelian.destroy', $model->id) }}" method="post" class="d-inline"
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
