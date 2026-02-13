@extends('layouts.app')
@section('content')
        <h3 class="page-title">Change password</h3>
            <div class="panel panel-default">
                <div class="panel-body">    
                    {{ html()->form('PATCH', route('admin.settings.change_password'))->open() }}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label>@lang('quickadmin.qa_current_password')</label>
                        {{ html()->password('current_password')->class('form-control')->placeholder('')->required() }}
                        <p class="help-block"></p>
                        @if($errors->has('current_password'))
                            <p class="help-block">
                                {{ $errors->first('current_password') }}
                            </p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>@lang('quickadmin.qa_new_password')</label>
                        {{ html()->password('new_password')->class('form-control')->placeholder('')->required() }}
                        <p class="help-block"></p>
                        @if($errors->has('new_password'))
                            <p class="help-block">
                                {{ $errors->first('new_password') }}
                            </p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>@lang('quickadmin.qa_password_confirm')</label>
                        {{ html()->password('new_password_confirm')->class('form-control')->placeholder('')->required() }}
                        <p class="help-block"></p>
                        @if($errors->has('new_password_confirm'))
                            <p class="help-block">
                                {{ $errors->first('new_password_confirm') }}
                            </p>
                        @endif
                    </div>
                    <p>
                        <button type="submit" class="btn btn-danger">@lang('quickadmin.qa_save')</button>
                    </p>
                    {{ html()->form()->close() }}
                </div>
            </div>

@endsection
