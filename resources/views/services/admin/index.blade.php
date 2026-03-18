@extends('layouts.app')

@section('content')
    <h3 class="page-title">Services</h3>
    <form method="post" action="{{ route('admin.services.store') }}" data-js="form" style="margin-bottom:1rem;">
        <button data-js="form-btn" type="submit" class="btn btn-sm btn-success">
            <span>Add New</span>
        </button>
    </form>
    <div class="panel panel-default">
        <div class="panel-heading">
            <form action="">
                <input type="search" name="q" value="{{ $keyword }}" placeholder="Search services..." />
            </form>
        </div>
        <div class="--panel-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th style="min-width:150px;">Name</th>
                        <th>Type</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($items?->isNotEmpty())
                        @foreach ($items as $index => $item)
                            <tr>
                                <td>{{ ($page - 1) * $limit + ($index + 1) }}</td>
                                <td>
                                    <a href="{{ route('admin.services.edit', $item) }}">
                                        {{ $item->name }}
                                    </a>
                                </td>
                                <td>{{ $item->type }}</td>
                                <td>
                                    
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="100%">
                                No services found
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection