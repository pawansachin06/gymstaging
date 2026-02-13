@extends('layouts.app')

@section('content')
<a href="{{ route('admin.category.index') }}" class="btn btn-default"  style= "float:right">Back To Categories</a>
    <h3 class="page-title">@lang('quickadmin.category.title')</h3>
    {{ html()->form('POST', route('admin.category.store'))->open() }}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>
        
        <div class="panel-body">
                <div class="row">
                        <div class="col-xs-12 form-group">
                            {{ html()->label(trans('quickadmin.category.fields.business_name') . '*', 'business_id')->class('control-label') }}
                            {{ html()->select('business_id', $businesses, old('business_id'))->class('form-control select2') }}
                            <p class="help-block"></p>
                            @if($errors->has('business_name'))
                                <p class="help-block">
                                    {{ $errors->first('business_name') }}
                                </p>
                            @endif
                        </div>
                    </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {{ html()->label(trans('quickadmin.category.fields.name') . '*', 'name')->class('control-label') }}
                    {{ html()->text('name', old('name'))->class('form-control')->placeholder('')->required() }}
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
            </div>
            {{ html()->submit(trans('quickadmin.qa_save'))->class('btn btn-danger') }}
        </div>
    </div>

   
    {{ html()->form()->close() }}
@stop

