@if (auth()->user()->can('edit pelunasan piutang') ||
    auth()->user()->can('delete pelunasan piutang'))
    <td>
        @can('edit pelunasan piutang')
            <a href="{{ route('pelunasan-piutang.edit', $model->id) }}" class="btn btn-success btn-icon btn-circle">
                <i class="fa fa-edit"></i>
            </a>
        @endcan

        @can('detail pelunasan piutang')
            <a href="{{ route('pelunasan-piutang.show', $model->id) }}" class="btn btn-info btn-icon btn-circle">
                <i class="fa fa-eye"></i>
            </a>
        @endcan

        @can('delete pelunasan piutang')
            <form action="{{ route('pelunasan-piutang.destroy', $model->id) }}" method="post" class="d-inline"
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
