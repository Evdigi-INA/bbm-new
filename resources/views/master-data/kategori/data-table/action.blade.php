@if (auth()->user()->can('edit kategori') ||
    auth()->user()->can('delete kategori'))
    <td>
        @can('edit kategori')
            <a href="{{ route('kategori.edit', $model->id) }}" class="btn btn-success btn-icon btn-circle">
                <i class="fa fa-edit"></i>
            </a>
        @endcan

        @can('delete kategori')
            <form action="{{ route('kategori.destroy', $model->id) }}" method="post" class="d-inline"
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
