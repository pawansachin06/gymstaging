@extends('layouts.app')

@section('content')
<a href="{{ route('admin.coupon.index') }}" style = "float:right" class="btn btn-default">Back To Coupons</a>
    <h3 class="page-title">@lang('quickadmin.coupons.title')</h3>
    {{ html()->form('POST', route('admin.coupon.store'))->acceptsFiles()->attribute('autocomplete', 'off')->open() }}

    <div class="panel panel-default">
        @include('admin.coupons.partial.form')
    </div>

    {{ html()->form()->close() }}
@stop
