@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.businesses.title')</h3>
    @can('business_create')
    <p>
        <a href="{{ route('admin.businesses.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
        
    </p>
    @endcan

    @can('business_delete')
    <p>
        <ul class="list-inline">
            <li><a href="{{ route('admin.businesses.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('quickadmin.qa_all')</a></li> |
            <li><a href="{{ route('admin.businesses.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('quickadmin.qa_trash')</a></li>
        </ul>
    </p>
    @endcan


    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_listing')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($businesses) > 0 ? 'datatable' : '' }} @can('business_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                    <tr>
                        @can('business_delete')
                            @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        @endcan

                        <th>@lang('quickadmin.businesses.fields.name')</th>
                        <th>Icon</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($businesses) > 0)
                        @foreach ($businesses as $business)
                            <tr data-entry-id="{{ $business->id }}">
                                @can('business_delete')
                                    @if ( request('show_deleted') != 1 )<td></td>@endif
                                @endcan

                                <td field-key='name'>{{ $business->name }}</td>
                                <td field-key='icon'>{{ $business->icon }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    @can('business_delete')
                                    {{ html()->form('POST', route('admin.businesses.restore', $business->id))
                                        ->style('display: inline-block;')
                                        ->onsubmit("return confirm('" . trans('quickadmin.qa_are_you_sure') . "');")
                                        ->open() }}
                                    {{ html()->submit(trans('quickadmin.qa_restore'))->class('btn btn-xs btn-success') }}
                                    {{ html()->form()->close() }}
                                @endcan
                                    @can('business_delete')
                                    {{ html()->form('DELETE', route('admin.businesses.perma_del', $business->id))
                                        ->style('display: inline-block;')
                                        ->onsubmit("return confirm('" . trans('quickadmin.qa_are_you_sure') . "');")
                                        ->open() }}
                                    {{ html()->submit(trans('quickadmin.qa_permadel'))->class('btn btn-xs btn-danger') }}
                                    {{ html()->form()->close() }}
                                @endcan
                                </td>
                                @else
                                <td>
                                    @can('business_view')
                                    <a href="{{ route('admin.businesses.show',[$business->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('business_edit')
                                    <a href="{{ route('admin.businesses.edit',[$business->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('business_delete')
                                        {{ html()->form('DELETE', route('admin.businesses.destroy', $business->id))
                                            ->style('display: inline-block;')
                                            ->onsubmit("return confirm('" . trans('quickadmin.qa_are_you_sure') . "');")
                                            ->open() }}
                                        {{ html()->submit(trans('quickadmin.qa_delete'))->class('btn btn-xs btn-danger') }}
                                        {{ html()->form()->close() }}
                                    @endcan
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">@lang('quickadmin.qa_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        @can('business_delete')
            @if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('admin.businesses.mass_destroy') }}'; @endif
        @endcan

    </script>
@endsection
