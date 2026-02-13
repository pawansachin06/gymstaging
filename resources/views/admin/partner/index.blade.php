@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">Partner</h3>
    @can('partner_create')
    <p>
        <a href="{{ route('admin.partner.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
        
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
           Partners
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($partners) > 0 ? 'datatable' : '' }}">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Link</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($partners) > 0)
                        @foreach ($partners as $partner)
                                <td field-key='name'>{{ $partner->name }}</td>
                                <td field-key='city'>{{ $partner->link }}</td>
                                <td>
                                    <a href="{{ route('admin.partner.show',[$partner->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    <a href="{{ route('admin.partner.edit',[$partner->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    {{ html()->form('DELETE', route('admin.partner.destroy', $partner->id))
                                        ->style('display: inline-block;')
                                        ->onsubmit("return confirm('" . trans('quickadmin.qa_are_you_sure') . "');")
                                        ->open() }}
                                        {{ html()->submit(trans('quickadmin.qa_delete'))->class('btn btn-xs btn-danger') }}
                                    {{ html()->form()->close() }}
                                </td>
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
