@extends('layouts.app')

@section('content')
<a href="{{ route('admin.products.index') }}" class="btn btn-default"  style= "float:right">Back To Product Coupon</a>

    <h3 class="page-title">@lang('quickadmin.products.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.products.fields.name')</th>
                            <td field-key='name'>{{ $products->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.products.fields.price')</th>
                            <td field-key='code'><span class="label label-info label-many">£{{ $products->price }}</span></td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.products.fields.product_description')</th>
                            <td field-key='code'>{!! $products->description !!}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.products.fields.product_images')</th>
                        </tr>
                        <tr>
                             
                         @if(!$products->productimages->isEmpty())
                         <td field-key='name'>
                            @foreach($products->productimages as $key => $value)
                                <img src="{{asset('/storage/images/products/'.$value->image)}}" alt = "{{$value->image}}" height="100px" width="100px">
                            @endforeach
                        </td>
                         @else
                           <td field-key='img'> Product images not available..!!</td>
                         @endif
                             
                        </tr>

                    </table>
                </div>

                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th colspan="2">@lang('quickadmin.products.fields.product_faq')</th>
                        </tr>
                         @if(!$products->productfaqs->isEmpty())
                            @foreach($products->productfaqs as $key => $value)
                            <tr>
                                <td field-key='question'>{{$value->question}}</td>
                                <td field-key='answer'>{{$value->answer}}</td>
                             </tr>
                            @endforeach
                         @else
                            <tr>
                                <td field-key='question'>Product faqs not available..!!</td>
                            </tr>
                         @endif
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

        </div>
    </div>
@stop
