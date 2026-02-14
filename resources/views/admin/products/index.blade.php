@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.products.title')</h3>
    @can('products_create')
    <p>
        <a href="{{ route('admin.products.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
           @lang('quickadmin.products.title')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($products) > 0 ? 'datatable' : '' }} @can('coupon_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                    <tr>
                        @can('products_delete')
                            @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        @endcan

                        <th>@lang('quickadmin.products.fields.name')</th>
                        <th>@lang('quickadmin.products.fields.price')</th>
                        @if( request('show_deleted') == 1 )
                        <th>@lang('quickadmin.products.fields.option')</th>
                        @else
                        <th>@lang('quickadmin.products.fields.option')</th>
                        @endif
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($products) > 0)
                        @foreach ($products as $product)
                            <tr data-entry-id="{{ $product->id }}">
                                @can('products_delete')
                                    @if ( request('show_deleted') != 1 )<td></td>@endif
                                @endcan

                                <td field-key='name'>{{ $product->name }}</td>
                                <td field-key='code'>
                                    <span class="label label-info label-many">£{{ $product->price }}</span>
                                </td>
                               
                                @if( request('show_deleted') == 1 )
                              
                                <td>
                                    @can('products_delete')
                                    {{ html()->form('POST', route('admin.products.restore', $product->id))
                                        ->style('display: inline-block;')
                                        ->attribute('onsubmit', "return confirm('" . trans('quickadmin.qa_are_you_sure') . "');")
                                        ->open() }}
                                        {{ html()->submit(trans('quickadmin.qa_restore'))->class('btn btn-xs btn-success') }}
                                    {{ html()->form()->close() }}
                                @endcan
                                    @can('products_delete')
                                    {{ html()->form('DELETE', route('admin.products.perma_del', $product->id))
                                        ->style('display: inline-block;')
                                        ->attribute('onsubmit', "return confirm('" . trans('quickadmin.qa_are_you_sure') . "');")
                                        ->open() }}
                                        {{ html()->submit(trans('quickadmin.qa_permadel'))->class('btn btn-xs btn-danger') }}
                                    {{ html()->form()->close() }}
                                @endcan
                                </td>
                                @else
                                <td>
                                    @can('products_view')
                                    <a href="{{ route('admin.products.show',[$product->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('products_edit')
                                    <a href="{{ route('admin.products.edit',[$product->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('products_delete')
                                    {{ html()->form('DELETE', route('admin.products.destroy', $product->id))
                                        ->style('display: inline-block;')
                                        ->attribute('onsubmit', "return confirm('" . trans('quickadmin.qa_are_you_sure') . "');")
                                        ->open() }}
                                        {{ html()->submit(trans('quickadmin.qa_delete'))->class('btn btn-xs btn-danger') }}
                                    {{ html()->form()->close() }}
                                    @endcan
                                  
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="11">@lang('quickadmin.qa_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        @can('products_delete')
            @if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('admin.products.mass_destroy') }}'; @endif
        @endcan

    </script>
@endsection
