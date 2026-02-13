@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.cities.title')</h3>
    {{ html()->form('POST', route('admin.cities.store'))->open() }}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {{ html()->label(trans('quickadmin.cities.fields.name'), 'name')->class('control-label') }}
                    {{ html()->text('name', old('name'))->class('form-control')->placeholder('') }}
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {{ html()->submit(trans('quickadmin.qa_save'))->class('btn btn-danger') }}
    {{ html()->form()->close() }}
@stop

