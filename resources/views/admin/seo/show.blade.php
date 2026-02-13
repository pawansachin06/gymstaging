@extends('layouts.app')

@section('content')

<a href="{{ route('admin.seo.index') }}" class="btn btn-default" style= "float:right">Back to SEO</a>

    <h3 class="page-title">@lang('quickadmin.seo.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.seo.fields.page_url')</th>
                            <td field-key='name'>{{ $seo_list->page_url }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.seo.fields.meta_title')</th>
                            <td field-key='city'>{{ $seo_list->title }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.seo.fields.meta_description')</th>
                            <td field-key='address'>{{ $seo_list->description }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.seo.fields.meta_keyword')</th>
                            <td field-key='description'>{!! $seo_list->keywords !!}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

        </div>
    </div>
@stop
