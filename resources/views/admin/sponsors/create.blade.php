@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.sponsors.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.sponsors.store'],'enctype' => 'multipart/form-data']) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>
        
        <div class="panel-body">
                    <!-- sponser first -->
                    <div class="row">
                        <div class="col-xs-12"><h4>@lang('quickadmin.qa_sponsership_one')</h4></div>
                        
                        <div class="col-xs-4 form-group">
                            {!! Form::label('name', trans('quickadmin.sponsors.fields.name').'*', ['class' => 'control-label']) !!}
                            {!! Form::text('name_1', old('name_1'), ['class' => 'form-control', 'placeholder' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('name_1'))
                                <p class="help-block">
                                    {{ $errors->first('name_1') }}
                                </p>
                            @endif
                            {!! Form::hidden('tag_1','sponser-1', ['class' => 'form-control', 'placeholder' => '']) !!}

                        </div>
                        <div class="col-xs-4 form-group">
                            {!! Form::label('image', trans('quickadmin.sponsors.fields.image').'*', ['class' => 'control-label']) !!}
                            
                            <input class="form-control" type="file" id="image" name="image_1">

                        </div>
                        <div class="col-xs-4 form-group">
                            {!! Form::label('link', trans('quickadmin.sponsors.fields.link').'*', ['class' => 'control-label']) !!}
                            {!! Form::text('link_1', old('link_1'), ['class' => 'form-control', 'placeholder' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('link_1'))
                                <p class="help-block">
                                    {{ $errors->first('link_1') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <!-- sponser two -->
                    <div class="row">
                        <div class="col-xs-12"><h4>@lang('quickadmin.qa_sponsership_two')</h4></div>
                        
                        <div class="col-xs-4 form-group">
                            {!! Form::label('name', trans('quickadmin.sponsors.fields.name').'*', ['class' => 'control-label']) !!}
                            {!! Form::text('name_2', old('name_2'), ['class' => 'form-control', 'placeholder' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('name_2'))
                                <p class="help-block">
                                    {{ $errors->first('name_2') }}
                                </p>
                            @endif
                            {!! Form::hidden('tag_2','sponser-2', ['class' => 'form-control', 'placeholder' => '']) !!}
                        </div>
                        <div class="col-xs-4 form-group">
                            {!! Form::label('image', trans('quickadmin.sponsors.fields.image').'*', ['class' => 'control-label']) !!}
                            
                            <input class="form-control" type="file" id="image" name="image_2">

                        </div>
                        <div class="col-xs-4 form-group">
                            {!! Form::label('link', trans('quickadmin.sponsors.fields.link').'*', ['class' => 'control-label']) !!}
                            {!! Form::text('link_2', old('link_2'), ['class' => 'form-control', 'placeholder' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('link_2'))
                                <p class="help-block">
                                    {{ $errors->first('link_2') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <!-- sponser three -->
                    <div class="row">
                        <div class="col-xs-12"><h4>@lang('quickadmin.qa_sponsership_three')</h4></div>
                        
                        <div class="col-xs-4 form-group">
                            {!! Form::label('name', trans('quickadmin.sponsors.fields.name').'*', ['class' => 'control-label']) !!}
                            {!! Form::text('name_3', old('name_3'), ['class' => 'form-control', 'placeholder' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('name_3'))
                                <p class="help-block">
                                    {{ $errors->first('name_3') }}
                                </p>
                            @endif
                            {!! Form::hidden('tag_3','sponser-3', ['class' => 'form-control', 'placeholder' => '']) !!}
                        </div>
                        <div class="col-xs-4 form-group">
                            {!! Form::label('image', trans('quickadmin.sponsors.fields.image').'*', ['class' => 'control-label']) !!}
                            
                            <input class="form-control" type="file" id="image" name="image_3">

                        </div>
                        <div class="col-xs-4 form-group">
                            {!! Form::label('link', trans('quickadmin.sponsors.fields.link').'*', ['class' => 'control-label']) !!}
                            {!! Form::text('link_3', old('link_3'), ['class' => 'form-control', 'placeholder' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('link_3'))
                                <p class="help-block">
                                    {{ $errors->first('link_3') }}
                                </p>
                            @endif
                        </div>
                    </div>
            {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
        </div>
    </div>

   
    {!! Form::close() !!}
@stop

@push('scripts')
    @include('partials.script-summernote')
   
@endpush