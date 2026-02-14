@extends('layouts.app')

@section('content')
<a href="{{ route('admin.users.index') }}" class="btn btn-default" style= "float:right">Back to All Users</a>
    <h3 class="page-title">@lang('quickadmin.users.title')</h3>
    
    {{ html()->model($user)->form('PUT', route('admin.users.update', $user->id))->open() }}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {{ html()->label(trans('quickadmin.users.fields.name') . '*', 'name')->class('control-label') }}
                    {{ html()->text('name', old('name'))->class('form-control')->placeholder('')->required() }}
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
                    {{ html()->label(trans('quickadmin.users.fields.email') . '*', 'email')->class('control-label') }}
                    {{ html()->email('email', old('email'))->class('form-control')->placeholder('')->required() }}
                    <p class="help-block"></p>
                    @if($errors->has('email'))
                        <p class="help-block">
                            {{ $errors->first('email') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {{ html()->label(trans('quickadmin.users.fields.password'), 'password')->class('control-label') }}
                    {{ html()->password('password')->class('form-control')->placeholder('') }}
                    <p class="help-block"></p>
                    @if($errors->has('password'))
                        <p class="help-block">
                            {{ $errors->first('password') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {{ html()->label(trans('quickadmin.users.fields.role') . '*', 'role_id')->class('control-label') }}
                    {{ html()->select('role_id', $roles, old('role_id'))->class('form-control select2')->required() }}
                    <p class="help-block"></p>
                    @if($errors->has('role_id'))
                        <p class="help-block">
                            {{ $errors->first('role_id') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {{ html()->submit(trans('quickadmin.qa_update'))->class('btn btn-danger') }}
    {{ html()->form()->close() }}
@stop

