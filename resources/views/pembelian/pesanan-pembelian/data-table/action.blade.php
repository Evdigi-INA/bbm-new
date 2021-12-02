@if (auth()->user()->can('edit pesanan pembelian') ||
    auth()->user()->can('delete pesanan pembelian'))
    <td>
        @can('edit pesanan pembelian')
            <a href="{{ route('pesanan-pembelian.edit', $model->id) }}" class="btn btn-success btn-icon btn-circle">
                <i class="fa fa-edit"></i>
            </a>
        @endcan

        @can('detail pesanan pembelian')
            <a href="{{ route('pesanan-pembelian.show', $model->id) }}" class="btn btn-info btn-icon btn-circle">
                <i class="fa fa-eye"></i>
            </a>
        @endcan

        @can('delete pesanan pembelian')
            <form action="{{ route('pesanan-pembelian.destroy', $model->id) }}" method="post" class="d-inline"
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
