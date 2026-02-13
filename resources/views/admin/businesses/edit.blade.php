@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.businesses.title')</h3>
    
    {{ html()->model($business)->form('PUT', route('admin.businesses.update', $business->id))->open() }}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {{ html()->label(trans('quickadmin.businesses.fields.name'), 'name')->class('control-label') }}
                    {{ html()->text('name')->class('form-control')->placeholder('') }}
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
                    {{ html()->label(trans('Icon'), 'icon')->class('control-label') }}
                    {{ html()->text('icon')->class('form-control')->placeholder('') }}
                    <p class="help-block"></p>
                    @if($errors->has('icon'))
                        <p class="help-block">
                            {{ $errors->first('icon') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {{ html()->submit(trans('quickadmin.qa_update'))->class('btn btn-danger') }}
    {{ html()->form()->close() }}
@stop

