@extends('layouts.app')

@section('content')
    <a href="{{ route('admin.verification.index',['show_pending' => '1']) }}" class="btn btn-default" style="float:right">Back to Verification</a>

    <h3 class="page-title">@lang('quickadmin.verification.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.verification.fields.business_name')</th>
                            <td field-key='business_name'>{{ $listing->user->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.verification.fields.listing_name')</th>
                            <td field-key='listing_name'>{{ $listing->name }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h4>Verification Submits</h4>
                    <div class="list-group">
                        @foreach($listing->verifications as $verification)
                            <div class="list-group-item">
                                <h4 class="list-group-item-heading"><span class="badge pull-right">{{ $verification->statusInfo }}</span>Submitted
                                    on {{ $verification->created_at }}</h4>
                                @foreach($verification->files as $file)
                                    <div class="list-group-item">
                                        {{ basename($file->file_path) }}
                                        <a class="btn btn-xs btn-primary pull-right" target="_blank" href="{{ $file->getUrl('file_path') }}">Download</a>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    @if(!$listing->verified)
                        @can('verification_edit')
                            <a href="{{ route('admin.verification.verifying',[$listing->id, \App\Models\Verification::APPROVED]) }}"
                               class="btn btn-info">@lang('quickadmin.verification.fields.approve')</a>
                            &nbsp;&nbsp;
                            <a href="{{ route('admin.verification.verifying',[$listing->id, \App\Models\Verification::REJECTED]) }}" class="btn btn-danger">Reject</a>
                        @endcan
                    @endif
                    &nbsp;&nbsp;
                    <a href="{{ route('admin.verification.index') }}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@stop
