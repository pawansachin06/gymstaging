@extends('layouts.app')

@section('content')
<a href="{{ route('admin.amenity.index') }}" class="btn btn-default"  style= "float:right">Back to Amenity</a>

    <h3 class="page-title">@lang('quickadmin.amenity.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.amenity.fields.name')</th>
                            <td field-key='name'>{{ $amenity->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.amenity.fields.business_name')</th>
                            <td field-key='business_name'>{{ $amenity->business->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.amenity.fields.icon')</th>
                           
                            <td field-key='icon'><img src="{{ '/storage/amenity_icons/'. $amenity->icon }}" alt=" " width="50px" height="70"></td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

        </div>
    </div>
@stop
