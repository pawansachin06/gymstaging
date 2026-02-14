@can($gateKey.'view')
    <a href="{{ route($routeKey.'.show', $row->id) }}"
       class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
@endcan
@can($gateKey.'edit')
    <a href="{{ route($routeKey.'.edit', $row->id) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
@endcan
@can($gateKey.'delete')
    {{ html()->form('DELETE', route($routeKey . '.destroy', $row->id))
        ->attribute('style', 'display: inline-block;')
        ->attribute('onsubmit', "return confirm('" . trans('quickadmin.qa_are_you_sure') . "');")
        ->open() }}
    {{ html()->submit(trans('quickadmin.qa_delete'))->class('btn btn-xs btn-danger') }}
    {{ html()->form()->close() }}
@endcan