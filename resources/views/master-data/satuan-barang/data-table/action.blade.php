@if (auth()->user()->can('edit satuan') ||
    auth()->user()->can('delete satuan'))
    <td>
        @can('edit satuan')
            <a href="{{ route('satuan-barang.edit', $model->id) }}" class="btn btn-success btn-icon btn-circle">
                <i class="fa fa-edit"></i>
            </a>
        @endcan

        @can('delete satuan')
            <form action="{{ route('satuan-barang.destroy', $model->id) }}" method="post" class="d-inline"
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
