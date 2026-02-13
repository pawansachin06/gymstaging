@can($gateKey.'delete')
    {{ html()->form('POST', route($routeKey.'.restore', $row->id))
        ->style('display: inline-block;')
        ->onsubmit("return confirm('" . trans('quickadmin.qa_are_you_sure') . "');")
        ->open() }}
        {{ html()->submit(trans('quickadmin.qa_restore'))->class('btn btn-xs btn-success') }}
    {{ html()->form()->close() }}
@endcan

@can($gateKey.'delete')
    {{ html()->form('DELETE', route($routeKey.'.perma_del', $row->id))
        ->style('display: inline-block;')
        ->onsubmit("return confirm('" . trans('quickadmin.qa_are_you_sure') . "');")
        ->open() }}
        {{ html()->submit(trans('quickadmin.qa_permadel'))->class('btn btn-xs btn-danger') }}
    {{ html()->form()->close() }}
@endcan