@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')

    <h3 class="page-title">@lang('quickadmin.boosts.title')</h3>

    <ul class="list-inline">
        <li><a href="{{ route('admin.boost.index') }}?show_pending=1"
               style="{{ (request('show_deleted') == 1 || request('show_boosted') == 1)? '' : 'font-weight: 700' }}">@lang('quickadmin.qa_pending')</a></li>
        |
        <li><a href="{{ route('admin.boost.index') }}?show_boosted=1"
               style="{{ (request('show_deleted') == 1 || request('show_pending') == 1)? '' : 'font-weight: 700' }}">@lang('quickadmin.qa_completed')</a></li>
    </ul>

    <div class="panel panel-default">
        <div class="panel-heading">
            Requests
        </div>

        <div class="panel-body">
            @if ($listings->count() > 0)
                <div class="list-group">
                    @foreach ($listings as $listing)
                        @php
                            $boost = $listing->boosts()->latest()->first();
                        @endphp
                        @if($boost)
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h4 class="mb-1">
                                    Business Name: {{ $listing->name }}
                                    @if($boost->status != 1)
                                        <a href="{{ route('admin.boost.verifying',[$listing->id, \App\Models\Boost::APPROVED]) }}" class="btn btn-success pull-right">Done</a>
                                    @endif
                                </h4>
                            </div>
                            <p class="mb-1"><b>Reviews to be copied from</b></p>
                            @foreach($boost->brand as $brand)
                                <img src="{{ asset(\App\Models\Boost::$brandImg[$brand]) }}" width="24" style="margin-right: 1rem; "/>
                            @endforeach
                        </div>
                        @else
                        @endif
                    @endforeach
                </div>
            @else
                <p>
                    No review boost requests found!
                </p>
            @endif
        </div>
    </div>
@stop
