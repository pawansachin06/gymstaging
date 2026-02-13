@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.coupons.title')</h3>
    @can('pcoupon_create')
    <p>
        <a href="{{ route('admin.pcoupon.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
           @lang('quickadmin.coupons.title')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($coupons) > 0 ? 'datatable' : '' }} @can('coupon_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                    <tr>
                        @can('pcoupon_delete')
                            @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        @endcan

                        <th>@lang('quickadmin.pcoupon.fields.name')</th>
                        <th>@lang('quickadmin.pcoupon.fields.code')</th>
                        <th>@lang('quickadmin.pcoupon.fields.type')</th>
                        <th>@lang('quickadmin.pcoupon.fields.value')</th>
                        <th>@lang('quickadmin.pcoupon.fields.max_red')</th>
                        <th>@lang('quickadmin.pcoupon.fields.used')</th>
                        <th>@lang('quickadmin.pcoupon.fields.status')</th>


                        @if( request('show_deleted') == 1 )
                        <th>@lang('quickadmin.pcoupon.fields.option')</th>
                        @else
                        <th>@lang('quickadmin.pcoupon.fields.option')</th>
                        @endif
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($coupons) > 0)
                        @foreach ($coupons as $coupon)
                            <tr data-entry-id="{{ $coupon->id }}">
                                @can('pcoupon_delete')
                                    @if ( request('show_deleted') != 1 )<td></td>@endif
                                @endcan

                                <td field-key='name'>{{ $coupon->name }}</td>
                                <td field-key='code'>{{ $coupon->code }}</td>
                                <td field-key='type'>{{ $coupon->type }}</td>
                                <td field-key='value'><span class="label label-info label-many">{{ $coupon->value }}</span></td>
                                <td field-key='max_red'>{{ $coupon->maximum_redemptions }}</td>
                                <td field-key='used'>{{ $coupon->coupon_used }}</td>
                                
                                    @if($coupon->status == '1')
                                        <td field-key='value'><span class="label label-success label-many">Active</span></td>
                                    @else
                                        <td field-key='value'><span class="label label-danger label-many">Inactive</span></td>
                                    @endif
                                @if( request('show_deleted') == 1 )
                                <td>
                                    @can('pcoupon_delete')
                                    {{ html()->form('POST', route('admin.pcoupon.restore', $coupon->id))
                                        ->style('display: inline-block;')
                                        ->onsubmit("return confirm('" . trans('quickadmin.qa_are_you_sure') . "');")
                                        ->open() }}
                                        {{ html()->submit(trans('quickadmin.qa_restore'))->class('btn btn-xs btn-success') }}
                                    {{ html()->form()->close() }}
                                @endcan
                                    @can('pcoupon_delete')
                                    {{ html()->form('DELETE', route('admin.pcoupon.perma_del', $coupon->id))
                                        ->style('display: inline-block;')
                                        ->onsubmit("return confirm('" . trans('quickadmin.qa_are_you_sure') . "');")
                                        ->open() }}
                                        {{ html()->submit(trans('quickadmin.qa_permadel'))->class('btn btn-xs btn-danger') }}
                                    {{ html()->form()->close() }}
                                @endcan
                                </td>
                                @else
                                <td>
                                    @can('pcoupon_view')
                                    <a href="{{ route('admin.pcoupon.show',[$coupon->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('pcoupon_edit')
                                    <a href="{{ route('admin.pcoupon.edit',[$coupon->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('pcoupon_delete')
                                        {{ html()->form('DELETE', route('admin.pcoupon.destroy', $coupon->id))
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
        @can('pcoupon_delete')
            @if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('admin.pcoupon.mass_destroy') }}'; @endif
        @endcan

    </script>
@endsection
