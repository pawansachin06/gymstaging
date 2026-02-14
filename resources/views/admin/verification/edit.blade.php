@extends('layouts.app')

@section('content')
<a href="{{ route('admin.verification.index',['show_pending' => '1']) }}" class="btn btn-default"  style= "float:right">Back To verifications</a>

    <h3 class="page-title">@lang('quickadmin.verification.title')</h3>

    {{ html()->model($listing)->form('PUT', route('admin.verification.update', $listing->id))->acceptsFiles()->open() }}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {{ html()->label(trans('quickadmin.verification.fields.approve') . '*', 'verified')->class('control-label') }}
                    {{ html()->checkbox('verified')->id('verified')->value(1) }}
                </div>
            </div>
            {{ html()->submit(trans('quickadmin.qa_update'))->class('btn btn-danger') }}
        </div>
    </div>

    {{ html()->form()->close() }}
@stop

