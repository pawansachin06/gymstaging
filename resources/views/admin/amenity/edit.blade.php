@extends('layouts.app')

@section('content')
<a href="{{ route('admin.amenity.index') }}" class="btn btn-default"  style= "float:right">Back To Amenities</a>

    <h3 class="page-title">@lang('quickadmin.amenity.title')</h3>
    
    {!! Form::model($amenity, ['method' => 'PUT',  'enctype'=> "multipart/form-data", 'route' => ['admin.amenity.update', $amenity->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('business_name', trans('quickadmin.amenity.fields.business_name').'*', ['class' => 'control-label']) !!}
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
                    {!! Form::label('name', trans('quickadmin.amenity.fields.name').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                    <div class="col-xs-12 form-group">
                        {!! Form::label('icon', trans('quickadmin.amenity.fields.icon').'*', ['class' => 'control-label']) !!}
                        {!! Form::file('icon',  ['class' => 'form-control']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('name'))
                            <p class="help-block">
                                {{ $errors->first('icon') }}
                            </p>
                        @endif
                    </div>
                </div>
            {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}

        </div>
    </div>

    {!! Form::close() !!}
@stop

