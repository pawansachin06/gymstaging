@extends('layouts.app')

@section('content')
<a href="{{ route('admin.category.index') }}" class="btn btn-default"  style= "float:right">Back To Categories</a>

    <h3 class="page-title">@lang('quickadmin.category.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.category.fields.name')</th>
                            <td field-key='name'>{{ $category->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.category.fields.business_name')</th>
                            <td field-key='business_name'>{{ $category->business->name }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

        </div>
    </div>
@stop
