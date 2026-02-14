@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.report_abuse.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            Report
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($reports) > 0 ? 'datatable' : '' }}">
                <thead>
                    <tr>
                        <th>@lang('quickadmin.report_abuse.fields.report_message')</th>
                        <th>@lang('quickadmin.report_abuse.fields.review_message')</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($reports) > 0)
                        @foreach ($reports as $report)
                            <tr data-entry-id="{{ $report->id }}">
                                <td>{{ $report->message }}</td>
                                <td>{{ $report->review->message}}</td>
                                <td>
                                @can('listing_delete')
                                    {{ html()->form('DELETE', route('admin.report.delete', [$report->id, 'review']))
                                        ->style('display: inline-block;')
                                        ->attribute('onsubmit', "return confirm('" . trans('quickadmin.qa_are_you_sure') . "');")
                                        ->open() }}
                                        {{ html()->submit('Delete Review')->class('btn btn-xs btn-danger') }}
                                    {{ html()->form()->close() }}

                                    {{ html()->form('DELETE', route('admin.report.delete', [$report->id, 'report']))
                                        ->style('display: inline-block;')
                                        ->attribute('onsubmit', "return confirm('" . trans('quickadmin.qa_are_you_sure') . "');")
                                        ->open() }}
                                        {{ html()->submit('Close Report')->class('btn btn-xs btn-primary') }}
                                    {{ html()->form()->close() }}
                                @endcan
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3">@lang('quickadmin.qa_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop


