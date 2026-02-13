@extends('layouts.app')

@section('content')
<a href="{{ route('admin.partner.index') }}" class="btn btn-default"  style= "float:right">Back To Partners</a>
    <h3 class="page-title">Partner</h3>
    {{ html()->model($partner)->form('PUT', route('admin.partner.update', $partner->id))->acceptsFiles()->attribute('autocomplete', 'off')->open() }}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-6 form-group">
                    {{ html()->label('Name', 'name')->class('control-label') }}
                    {{ html()->text('name')->class('form-control')->placeholder('') }}
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-6 form-group">
                    {{ html()->label('Website Link', 'link')->class('control-label') }}
                    {{ html()->text('link')->class('form-control')->placeholder('') }}
                    <p class="help-block"></p>
                    @if($errors->has('link'))
                        <p class="help-block">
                            {{ $errors->first('link') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 form-group">
                    {{ html()->label('Partner Logo', 'logo')->class('control-label') }}
                    {{ html()->hidden('logo', old('logo')) }}
                    {{ html()->file('logo')->class('form-control')->style('margin-top: 4px;') }}
                    <p><img src="{{{$thumb}}}" width='36'></p>
                    <p class="help-block"></p>
                    @if($errors->has('logo'))
                        <p class="help-block">
                            {{ $errors->first('logo') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-6 form-group">
                    {{ html()->label('About Us', 'about_us')->class('control-label') }}
                    {{ html()->textarea('about_us')->class('form-control')->style('margin-top: 4px;') }}
                    @if($errors->has('about_us'))
                        <p class="help-block">
                            {{ $errors->first('about_us') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>


{{ html()->submit(trans('quickadmin.qa_save'))->class('btn btn-danger') }}
{{ html()->form()->close() }}
@stop