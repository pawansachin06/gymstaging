@extends('layouts.app')

@section('content')
<a href="{{ route('admin.faq.index') }}" style = "float:right" class="btn btn-default">Back To Faqs</a>
    <h3 class="page-title">@lang('quickadmin.faqs.title')</h3>
    {{ html()->model($faq)->form('PUT', route('admin.faq.update', $faq->id))->acceptsFiles()->attribute('autocomplete', 'off')->open() }}
    <div class="panel panel-default">
        @include('admin.faqs.partial.form')
    </div>
    {{ html()->form()->close() }}
@stop

