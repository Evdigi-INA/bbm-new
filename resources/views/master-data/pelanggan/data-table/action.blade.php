@if (auth()->user()->can('edit pelanggan') ||
    auth()->user()->can('delete pelanggan'))
    <td>
        @can('edit pelanggan')
            <a href="{{ route('pelanggan.edit', $model->id) }}" class="btn btn-success btn-icon btn-circle">
                <i class="fa fa-edit"></i>
            </a>
        @endcan

        @can('delete pelanggan')
            <form action="{{ route('pelanggan.destroy', $model->id) }}" method="post" class="d-inline"
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
