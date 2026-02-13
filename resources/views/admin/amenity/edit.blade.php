@extends('layouts.app')

@section('content')
<a href="{{ route('admin.amenity.index') }}" class="btn btn-default"  style= "float:right">Back To Amenities</a>

    <h3 class="page-title">@lang('quickadmin.amenity.title')</h3>

    {{ html()->model($amenity)->form('PUT', route('admin.amenity.update', $amenity->id))->acceptsFiles()->open() }}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {{ html()->label(trans('quickadmin.amenity.fields.business_name') . '*', 'business_id')->class('control-label') }}
                    {{ html()->select('business_id', $businesses)->class('form-control select2') }}
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
                    {{ html()->label(trans('quickadmin.amenity.fields.name') . '*', 'name')->class('control-label') }}
                    {{ html()->text('name')->class('form-control')->placeholder('')->required() }}
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
                        {{ html()->label(trans('quickadmin.amenity.fields.icon') . '*', 'icon')->class('control-label') }}
                        {{ html()->file('icon')->class('form-control') }}
                        <p class="help-block"></p>
                        @if($errors->has('name'))
                            <p class="help-block">
                                {{ $errors->first('icon') }}
                            </p>
                        @endif
                    </div>
                </div>
            {{ html()->submit(trans('quickadmin.qa_update'))->class('btn btn-danger') }}

        </div>
    </div>

    {{ html()->form()->close() }}
@stop

