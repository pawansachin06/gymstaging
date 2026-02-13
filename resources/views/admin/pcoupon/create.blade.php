@extends('layouts.app')

@section('content')
<a href="{{ route('admin.pcoupon.index') }}" class="btn btn-default"  style= "float:right">Back To Coupons</a>
    <h3 class="page-title">@lang('quickadmin.coupons.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.pcoupon.store']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>
        
        <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-6 form-group">
                            {!! Form::label('name', trans('quickadmin.pcoupon.fields.name').'*', ['class' => 'control-label']) !!}
                            {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('name'))
                                <p class="help-block">
                                    {{ $errors->first('name') }}
                                </p>
                            @endif
                        </div>
                        <div class="col-xs-6 form-group">
                            {!! Form::label('name', trans('quickadmin.pcoupon.fields.code').'*', ['class' => 'control-label']) !!}
                            {!! Form::text('code', old('code'), ['class' => 'form-control', 'placeholder' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('code'))
                                <p class="help-block">
                                    {{ $errors->first('code') }}
                                </p>
                            @endif
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-xs-6 form-group">
                            {!! Form::label('type', trans('quickadmin.pcoupon.fields.type').'', ['class' => 'control-label']) !!}
                            {!! Form::select('type', \App\Models\Couponproducts::$types, old('type'), ['class' => 'form-control']) !!}
                            <p class="help-block"></p>
                        </div>
                        <div class="col-xs-6 form-group">
                            {!! Form::label('value', trans('quickadmin.pcoupon.fields.value').'*', ['class' => 'control-label']) !!}
                            {!! Form::text('value', old('value'), ['class' => 'form-control', 'placeholder' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('value'))
                                <p class="help-block">
                                    {{ $errors->first('value') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 form-group">
                            {!! Form::label('max_red', trans('quickadmin.pcoupon.fields.max_red').'*', ['class' => 'control-label']) !!}
                            {!! Form::number('maximum_redemptions', old('maximum_redemptions'), ['class' => 'form-control', 'placeholder' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('maximum_redemptions'))
                                <p class="help-block">
                                    {{ $errors->first('maximum_redemptions') }}
                                </p>
                            @endif
                        </div>
                        <div class="col-xs-6 form-group">
                            {!! Form::label('Status', trans('quickadmin.pcoupon.fields.status').'', ['class' => 'control-label']) !!}
                            <br>
                               <label class="switch">
                                        <input type="hidden" name="status" value="0">
                                        <input type="checkbox" name="status"  value="1" checked ><span class="slider"></span>
                                </label>
                            <p class="help-block"></p>
                            @if($errors->has('status'))
                                <p class="help-block">
                                    {{ $errors->first('status') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            {!! Form::label('product_id', trans('quickadmin.pcoupon.fields.select_product').'*', ['class' => 'control-label']) !!}
                            {!! Form::select('product_id[]', $products, old('product_id'), ['class' => 'form-control select2','multiple' => 'multiple']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('product_id'))
                                <p class="help-block">
                                    {{ $errors->first('product_id') }}
                                </p>
                            @endif
                        </div>
                    </div>
            {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
        </div>
    </div>

   
    {!! Form::close() !!}
@stop

<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>