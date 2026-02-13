@extends('layouts.mainTable',['pageTitle'=>"{$type} Login"])
@section('content')
    <section class="body-cont">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-6 col-xl-6 mx-auto">
                    <div class="login-cont">
                        <div class="login-heading text-capitalize">{{ $type }} Login</div>
                        <div class="login-form-fields pad-25">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <strong>@lang('quickadmin.qa_whoops')</strong> @lang('quickadmin.qa_there_were_problems_with_input')
                                    :
                                    <br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form method="POST" action="{{ url('login') }}?v=1">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" name="password"/>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="remember"> @lang('quickadmin.qa_remember_me')
                                    </label>
                                </div>
                                <div class="form-group forgot-password">
                                    <a href="{{ route('auth.password.reset') }}">@lang('quickadmin.qa_forgot_password')</a>
                                </div>
                                <p>
                                    <button type="submit"
                                            class="btn btn2 btn-block">@lang('quickadmin.qa_login')</button>
                                </p>
                                <a href="{{ $joinLink }}" class="btn btn2 btn-block">Join</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <p style="margin-left: 0em;padding: 0 7em 2em 0;border-width: 80px; border-color: white; border-style:solid;"></p>
    </section>
@endsection
