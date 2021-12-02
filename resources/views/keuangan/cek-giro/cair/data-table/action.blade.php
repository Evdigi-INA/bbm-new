@if (auth()->user()->can('edit cek/giro cair') ||
    auth()->user()->can('delete cek/giro cair'))
    <td>
        @can('edit cek/giro cair')
            <a href="{{ route('cek-giro-cair.edit', $model->id) }}" class="btn btn-success btn-icon btn-circle">
                <i class="fa fa-edit"></i>
            </a>
        @endcan

        @can('detail cek/giro cair')
            <a href="{{ route('cek-giro-cair.show', $model->id) }}" class="btn btn-info btn-icon btn-circle">
                <i class="fa fa-eye"></i>
            </a>
        @endcan

        @can('delete cek/giro cair')
            <form action="{{ route('cek-giro-cair.destroy', $model->id) }}" method="post" class="d-inline"
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
