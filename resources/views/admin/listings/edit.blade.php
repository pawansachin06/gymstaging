@extends('layouts.app')

@section('content')
<a href="{{ route('admin.listings.index') }}" class="btn btn-default"  style= "float:right">Back To Listings</a>
    <h3 class="page-title">@lang('quickadmin.listings.title')</h3>
    
    {{ html()->model($listing)->form('PUT', route('admin.listings.update', $listing->id))->acceptsFiles()->open() }}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {{ html()->label(trans('quickadmin.listings.fields.name'), 'name')->class('control-label') }}
                    {{ html()->text('name')->class('form-control')->placeholder('') }}
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
                    {{ html()->label(trans('quickadmin.listings.fields.businesses'), 'business_id')->class('control-label') }}
                    {{ html()->select('business_id', $businesses)->class('form-control select2') }}
                    <p class="help-block"></p>
                    @if($errors->has('business_id'))
                        <p class="help-block">
                            {{ $errors->first('business_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {{ html()->label(trans('quickadmin.listings.fields.address'), 'address')->class('control-label') }}
                    {{ html()->text('address', $listing->fullAddress)->class('form-control')->placeholder('') }}
                    <p class="help-block"></p>
                    @if($errors->has('address'))
                        <p class="help-block">
                            {{ $errors->first('address') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {{ html()->label(trans('quickadmin.listings.fields.user'), 'user_id')->class('control-label') }}
                    {{ html()->select('user_id', $users)->class('form-control') }}
                    <p class="help-block"></p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {{ html()->label(trans('quickadmin.listings.fields.description'), 'description')->class('control-label') }}
                    {{ html()->textarea('description')->class('form-control') }}
                    <p class="help-block"></p>
                    @if($errors->has('description'))
                        <p class="help-block">
                            {{ $errors->first('description') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    @if ($listing->logo)
                        <a href="{{ $listing->getUrl('logo') }}" target="_blank"><img src="{{ $listing->getUrl('logo') }}"></a>
                    @endif
                    {{ html()->label(trans('quickadmin.listings.fields.logo'), 'logo')->class('control-label') }}
                    {{ html()->hidden('logo') }}
                    {{ html()->file('logo')->class('form-control')->style('margin-top: 4px;') }}
                    {{ html()->hidden('logo_max_size', 5) }}
                    {{ html()->hidden('logo_max_width', 4096) }}
                    {{ html()->hidden('logo_max_height', 4096) }}
                    <p class="help-block"></p>
                    @if($errors->has('logo'))
                        <p class="help-block">
                            {{ $errors->first('logo') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {{ html()->label(trans('quickadmin.listings.fields.meta_title'), 'meta_title')->class('control-label') }}
                    {{ html()->text('meta_title', $listing->title)->class('form-control') }}
                    <p class="help-block"></p>
                    @if($errors->has('meta_title'))
                        <p class="help-block">
                            {{ $errors->first('meta_title') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-12 form-group">
                    {{ html()->label(trans('quickadmin.listings.fields.meta_keyword'), 'meta_keyword')->class('control-label') }}
                    {{ html()->textarea('meta_keyword', $listing->keyword)->class('form-control') }}
                    <p class="help-block"></p>
                    @if($errors->has('meta_keyword'))
                        <p class="help-block">
                            {{ $errors->first('meta_keyword') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-12 form-group">
                    {{ html()->label(trans('quickadmin.listings.fields.meta_description'), 'meta_description')->class('control-label') }}
                    {{ html()->textarea('meta_description', $listing->desscription)->class('form-control') }}
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

