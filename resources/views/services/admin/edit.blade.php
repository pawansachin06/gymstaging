@extends('layouts.app')

@section('content')
    <h3 class="page-title">Edit Service</h3>
    <div class="panel panel-default">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
            <form action="{{ route('admin.services.update', $item) }}" data-js="form" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-xs-6 form-group">
                        <label class="control-label">Name</label>
                        <input type="text" name="name" value="{{ $item->name }}" required class="form-control" />
                    </div>
                    <div class="col-xs-6 form-group">
                        <label class="control-label">Variant</label>
                        <select name="variant" required class="form-control">
                            <option value="">Select</option>
                            @foreach($variants as $variantValue => $variantLabel)
                                <option value="{{ $variantValue }}" @selected($variantValue == $item->variant?->value)>
                                    {{ $variantLabel }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!--<div class="col-xs-6 form-group">-->
                    <!--    <label class="control-label">Label</label>-->
                    <!--    <input type="text" name="label" value="{{ $item->label }}" required class="form-control" />-->
                    <!--</div>-->
                    <div class="col-xs-6 form-group">
                        <label class="control-label">Slug</label>
                        <input type="text" name="slug" value="{{ $item->slug }}" required class="form-control" />
                    </div>
                    <!--<div class="col-xs-6 form-group">-->
                    <!--    <label class="control-label">Parent</label>-->
                    <!--    <select name="parent_id" class="form-control">-->
                    <!--        <option value="">No parent</option>-->
                    <!--    </select>-->
                    <!--</div>-->
                    <div class="col-xs-6 form-group">
                        <label class="control-label">Type</label>
                        <select name="type" class="form-control">
                            <option value="">Select</option>
                            <option value="professional" @selected('professional' == $item->type)>Professional</option>
                            <option value="organization" @selected('organization' == $item->type)>Organization</option>
                        </select>
                    </div>
                    <div class="col-xs-6 form-group">
                        <div style="display:flex;gap:8px;">
                            <div style="flex-grow:1;">
                                <label class="control-label">Image</label>
                                <input type="file" name="image_file" class="" />
                            </div>
                            <div>
                                <img src="{{ $item->image_url }}" width="48px" height="48px" />
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 form-group">
                        <div style="display:flex;gap:8px;">
                            <div style="flex-grow:1;">
                                <label class="control-label">Icon</label>
                                <input type="file" name="icon_file" class="" />
                            </div>
                            <div>
                                <img src="{{ $item->icon_url }}" width="48px" height="48px" />
                            </div>
                        </div>
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