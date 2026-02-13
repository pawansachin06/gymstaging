@extends('layouts.app')

@section('content')
            <h3 class="page-title">Update Profile</h3>
            {{ html()->model($user)->form('PATCH', route('admin.settings.update_profile'))->acceptsFiles()->open() }}
    
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                        <div class="col-xs-12 form-group">
                                {{ html()->label('Name', 'name')->class('control-label') }}
                                {{ html()->text('name')->class('form-control')->placeholder('Name') }}
                            </div>
                        </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                        {{ html()->label('Image', 'image')->class('control-label') }}
                        {{ html()->file('image')->class('form-control') }}
                    </div>
            </div>
         
            {{ html()->submit(trans('quickadmin.qa_save'))->class('btn btn-danger')->style('margin: 2% auto 0; display: block;') }}
        </div>    
    </div>
  
  
    {{ html()->form()->close() }}
@stop


