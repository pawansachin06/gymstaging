@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.cities.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.cities.fields.name')</th>
                            <td field-key='name'>{{ $city->name }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    
<li role="presentation" class="active"><a href="#lists" aria-controls="lists" role="tab" data-toggle="tab">Lists</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    
<div role="tabpanel" class="tab-pane active" id="lists">
<table class="table table-bordered table-striped {{ count($listings) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.listings.fields.name')</th>
                        <th>@lang('quickadmin.listings.fields.city')</th>
                        <th>@lang('quickadmin.listings.fields.businesses')</th>
                        <th>@lang('quickadmin.listings.fields.address')</th>
                        <th>@lang('quickadmin.listings.fields.description')</th>
                        <th>@lang('quickadmin.listings.fields.logo')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($listings) > 0)
            @foreach ($listings as $listing)
                <tr data-entry-id="{{ $listing->id }}">
                    <td field-key='name'>{{ $listing->name }}</td>
                                <td field-key='city'>{{ $listing->city->name or '' }}</td>
                                <td field-key='businesses'>
                                    <span class="label label-info label-many">{{ $listing->business->name }}</span>
                                </td>
                                <td field-key='address'>{{ $listing->address }}</td>
                                <td field-key='description'>{!! $listing->description !!}</td>
                                <td field-key='logo'>@if($listing->logo)
                                        <a href="{{ $listing->getUrl('logo') }}" target="_blank">
                                            <img src="{{ $listing->getUrl('logo') }}"/>
                                        </a>@endif</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                @can('listing_delete')
                                    {{ html()->form('POST', route('admin.listings.restore', $listing->id))
                                        ->style('display: inline-block;')
                                        ->onsubmit("return confirm('" . trans('quickadmin.qa_are_you_sure') . "');")
                                        ->open() }}
                                        {{ html()->submit(trans('quickadmin.qa_restore'))->class('btn btn-xs btn-success') }}
                                    {{ html()->form()->close() }}
                                @endcan
                                @can('listing_delete')
                                    {{ html()->form('DELETE', route('admin.listings.perma_del', $listing->id))
                                        ->style('display: inline-block;')
                                        ->onsubmit("return confirm('" . trans('quickadmin.qa_are_you_sure') . "');")
                                        ->open() }}
                                        {{ html()->submit(trans('quickadmin.qa_permadel'))->class('btn btn-xs btn-danger') }}
                                    {{ html()->form()->close() }}
                                @endcan
                                </td>
                                @else
                                <td>
                                    @can('listing_view')
                                    <a href="{{ route('admin.listings.show',[$listing->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('listing_edit')
                                    <a href="{{ route('admin.listings.edit',[$listing->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('listing_delete')
                                        {{ html()->form('DELETE', route('admin.listings.destroy', $listing->id))
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
                <td colspan="10">@lang('quickadmin.qa_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
</div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.cities.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_listing')</a>
        </div>
    </div>
@stop
