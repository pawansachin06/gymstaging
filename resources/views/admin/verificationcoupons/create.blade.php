@extends('layouts.app')

@section('content')
    <a href="{{ route('admin.verificationcoupon.index') }}" style = "float:right" class="btn btn-default">Back To Coupons</a>
    <h3 class="page-title">@lang('quickadmin.verificationcoupons.title')</h3>
    {{ html()->form('POST', route('admin.verificationcoupon.store'))->acceptsFiles()->attribute('autocomplete', 'off')->open() }}
    <div class="panel panel-default">
        @include('admin.verificationcoupons.partial.form')
    </div>

    {{ html()->form()->close() }}
@stop