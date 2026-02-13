@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.seo.title')</h3>
    @can('seometa_create')
    <p>
        <a href="{{ route('admin.seo.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
        
    </p>
    @endcan

    @can('seometa_delete')
    <p>
        <ul class="list-inline">
            <li><a href="{{ route('admin.seo.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('quickadmin.qa_all')</a></li> |
            <li><a href="{{ route('admin.seo.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('quickadmin.qa_trash')</a></li>
        </ul>
    </p>
    @endcan


    <div class="panel panel-default">
        <div class="panel-heading">
           SEO meta
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($seo_lists) > 0 ? 'datatable' : '' }} @can('seo_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                    <tr>
                        @can('listing_delete')
                            @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        @endcan

                        <th>@lang('quickadmin.seo.fields.page_url')</th>
                        <th>@lang('quickadmin.seo.fields.meta_title')</th>
                        <th>@lang('quickadmin.seo.fields.meta_description')</th>
                        <th>@lang('quickadmin.seo.fields.meta_keyword')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($seo_lists) > 0)
                        @foreach ($seo_lists as $seo_list)
                            <tr data-entry-id="{{ $seo_list->id }}">
                                @can('seo_delete')
                                    @if ( request('show_deleted') != 1 )<td></td>@endif
                                @endcan

                                <td field-key='page_url'>{{ $seo_list->page_url }}</td>
                                <td field-key='meta_title'>{{ $seo_list->title }}</td>
                                <td field-key='meta_description'>{{ $seo_list->description }}</td>
                                <td field-key='meta_keyword'>{{ $seo_list->keywords }}</td>
                                
                                @if( request('show_deleted') == 1 )
                                <td>
                                    @can('seometa_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.seo.restore', $seo_list->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                    @can('seometa_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.seo.perma_del', $seo_list->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                </td>
                                @else
                                <td>
                                    @can('seometa_view')
                                    <a href="{{ route('admin.seo.show',[$seo_list->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('seometa_edit')
                                    <a href="{{ route('admin.seo.edit',[$seo_list->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('seometa_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.seo.destroy', $seo_list->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="11">@lang('quickadmin.qa_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        @can('seo_delete')
            @if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('admin.seo.mass_destroy') }}'; @endif
        @endcan

    </script>
@endsection
