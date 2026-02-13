@extends('layouts.app')

@section('content')

<a href="{{ route('admin.partner.index') }}" class="btn btn-default" style= "float:right">Back to Partner</a>

    <h3 class="page-title">Partner</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Partner Name</th>
                            <td field-key='Name'>{{ $partner->name }}</td>
                        </tr>
                        <tr>
                            <th>Website Link</th>
                            <td field-key='Link'><a href="{{ $partner->link }}">{{ $partner->link }}</a></td>
                        </tr>
                        <tr>
                            <th>Partner Logo</th>
                            <td field-key='logo'><img src="{{{$thumb}}}" width='36'></td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

        </div>
    </div>
@stop
