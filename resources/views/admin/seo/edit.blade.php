@extends('layouts.app')

@section('content')
<a href="{{ route('admin.seo.index') }}" class="btn btn-default" style= "float:right">Back to SEO</a>

    <h3 class="page-title">@lang('quickadmin.seo.title')</h3>
    
    {{ html()->model($seo_list)->form('PUT', route('admin.seo.update', $seo_list->id))->acceptsFiles()->open() }}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {{ html()->label(trans('quickadmin.seo.fields.page_url'), 'page_url')->class('control-label') }}
                    {{ html()->text('page_url')->class('form-control')->placeholder('') }}
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
                    {{ html()->label(trans('quickadmin.seo.fields.meta_title'), 'meta_title')->class('control-label') }}
                    {{ html()->text('meta_title', old('meta_title') ? old('meta_title') : $seo_list->title)->class('form-control')->placeholder('') }}
                    <p class="help-block"></p>
                    @if($errors->has('meta_title'))
                        <p class="help-block">
                            {{ $errors->first('meta_title') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-12 form-group">
                    {{ html()->label(trans('quickadmin.seo.fields.meta_keyword'), 'meta_keyword')->class('control-label') }}
                    {{ html()->textarea('meta_keyword', old('meta_keyword') ? old('meta_keyword') : $seo_list->keywords)->class('form-control')->placeholder('') }}
                    <p class="help-block"></p>
                    @if($errors->has('meta_keyword'))
                        <p class="help-block">
                            {{ $errors->first('meta_keyword') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-12 form-group">
                    {{ html()->label(trans('quickadmin.seo.fields.meta_description'), 'meta_description')->class('control-label') }}
                    {{ html()->textarea(old('meta_description') ? old('meta_description') : $seo_list->description)->class('form-control')->placeholder('') }}
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

    {{ html()->submit(trans('quickadmin.qa_update'))->class('btn btn-danger') }}
    {{ html()->form()->close() }}
@stop

