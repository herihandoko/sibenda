@isset($button->show)
    @can($button->show->permission)
        <a class="btn-sm btn-primary" href="{{ $button->show->link }}"><i class="far fa-eye"></i> View</a>
    @endcan
@endisset


@isset($button->hide)
    @can($button->hide->permission)
        <a class="btn-sm text-white {{ $button->hide->status === 0 ? ' btn-warning' : 'btn-success' }} mr-2"
            href="{{ $button->hide->link }}">
            <i class="{{ $button->hide->status === 0 ? ' fas fa-eye-slash' : 'fas fa-eye' }}"></i>
        </a>
    @endcan
@endisset

@isset($button->edit)
    @can($button->edit->permission)
        <a class="btn-sm btn-primary" href="{{ $button->edit->link }}"><i class="far fa-edit"></i></a>
    @endcan
@endisset


@isset($button->delete)
    @can($button->delete->permission)
        <a class="btn-sm btn-danger delete" href="{{ $button->delete->link }}"><i class="far fa-trash-alt"></i></a>
    @endcan
@endisset


