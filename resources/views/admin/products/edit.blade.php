@extends('layouts.app')

@section('content')
   
<a href="{{ route('admin.products.index') }}" class="btn btn-default"  style= "float:right">Back To Product Coupon</a>
    <h3 class="page-title">@lang('quickadmin.products.title')</h3>
    
    {{ html()->model($products)->form('PUT', route('admin.products.update', $products->id))->acceptsFiles()->open() }}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

       <div class="panel-body">
                    <div class="row">
                        <input type="hidden" name="product_id" value="{{$products->id}}">
                        <div class="col-xs-6 form-group">
                            {{ html()->label(trans('quickadmin.products.fields.name') . '*', 'name')->class('control-label') }}
                            {{ html()->text('name')->class('form-control')->placeholder('') }}
                            <p class="help-block"></p>
                            @if($errors->has('name'))
                                <p class="help-block">
                                    {{ $errors->first('name') }}
                                </p>
                            @endif
                        </div>
                        <div class="col-xs-6 form-group">
                            {{ html()->label(trans('quickadmin.products.fields.price') . '*', 'price')->class('control-label') }}
                            {{ html()->text('price')->class('form-control')->placeholder('') }}
                            <p class="help-block"></p>
                            @if($errors->has('price'))
                                <p class="help-block">
                                    {{ $errors->first('price') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                      <div class="col-xs-12 form-group">
                        {{ html()->label(trans('quickadmin.products.fields.product_images') . '*')->class('control-label') }}
                        <input class="form-control" type="file" id="image" name="image[]" multiple>
                        <div id="removeImagesData"></div>
                      </div>
                        
                          @if(!$products->productimages->isEmpty())
                            @foreach($products->productimages as $key => $value)
                            <div class="col-xs-2 form-group" id="removeThisImage">
                                <div class="gallery center">
                                  <a href="{{asset('/storage/images/products/'.$value->image)}}" data-lightbox="mygallery" data-title="{{$value->image}}">
                                    <img src="{{asset('/storage/images/products/'.$value->image)}}">
                                  </a>
                                  <div class="removeImage" id='{{$value->id}}'>
                                      <i class="fa fa-trash"></i>
                                  </div>
                                </div>
                            </div>
                            @endforeach
                          @endif
                      
                    </div>

                    <div class="row">
                      <div class="col-xs-12 form-group">
                        {{ html()->label(trans('quickadmin.products.fields.product_faq') . '*')->class('control-label') }}
                      </div>
                    </div>
                    @if(!$products->productfaqs->isEmpty())
                      @foreach($products->productfaqs as $key => $value)
                      <div class="row">
                          <div id="inputFormRow">
                            <div class="col-xs-5 form-group">
                                <input type="text" name="question[]" class="form-control m-input" autocomplete="off" placeholder="{{trans('quickadmin.products.fields.product_quetion')}}" value="{{$value->question}}">
                            </div>
                            <div class="col-xs-5 form-group">
                                <input type="text" name="answer[]" class="form-control m-input" autocomplete="off" placeholder="{{trans('quickadmin.products.fields.product_answer')}}" value="{{$value->answer}}">
                            </div>
                            <div class="col-xs-2 form-group">
                                 <button id="removeRow" type="button" class="btn btn-danger">Remove</button>
                            </div>
                          </div>
                      </div> 
                      @endforeach
                    @endif
                    <div id="newRow" class="row"></div>
                    <button id="addRow" type="button" class="btn btn-info">Add Row</button>
        
                    <div class="row">
                      <div class="col-xs-12 form-group">
                        
                            {{ html()->label(trans('quickadmin.products.fields.product_description') . '*', 'description')->class('control-label') }}
                            {{ html()->textarea('description')->class('form-control summernote')->rows(1) }}
                            <p class="help-block"></p>
                            @if($errors->has('description'))
                                <p class="help-block">
                                    {{ $errors->first('description') }}
                                </p>
                            @endif
                       </div>
                    </div>
                    
            {{ html()->submit(trans('quickadmin.qa_update'))->class('btn btn-danger') }}
        </div>
    </div>

    {{ html()->form()->close() }}

    
@stop



@push('scripts')
<style type="text/css">
  gallery {
  margin: 100px 250px;
}

.gallery img {
  width: 150px;
  padding: 5px;
  filter: grayscale(100%);
  transition: .5s;
}

.gallery img:hover {
  filter: grayscale(0);
  transform: scale(1.1);
}
</style>
@include('partials.script-summernote')

<script type="text/javascript">
        $(document).ready(function(){
            $('#addRow').on('click', function() {
                var html = '';
                html += '<div id="inputFormRow">';
                html += '<div class="col-xs-5 form-group">';
                html += '<input type="text" name="question[]" class="form-control m-input" autocomplete="off" placeholder="Enter question">';
                html += '</div>';
                html += '<div class="col-xs-5 form-group">';
                html += '<input type="text" name="answer[]" class="form-control m-input" autocomplete="off" placeholder="Enter answer">';
                html += '</div>';
                html += '<div class="col-xs-2 form-group">';
                html += '<button id="removeRow" type="button" class="btn btn-danger">Remove</button>';
                html += '</div>';
                html += '</div>';

                $('#newRow').append(html);
            });

            // remove row
            $(document).on('click', '#removeRow', function () {
                $(this).closest('#inputFormRow').remove();
            });
            $(document).on('click', '.removeImage', function () {
                var ids = $(this).attr('id');
                var removehtml = '<input type="hidden" name="remove_image_ids[]" value="'+ids+'">';
                $('#removeImagesData').append(removehtml);
                $(this).closest('#removeThisImage').remove();
            });
        });
    </script>
@endpush