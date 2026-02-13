@extends('layouts.app')

@section('content')
<a href="{{ route('admin.listings.index') }}" class="btn btn-default"  style= "float:right">Back To Listings</a>

    <h3 class="page-title">@lang('quickadmin.listings.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.listings.fields.name')</th>
                            <td field-key='name'>{{ $listing->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.listings.fields.city')</th>
                            <td field-key='city'>{{ $listing->city->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.listings.fields.businesses')</th>
                            <td field-key='businesses'>
                                <span class="label label-info label-many">{{ $listing->business->name }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.listings.fields.address')</th>
                            <td field-key='address'>{{ @$listing->fullAddress }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.listings.fields.description')</th>
                            <td field-key='description'>{!! $listing->description !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.listings.fields.logo')</th>
                            <td field-key='logo'>@if($listing->logo)
                                    <a href="{{ $listing->getUrl('logo') }}" target="_blank"><img src="{{ $listing->getUrl('logo') }}"/></a>
                                @endif</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>
        </div>
    </div>
@stop
