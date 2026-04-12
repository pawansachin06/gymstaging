@extends('layouts.app')

@section('content')
    <h3 class="page-title">Edit Currency</h3>
    <div class="panel panel-default">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
            <form action="{{ route('admin.currencies.update', $item) }}" data-js="form" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-xs-6 form-group">
                        <label class="control-label">Name</label>
                        <input type="text" name="name" value="{{ $item->name }}" required class="form-control" />
                    </div>
                    <div class="col-xs-6 form-group">
                        <label class="control-label">Code</label>
                        <input type="text" name="code" value="{{ $item->code }}" required class="form-control" />
                    </div>
                    <div class="col-xs-6 form-group">
                        <label class="control-label">Rate</label>
                        <input type="number" name="rate" value="{{ $item->rate }}" step="0.01" required class="form-control" />
                    </div>
                    <div class="col-xs-6 form-group">
                        <label class="control-label">Sequence</label>
                        <input type="number" name="sequence" value="{{ $item->sequence }}" step="1" min="0" required class="form-control" />
                    </div>
                </div>
                <div class="">
                    <div data-js="form-msg" style="padding:6px 12px;"></div>
                    <button data-js="form-btn" type="submit" class="btn btn-success">
                        <span>Update</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection