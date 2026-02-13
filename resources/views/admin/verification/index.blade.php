@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')

    <h3 class="page-title">@lang('quickadmin.verification.title')</h3>

    <ul class="list-inline">
        <li><a href="{{ route('admin.verification.index') }}?show_pending=1"
               style="{{ (request('show_deleted') == 1 || request('show_verified') == 1)? '' : 'font-weight: 700' }}">@lang('quickadmin.qa_pending')</a></li>
        |
        <li><a href="{{ route('admin.verification.index') }}?show_verified=1"
               style="{{ (request('show_deleted') == 1 || request('show_pending') == 1)? '' : 'font-weight: 700' }}">@lang('quickadmin.qa_completed')</a></li>
    </ul>

    <div class="panel panel-default">
        <div class="panel-heading">
            Verifications
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($listings) > 0 ? 'datatable' : '' }}">
                <thead>
                <tr>
                    <th>@lang('quickadmin.verification.fields.business_name')</th>
                    <th>@lang('quickadmin.verification.fields.listing_name')</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>

                <tbody>
                @if (count($listings) > 0)
                    @foreach ($listings as $listing)
                        <tr data-entry-id="{{ $listing->id }}">
                            <td field-key='name'>{{ @$listing->user->name }}</td>
                            <td field-key='businesses'>
                                <span class="label label-info label-many">{{ $listing->name }}</span>
                            </td>
                            <td>
                                @can('verification_view')
                                    <a href="{{ route('admin.verification.show',$listing->id) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                @endcan
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
