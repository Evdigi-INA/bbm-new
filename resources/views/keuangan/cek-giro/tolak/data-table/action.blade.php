@if (auth()->user()->can('edit cek/giro tolak') ||
    auth()->user()->can('delete cek/giro tolak'))
    <td>
        @can('edit cek/giro tolak')
            <a href="{{ route('cek-giro-tolak.edit', $model->id) }}" class="btn btn-success btn-icon btn-circle">
                <i class="fa fa-edit"></i>
            </a>
        @endcan

        @can('detail cek/giro tolak')
            <a href="{{ route('cek-giro-tolak.show', $model->id) }}" class="btn btn-info btn-icon btn-circle">
                <i class="fa fa-eye"></i>
            </a>
        @endcan

        @can('delete cek/giro tolak')
            <form action="{{ route('cek-giro-tolak.destroy', $model->id) }}" method="post" class="d-inline"
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
