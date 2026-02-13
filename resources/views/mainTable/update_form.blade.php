@extends('layouts.mainTable',['bodyClass'=>'home-screen'])
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
@section('content')
@include('sweet::alert')
    <section class="body-cont">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 col-xl-12 mx-auto">
                    <form method="POST" action="{{ route('user.updateprofile') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <h3>
                            <span class="subtitle">Update Your Profile.</span>
                        </h3>
                      
                        <fieldset class="pb-5">
                            <div class="col-12 col-md-12 col-lg-6 col-xl-6 mx-auto">
                                <p>
                                    {!! Form::text('name', old('name' , $user->name), ['class' => 'form-control', 'placeholder' => 'Name' ,'required' => 'true']) !!}
                                </p>
                                <p>
                                    {!! Form::email('email', old('email' ,$user->email), ['class' => 'form-control', 'placeholder' => 'Email' ,'required' => 'true']) !!}
                                </p>
                                <p>
                                    {{ Form::password('password' ,  ['class' => 'form-control', 'placeholder' => 'Password' ]) }}
                                </p>
                                <p>
                                    {!! Form::file('avatar' , ['class' => 'form-control']) !!}
                                </p>               
                                </div>
                                <button type="submit" class="btn btn2" style = "margin-left:auto;margin-right:auto;display:block;margin-top:2%;margin-bottom:0%">
                                    Submit
                                </button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
