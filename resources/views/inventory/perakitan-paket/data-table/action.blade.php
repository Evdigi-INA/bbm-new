@if (auth()->user()->can('edit perakitan paket') ||
    auth()->user()->can('delete perakitan paket'))
    <td>
        @can('edit perakitan paket')
            <a href="{{ route('perakitan-paket.edit', $model->id) }}" class="btn btn-success btn-icon btn-circle">
                <i class="fa fa-edit"></i>
            </a>
        @endcan

        @can('detail perakitan paket')
            <a href="{{ route('perakitan-paket.show', $model->id) }}" class="btn btn-info btn-icon btn-circle">
                <i class="fa fa-eye"></i>
            </a>
        @endcan

        @can('delete perakitan paket')
            <form action="{{ route('perakitan-paket.destroy', $model->id) }}" method="post" class="d-inline"
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
