@extends('layouts.app')

@section('content')
<a href="{{ route('admin.verification.index',['show_pending' => '1']) }}" class="btn btn-default"  style= "float:right">Back To verifications</a>

    <h3 class="page-title">@lang('quickadmin.verification.title')</h3>
    
    {!! Form::model($listing, ['method' => 'PUT',  'enctype'=> "multipart/form-data", 'route' => ['admin.verification.update', $listing->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('name', trans('quickadmin.verification.fields.approve').'*', ['class' => 'control-label']) !!}
                    {{ Form::checkbox('verified',1,$listing->verified, array('id'=>'verified')) }}
                </div>
            </div>
            {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
        </div>
    </div>

    {!! Form::close() !!}
@stop

