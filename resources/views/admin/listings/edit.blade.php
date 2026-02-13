@extends('layouts.app')

@section('content')
<a href="{{ route('admin.listings.index') }}" class="btn btn-default"  style= "float:right">Back To Listings</a>
    <h3 class="page-title">@lang('quickadmin.listings.title')</h3>
    
    {!! Form::model($listing, ['method' => 'PUT', 'route' => ['admin.listings.update', $listing->id], 'files' => true,]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('name', trans('quickadmin.listings.fields.name').'', ['class' => 'control-label']) !!}
                    {!! Form::text('name', old('name') ? old('name') : $listing->name, ['class' => 'form-control', 'placeholder' => '']) !!}
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
                    {!! Form::label('business_id', trans('quickadmin.listings.fields.businesses').'', ['class' => 'control-label']) !!}
                    {!! Form::select('business_id', $businesses, old('business_id') ? old('business_id') : $listing->business_id, ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('business_id'))
                        <p class="help-block">
                            {{ $errors->first('business_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('address', trans('quickadmin.listings.fields.address').'', ['class' => 'control-label']) !!}
                    {!! Form::text('address', old('address') ? old('address') : $listing->fullAddress, ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('address'))
                        <p class="help-block">
                            {{ $errors->first('address') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('user', trans('quickadmin.listings.fields.user').'', ['class' => 'control-label']) !!}
                    {!! Form::select('user_id', $users, old('user_id') ? old('user_id') : $listing->user_id, ['class' => 'form-control']) !!}
                    <p class="help-block"></p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('description', trans('quickadmin.listings.fields.description').'', ['class' => 'control-label']) !!}
                    {!! Form::textarea('description', old('description'), ['class' => 'form-control ', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('description'))
                        <p class="help-block">
                            {{ $errors->first('description') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    @if ($listing->logo)
                        <a href="{{ $listing->getUrl('logo') }}" target="_blank"><img src="{{ $listing->getUrl('logo') }}"></a>
                    @endif
                    {!! Form::label('logo', trans('quickadmin.listings.fields.logo').'', ['class' => 'control-label']) !!}
                    {!! Form::hidden('logo', old('logo')) !!}
                    {!! Form::file('logo', ['class' => 'form-control', 'style' => 'margin-top: 4px;']) !!}
                    {!! Form::hidden('logo_max_size', 5) !!}
                    {!! Form::hidden('logo_max_width', 4096) !!}
                    {!! Form::hidden('logo_max_height', 4096) !!}
                    <p class="help-block"></p>
                    @if($errors->has('logo'))
                        <p class="help-block">
                            {{ $errors->first('logo') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('meta_title', trans('quickadmin.listings.fields.meta_title').'', ['class' => 'control-label']) !!}
                    {!! Form::text('meta_title', old('meta_title') ? old('meta_title') : $listing->title, ['class' => 'form-control ', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('meta_title'))
                        <p class="help-block">
                            {{ $errors->first('meta_title') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-12 form-group">
                    {!! Form::label('meta_keyword', trans('quickadmin.listings.fields.meta_keyword').'', ['class' => 'control-label']) !!}
                    {!! Form::textarea('meta_keyword', old('meta_keyword') ? old('meta_keyword') : $listing->keyword, ['class' => 'form-control ', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('meta_keyword'))
                        <p class="help-block">
                            {{ $errors->first('meta_keyword') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-12 form-group">
                    {!! Form::label('meta_description', trans('quickadmin.listings.fields.meta_description').'', ['class' => 'control-label']) !!}
                    {!! Form::textarea('meta_description', old('meta_description') ? old('meta_description') : $listing->desscription, ['class' => 'form-control ', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('meta_description'))
                        <p class="help-block">
                            {{ $errors->first('meta_description') }}
                        </p>
                    @endif
                </div>

            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

