@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.amenity.title')</h3>
    @can('amenity_create')
        <p>
            <a href="{{ route('admin.amenity.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
        </p>
    @endcan

    @can('amenity_delete')
        <p>
        <ul class="list-inline">
            <li><a href="{{ route('admin.amenity.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('quickadmin.qa_all')</a></li>
            |
            <li><a href="{{ route('admin.amenity.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('quickadmin.qa_trash')</a>
            </li>
        </ul>
        </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            Amenities
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($amenities) > 0 ? 'datatable' : '' }} dt-select">
                <thead>
                <tr>
                    <th style="text-align:center;"><input type="checkbox" id="select-all"/></th>

                    <th>@lang('quickadmin.amenity.fields.name')</th>
                    <th>@lang('quickadmin.amenity.fields.business_name')</th>

                    @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                    @else
                        <th>&nbsp;</th>
                    @endif
                </tr>
                </thead>

                <tbody>
                @if (count($amenities) > 0)
                    @foreach ($amenities as $amenity)
                        <tr data-entry-id="{{ $amenity->id }}">
                            <td></td>
                            <td field-key='name'>{{ $amenity->name }}</td>
                            <td field-key='businesses'>
                                <span class="label label-info label-many">{{ $amenity->business->name }}</span>
                            </td>

                            @if( request('show_deleted') == 1 )

                                <td>
                                    @can('amenity_delete')
                                        {!! Form::open(array(
        'style' => 'display: inline-block;',
        'method' => 'POST',
        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
        'route' => ['admin.amenity.restore', $amenity->id])) !!}
                                        {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                    @can('amenity_delete')
                                        {!! Form::open(array(
        'style' => 'display: inline-block;',
        'method' => 'DELETE',
        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
        'route' => ['admin.amenity.perma_del', $amenity->id])) !!}
                                        {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                </td>
                            @else
                                <td>
                                    @can('amenity_view')
                                        <a href="{{ route('admin.amenity.show',[$amenity->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('amenity_edit')
                                        <a href="{{ route('admin.amenity.edit',[$amenity->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('amenity_delete')
                                        {!! Form::open(array(
                                                                                'style' => 'display: inline-block;',
                                                                                'method' => 'DELETE',
                                                                                'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                                                                'route' => ['admin.amenity.destroy', $amenity->id])) !!}
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
        @if ( request('show_deleted') != 1 )
            window.route_mass_crud_entries_destroy = '{{ route('admin.amenity.mass_destroy') }}';
        @else
            window.deleteButtonTrans = '{{ trans("quickadmin.qa_restore_selected") }}';
            window.route_mass_crud_entries_destroy = '{{ route('admin.amenity.mass_restore') }}';
        @endif
    </script>
@endsection
