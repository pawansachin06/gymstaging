@extends('layouts.app')

@section('content')
<a href="{{ route('admin.category.index') }}" class="btn btn-default"  style= "float:right">Back To Categories</a>
    <h3 class="page-title">@lang('quickadmin.category.title')</h3>
    
    {!! Form::model($category, ['method' => 'PUT', 'route' => ['admin.category.update', $category->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('business_name', trans('quickadmin.category.fields.business_name').'*', ['class' => 'control-label']) !!}
                    {!! Form::select('business_id', $businesses, old('businesses'), ['class' => 'form-control select2']) !!}
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
                    {!! Form::label('name', trans('quickadmin.category.fields.name').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
            </div>
            {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}

        </div>
    </div>

    {!! Form::close() !!}
@stop

