@if (auth()->user()->can('edit rate mata uang') ||
    auth()->user()->can('delete rate mata uang'))
    <td>
        @can('edit rate mata uang')
            <a href="{{ route('rate-matauang.edit', $model->id) }}" class="btn btn-success btn-icon btn-circle">
                <i class="fa fa-edit"></i>
            </a>
        @endcan

        @can('delete rate mata uang')
            <form action="{{ route('rate-matauang.destroy', $model->id) }}" method="post" class="d-inline"
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
