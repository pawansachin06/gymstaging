@extends('layouts.app')

@section('content')
<a href="{{ route('admin.seo.index') }}" class="btn btn-default" style= "float:right">Back to SEO</a>

    <h3 class="page-title">@lang('quickadmin.seo.title')</h3>
    
    {!! Form::model($seo_list, ['method' => 'PUT', 'route' => ['admin.seo.update', $seo_list->id], 'files' => true,]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('page_url', trans('quickadmin.seo.fields.page_url').'', ['class' => 'control-label']) !!}
                    {!! Form::text('page_url', old('page_url') ? old('page_url') : $seo_list->page_url, ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('page_url'))
                        <p class="help-block">
                            {{ $errors->first('page_url') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('meta_title', trans('quickadmin.seo.fields.meta_title').'', ['class' => 'control-label']) !!}
                    {!! Form::text('meta_title', old('meta_title') ? old('meta_title') : $seo_list->title, ['class' => 'form-control ', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('meta_title'))
                        <p class="help-block">
                            {{ $errors->first('meta_title') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-12 form-group">
                    {!! Form::label('meta_keyword', trans('quickadmin.seo.fields.meta_keyword').'', ['class' => 'control-label']) !!}
                    {!! Form::textarea('meta_keyword', old('meta_keyword') ? old('meta_keyword') : $seo_list->keywords, ['class' => 'form-control ', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('meta_keyword'))
                        <p class="help-block">
                            {{ $errors->first('meta_keyword') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-12 form-group">
                    {!! Form::label('meta_description', trans('quickadmin.seo.fields.meta_description').'', ['class' => 'control-label']) !!}
                    {!! Form::textarea('meta_description', old('meta_description') ? old('meta_description') : $seo_list->description, ['class' => 'form-control ', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('meta_description'))
                        <p class="help-block">
                            {{ $errors->first('meta_description') }}
                        </p>
                    @endif
                </div>

            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

