@if (auth()->user()->can('edit pelunasan hutang') ||
    auth()->user()->can('delete pelunasan hutang'))
    <td>
        @can('edit pelunasan hutang')
            <a href="{{ route('pelunasan-hutang.edit', $model->id) }}" class="btn btn-success btn-icon btn-circle">
                <i class="fa fa-edit"></i>
            </a>
        @endcan

        @can('detail pelunasan hutang')
            <a href="{{ route('pelunasan-hutang.show', $model->id) }}" class="btn btn-info btn-icon btn-circle">
                <i class="fa fa-eye"></i>
            </a>
        @endcan

        @can('delete pelunasan hutang')
            <form action="{{ route('pelunasan-hutang.destroy', $model->id) }}" method="post" class="d-inline"
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
