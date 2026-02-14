@extends('layouts.mainTable')
@section('content')
    <section class="body-cont">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-6 col-xl-6 mx-auto">
                    <div class="login-cont">
                        <div class="login-heading text-capitalize">@lang('quickadmin.qa_change_password')</div>
                        <div class="login-form-fields pad-25">
                        @if(session('success'))
                            <!-- If password successfully show message -->
                                <div class="row">
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                </div>
                            @else
                                {{ html()->form('PATCH', route('auth.change_password'))->open() }}
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
                                    {{ html()->password('new_password_confirmation')->class('form-control')->placeholder('')->required() }}
                                    <p class="help-block"></p>
                                    @if($errors->has('qa_password_confirm'))
                                        <p class="help-block">
                                            {{ $errors->first('qa_password_confirm') }}
                                        </p>
                                    @endif
                                </div>
                                <p>
                                    <button type="submit" class="btn btn-danger">@lang('quickadmin.qa_save')</button>
                                </p>
                                {{ html()->form()->close() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
