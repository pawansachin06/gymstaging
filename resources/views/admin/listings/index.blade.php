@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.listings.title')</h3>
    @can('listing_create')
        <p>
            <a href="{{ route('admin.listings.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>

        </p>
    @endcan

    @can('listing_delete')
        <p>
        <ul class="list-inline">
            <li><a href="{{ route('admin.listings.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('quickadmin.qa_all')</a></li>
            |
            <li><a href="{{ route('admin.listings.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('quickadmin.qa_trash')</a></li>
        </ul>
        </p>
    @endcan


    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_listing')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($listings) > 0 ? 'datatable' : '' }} @can('listing_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                <tr>
                    @can('listing_delete')
                        @if ( request('show_deleted') != 1 )
                            <th style="text-align:center;"><input type="checkbox" id="select-all"/></th>@endif
                    @endcan

                    <th>@lang('quickadmin.listings.fields.name')</th>
                    <th>@lang('quickadmin.listings.fields.city')</th>
                    <th>@lang('quickadmin.listings.fields.businesses')</th>
                    <th>@lang('quickadmin.listings.fields.address')</th>
                    <th>@lang('quickadmin.listings.fields.email')</th>
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
                            @can('listing_delete')
                                @if ( request('show_deleted') != 1 )
                                    <td></td>@endif
                            @endcan
                            <td field-key='name'>{{ $listing->name }}</td>
                            <td field-key='city'>{{ @$listing->address->city }}</td>
                            <td field-key='businesses'>
                                <span class="label label-info label-many">{{ $listing->business->name }}</span>
                            </td>
                            <td field-key='address'>{{$listing->fullAddress}}</td>
                            <td field-key='email'>{{@$listing->user->email}}</td>
                            <td field-key='description'>{!! $listing->description !!}</td>
                            <td field-key='logo'>@if($listing->logo)<a href="{{ $listing->getUrl('logo') }}" target="_blank"><img src="{{ $listing->getUrl('logo') }}"/></a>@endif</td>
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
                                        <a href="{{ route('listing.view',[$listing->slug]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('listing_edit')
                                        <a href="{{ route('admin.business.edit',$listing->id) }}" target="_blank" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                        <a href="{{ route('admin.listings.edit',[$listing->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit_meta')</a>
                                    @endcan
                                    @can('listing_delete')
                                        {{ html()->form('DELETE', route('admin.listings.destroy', $listing->id))
                                            ->style('display: inline-block;')
                                            ->onsubmit("return confirm('" . trans('quickadmin.qa_are_you_sure') . "');")
                                            ->open() }}
                                            {{ html()->submit(trans('quickadmin.qa_delete'))->class('btn btn-xs btn-danger') }}
                                        {{ html()->form()->close() }}
                                    @endcan
                                    @can('listing_payment')
                                        @if(@$listing->user->subscription)
                                            <a href="{{ route('admin.listings.payment',[@$listing->user->subscription->id]) }}" class="btn btn-xs btn-info">Payment</a>
                                        @endif
                                    @endcan
                                    @can('listing_review')
                                        <a href="{{ route('admin.listings.review' ,[@$listing->id]) }}" class="btn btn-xs  btn-primary">Review</a>
                                    @endcan
                                    @if(@$listing->verified == 0)
                                        @can('listing_verify')
                                            <a href="{{ route('admin.listings.verify' ,[@$listing->id]) }}" class="btn btn-xs  btn-primary">Verify</a>
                                        @endcan
                                    @endif
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
        @can('listing_delete')
            @if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('admin.listings.mass_destroy') }}'; @endif
        @endcan
    </script>
@endsection
