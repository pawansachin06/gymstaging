@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.roles.title')</h3>
    
    {{ html()->model($role)->form('PUT', route('admin.roles.update', $role->id))->open() }}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {{ html()->label(trans('quickadmin.roles.fields.title') . '*', 'title')->class('control-label') }}
                    {{ html()->text('title')->class('form-control')->placeholder('')->required() }}
                    <p class="help-block"></p>
                    @if($errors->has('title'))
                        <p class="help-block">
                            {{ $errors->first('title') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {{ html()->submit(trans('quickadmin.qa_update'))->class('btn btn-danger') }}
    {{ html()->form()->close() }}
@stop

