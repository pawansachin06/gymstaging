@extends('layouts.mainTable')
@section('content')
    <section class="body-cont">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-6 col-xl-6 mx-auto">
                    <div class="login-cont">
                        <div class="login-heading text-capitalize">@lang('quickadmin.qa_reset_password')</div>
                        <div class="login-form-fields pad-25">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    @lang('quickadmin.qa_reset_password_woops')
                                    <br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            {{ html()->form('POST', route('auth.password.reset'))->open() }}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group">
                                <label>@lang('quickadmin.qa_email')</label>
                                {{ html()->email('email')->class('form-control')->placeholder(trans('quickadmin.qa_email'))->required() }}
                            </div>
                            <div class="form-group">
                                <label>@lang('quickadmin.qa_password')</label>
                                {{ html()->password('password')->class('form-control')->placeholder('')->required() }}
                            </div>
                            <div class="form-group">
                                <label>@lang('quickadmin.qa_confirm_password')</label>
                                {{ html()->password('password_confirmation')->class('form-control')->placeholder('')->required() }}
                            </div>
                            <p>
                                <button type="submit"
                                        class="btn btn-block btn1">@lang('quickadmin.qa_reset_password')</button>
                            </p>
                            {{ html()->form()->close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
