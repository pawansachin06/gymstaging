@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.faqs.title')</h3>
    @can('faq_create')
    <p>
        <a href="{{ route('admin.faq.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
        
    </p>
    @endcan


    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_faqs')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($faqs) > 0 ? 'datatable' : '' }}">
                <thead>
                    <tr>

                        <th>@lang('quickadmin.faqs.fields.question')</th>
                        <th>@lang('quickadmin.faqs.fields.answer')</th>
                        <th>@lang('quickadmin.faqs.fields.status')</th>
                        <th>Option</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($faqs) > 0)
                        @foreach ($faqs as $faq)
                            <tr data-entry-id="{{ $faq->id }}">
                                <td field-key='question'>{{ $faq->question }}</td>
                                <td field-key='answer'>{{ $faq->answer }}</td>
                                <td field-key='status'>{{$faq->status }}</td>
                                @can('faq_edit')
                                <td><a href="{{ route('admin.faq.edit',$faq->id) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>&nbsp
                                @endcan
                                @can('faq_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.faq.destroy', $faq->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}</td>
                                    {!! Form::close() !!}
                                @endcan
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="11">@lang('quickadmin.qa_no_entries_in_table')</td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>
@stop
