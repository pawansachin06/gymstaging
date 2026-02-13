@extends('layouts.app')

@section('content')
<a href="{{ route('admin.partner.index') }}" class="btn btn-default"  style= "float:right">Back To Partners</a>
    <h3 class="page-title">Partner</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.partner.store'], 'files' => true, 'autocomplete' => 'off']) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('name','Name', ['class' => 'control-label']) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-6 form-group">
                    {!! Form::label('link','Website Link', ['class' => 'control-label']) !!}
                    {!! Form::text('link', old('link'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('link'))
                        <p class="help-block">
                            {{ $errors->first('link') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('logo','Partner Logo', ['class' => 'control-label']) !!}
                    {!! Form::hidden('logo', old('logo')) !!}
                    {!! Form::file('logo', ['class' => 'form-control', 'style' => 'margin-top: 4px;']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('logo'))
                        <p class="help-block">
                            {{ $errors->first('logo') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-6 form-group">
                    {!! Form::label('about_us','About Us', ['class' => 'control-label']) !!}
                    {!! Form::textarea('about_us', old('about_us'), ['class' => 'form-control', 'style' => 'margin-top: 4px;']) !!}
                    @if($errors->has('about_us'))
                        <p class="help-block">
                            {{ $errors->first('about_us') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>


{!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
{!! Form::close() !!}
@stop