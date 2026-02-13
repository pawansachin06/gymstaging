@extends('layouts.app')

@section('content')
<a href="{{ route('admin.verificationcoupon.index') }}" style = "float:right" class="btn btn-default">Back To Coupons</a>
    <h3 class="page-title">@lang('quickadmin.verificationcoupons.title')</h3>
    {!! Form::model($coupon, ['method' => 'PUT', 'route' => ['admin.verificationcoupon.update', $coupon->id]]) !!}

    <div class="panel panel-default">
        @include('admin.verificationcoupons.partial.form')
    </div>
    {!! Form::close() !!}
@stop

