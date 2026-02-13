@extends('layouts.app')

@section('content')
<a href="{{ route('admin.product_order.index') }}" class="btn btn-default" style= "float:right">Back to All Product Orders</a>
    <h3 class="page-title">@lang('quickadmin.product_order.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        @php
                            $productDetails = json_decode($productOrder->product_details);
                            $couponDetails = json_decode($productOrder->coupon_details);
                        @endphp
                        <tr>
                            <th>@lang('quickadmin.product_order.fields.id')</th>
                            <td field-key='name'>{{ $productOrder->id }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.product_order.fields.reference_id')</th>
                            <td field-key='email'>{{ $productOrder->reference_id }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.product_order.fields.name')</th>
                            <td field-key='role'>{{ $productOrder->customer_name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.product_order.fields.email')</th>
                            <td field-key='role'>{{ $productOrder->customer_email }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.product_order.fields.product_name')</th>
                            <td field-key='role'>{{ $productDetails->name }} </td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.product_order.fields.actual_price')</th>
                            <td field-key='role'>£{{ $productOrder->actual_price }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.product_order.fields.discount')</th>
                            @if(empty($productOrder->discount))
                                <td field-key='role'>£0.00</td>
                            @else
                                <td field-key='role'>£{{ $productOrder->discount }} <b> Coupon Code: {{ $couponDetails->code }} </b></td>
                            @endif
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.product_order.fields.net_price')</th>
                            <td field-key='role'>£{{ $productOrder->net_price }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.product_order.fields.stripe_payment_id')</th>
                            <td field-key='role'>{{ $productOrder->stripe_payment_id }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.product_order.fields.created_at')</th>
                            <td field-key='role'>{{ $productOrder->created_at }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

        </div>
    </div>
@stop
