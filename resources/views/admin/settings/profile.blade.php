@extends('layouts.app')

@section('content')
            <h3 class="page-title">Update Profile</h3>
            {!! Form::open(['method' => 'PATCH', 'enctype'=> "multipart/form-data" ,'route' => ['admin.settings.update_profile']]) !!}
    
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                        <div class="col-xs-12 form-group">
                                {!! Form::label('name','Name' ,  ['class' => 'control-label']) !!}&nbsp;
                                {!! Form::text('name', old('name' , $user->name), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                            </div>
                        </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        {!! Form::label('image', 'Image', ['class' => 'control-label']) !!}
                        {{ Form::file('image' , ['class' => 'form-control']) }}
                    </div>
            </div>
         
            {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger' , 'style' => 'margin-left:auto;margin-right:auto;display:block;margin-top:2%;margin-bottom:0%']) !!}
        </div>    
    </div>
  
  
    {!! Form::close() !!}
@stop


