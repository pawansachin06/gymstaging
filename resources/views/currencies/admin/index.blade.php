@extends('layouts.app')

@section('content')
    <h3 class="page-title">Currencies</h3>
    <form method="post" action="{{ route('admin.currencies.store') }}" data-js="form" style="margin-bottom:1rem;">
        <button data-js="form-btn" type="submit" class="btn btn-sm btn-success">
            <span>Add New</span>
        </button>
    </form>
    <div class="panel panel-default">
        <div class="panel-heading">
            <form action="" style="display:flex;justify-content:space-between;flex-wrap:wrap;align-items:center;gap:4px;">
                <div style="display:flex;align-items:center;gap:8px;">
                    <input type="search" name="q" value="{{ $keyword }}" placeholder="Search currencies..." class="form-control" />
                    <label style="display:inline-flex;align-items:center;gap:4px;">
                        <input type="checkbox" name="trashed" value="1" @checked($trashed) />
                        <span>Trashed</span>
                    </label>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">
                    Search
                </button>
            </form>
        </div>
        <div class="--panel-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Name</th>
                        <th>Rate</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if ($items?->isNotEmpty())
                        @foreach ($items as $index => $item)
                            <tr>
                                <td>{{ ($page - 1) * $limit + ($index + 1) }}</td>
                                <td>
                                    <a href="{{ route('admin.currencies.edit', $item) }}">
                                        {{ $item->name }}
                                        @if($item->default)
                                            &bull; [Default]
                                        @endif
                                    </a>
                                </td>
                                <td>
                                    {{ $item->rate }}
                                </td>
                                <td>
                                    @if ($item->trashed())
                                        <button type="button" data-js="restore-btn" data-route="{{ route('admin.currencies.restore', $item->id) }}" class="btn btn-success btn-sm">
                                            Restore
                                        </button>
                                        <button type="button" data-permanent="1" data-js="delete-btn" data-route="{{ route('admin.currencies.delete', $item->id) }}" data-name="{{ $item->name }}" class="btn btn-danger btn-sm">
                                            Delete
                                        </button>
                                    @else
                                        <button type="button" data-js="delete-btn" data-route="{{ route('admin.currencies.delete', $item->id) }}" data-name="{{ $item->name }}" class="btn btn-danger btn-sm">
                                            Trash
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="100%">
                                No currencies found
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="panel-footer">
            {{ $items->onEachSide(2)->links() }}
        </div>
    </div>
@endsection