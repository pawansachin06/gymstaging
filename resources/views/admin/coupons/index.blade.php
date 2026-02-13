@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.coupons.title')</h3>
    @can('coupon_create')
    <p>
        <a href="{{ route('admin.coupon.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
    </p>
    @endcan


    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_coupons')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($coupons) > 0 ? 'datatable' : '' }}">
                <thead>
                    <tr>

                        <th>@lang('quickadmin.coupons.fields.code')</th>
                        <th>@lang('quickadmin.coupons.fields.type')</th>
                        <th>@lang('quickadmin.coupons.fields.value')</th>
                        <th>@lang('quickadmin.coupons.fields.minprice')</th>
                        <th>@lang('quickadmin.coupons.fields.expires_at')</th>
                        <th>@lang('quickadmin.coupons.fields.redemptions')</th>
                        <th>@lang('quickadmin.coupons.fields.max_redemptions')</th>
                        <th>@lang('quickadmin.coupons.fields.status')</th>
                        <th>Coupon Type</th>
                        <th>Option</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($coupons) > 0)
                        @foreach ($coupons as $coupon)
                            <tr data-entry-id="{{ $coupon->id }}">
                                <td field-key='code'>{{ $coupon->code }}</td>
                                <td field-key='type'>{{ $coupon->type ? 'Percentage' : 'Flat Amount' }}</td>
                                <td field-key='value'>
                                    <span class="label label-info label-many">{{ $coupon->value }}</span>
                                </td>
                                <td field-key='minprice'>{{$coupon->minprice}}</td>
                                <td field-key='expires_at'>{{$coupon->expires_at }}</td>
                                <td field-key='count'>{{$coupon->redemptions }}</td>
                                <td field-key='max_redemptions'>{{$coupon->max_redemptions }}</td>
                                <td field-key='status'>{{$coupon->status }}</td>
                                <td field-key='coupon_type'>
                                    @foreach($coupon->business as $business)
                                    <span class="label label-primary label-many">{{ $business->label }}</span>
                                    @endforeach
                                </td>
                                @can('coupon_edit')
                                <td><a href="{{ route('admin.coupon.edit',$coupon->id) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a></td>
                                @endcan
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
