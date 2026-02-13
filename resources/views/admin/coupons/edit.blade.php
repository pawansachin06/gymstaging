@extends('layouts.app')

@section('content')
<a href="{{ route('admin.coupon.index') }}" style = "float:right" class="btn btn-default">Back To Coupons</a>
    <h3 class="page-title">@lang('quickadmin.coupons.title')</h3>
    {!! Form::model($coupon, ['method' => 'PUT', 'route' => ['admin.coupon.update', $coupon->id]]) !!}

    <div class="panel panel-default">
        @include('admin.coupons.partial.form')
    </div>
    {!! Form::close() !!}
@stop

