@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.product_order.title')</h3>
    <ul class="list-inline">
        <li><a href="{{ route('admin.product_order.index') }}?is_completed=0"
               style="{{ (request('is_completed') == 0 || empty(request('is_completed')))? 'font-weight: 700' : '' }}">@lang('quickadmin.qa_pending')</a></li>
        |
        <li><a href="{{ route('admin.product_order.index') }}?is_completed=1"
               style="{{ (request('is_completed') == 1)? 'font-weight: 700' : '' }}">@lang('quickadmin.qa_completed')</a></li>
    </ul>
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_product_orders')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($productOrders) > 0 ? 'datatable' : '' }}">
                <thead>
                    <tr>
                        <th>@lang('quickadmin.product_order.fields.id')</th>
                        <th>@lang('quickadmin.product_order.fields.reference_id')</th>
                        <th>@lang('quickadmin.product_order.fields.name')</th>
                        <th>@lang('quickadmin.product_order.fields.email')</th>
                        <th>@lang('quickadmin.product_order.fields.product_name')</th>
                        <th>@lang('quickadmin.product_order.fields.net_price')</th>
                        <th>@lang('quickadmin.product_order.fields.created_at')</th>
                        @if(request('is_completed') == 0 || empty(request('is_completed')))
                            <th>@lang('quickadmin.product_order.fields.mark_as_completed')</th>
                        @endif
                        <th>&nbsp;</th>

                    </tr>
                </thead>
                
                <tbody>
                    @if (count($productOrders) > 0)
                        @foreach ($productOrders as $productOrder)
                            <tr data-entry-id="{{ $productOrder->id }}">
                                <td field-key='name'>{{ $productOrder->id }}</td>
                                <td field-key='name'>{{ $productOrder->reference_id }}</td>
                                <td field-key='name'>{{ $productOrder->customer_name }}</td>
                                <td field-key='email'>{{ $productOrder->customer_email }}</td>
                                <td field-key='product_name'>{{ json_decode($productOrder->product_details)->name }}</td>
                                <td field-key='net_amount'><b>£{{ $productOrder->net_price }}</b></td>
                                <td field-key='created_at'>{{ $productOrder->created_at }}</td>
                                @if(request('is_completed') == 0 || empty(request('is_completed')))
                                    <td field-key='mark_as_completed'><a href="{{ route('admin.product_order.mark_as_completed', ['id' => $productOrder->id]) }}" class="btn btn-success">Mark As Completed</a></td>
                                @endif
                                <td>
                                    @can('product_order_management_view')
                                    <a href="{{ route('admin.product_order.show',[$productOrder->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                </td>
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
@stop

@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.21/sorting/datetime-moment.js"></script>
    <script>
        $.fn.dataTable.moment('DD/MM/YYYY')
    </script>
@endsection
