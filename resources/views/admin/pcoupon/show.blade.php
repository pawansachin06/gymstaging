@extends('layouts.app')

@section('content')
<a href="{{ route('admin.pcoupon.index') }}" class="btn btn-default"  style= "float:right">Back To Coupons</a>

    <h3 class="page-title">@lang('quickadmin.coupons.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.pcoupon.fields.name')</th>
                            <td field-key='name'>{{ $coupon_data->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.pcoupon.fields.code')</th>
                            <td field-key='code'>{{ $coupon_data->code }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.pcoupon.fields.type')</th>
                            <td field-key='type'>{{ $coupon_data->type }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.pcoupon.fields.value')</th>
                            <td field-key='value'><span class="label label-info label-many">{{ $coupon_data->value }}</span></td>
                        </tr>
                         <tr>
                            <th>@lang('quickadmin.pcoupon.fields.max_red')</th>
                            <td field-key='max_red'>{{ $coupon_data->maximum_redemptions }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.pcoupon.fields.status')</th>
                            <td field-key='status'>
                                @if($coupon_data->status == '1')
                                    <span class="label label-success label-many">Active</span>
                                @else
                                    <span class="label label-danger label-many">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.pcoupon.fields.product')</th>
                            <td field-key='product'>
                               {{implode(',',$products)}}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

        </div>
    </div>
@stop
