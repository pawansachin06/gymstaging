@extends('layouts.mainTable')
<link href="{{ asset('css/master.css') }}" rel="stylesheet">
@section('content')
    <section class="innerpage-cont body-cont list-deatils">
       <div class="container">
          <div class="row">
             <div class="col-md-12">
                <div class="signup-heading about-us-custom">
                   <h2>Shop Business </h2>
                   <span>Boost your brand & business with our range of products & services. </span>
                  
                </div>
             </div>
             
            <div class="container">
          <p><center><text style="color:#00BFC0">20% Member Discount on all products & services</text></center></p>
            
             </div>
            
       
              
             @if(!$products->isEmpty())
                @foreach($products as $key => $value)

                  @php
                    $proimage = '';
                    $proimage = (isset($value->productimages[0])) ? $value->productimages[0]->image : 'default-product-image.png';
                  @endphp
                   
                    <div class="col-md-4">
                      <div class="product_card_inner">
                          <figure><a href="{{ route('product.details', ['product_id' => base64_encode($value->id)]) }}"><img src="{{asset('/storage/images/products/'.$proimage)}}" alt="{{$value->name}}"></a></figure>
                         <h3 class="product_heading">{{$value->name}} </h3>
                         <p class="price_count">£{{$value->price}}</p>
                       </div>
                    </div>
                @endforeach

            @else
            <div class="col-md-12">
                <div align="center"><h3>No products found..!!</h3></div>
            </div>
            @endif
          </div>
       </div>
       </div>
        <p style="margin-left: 0em;padding: 0 7em 2em 0;border-width: 80px; border-color: white; border-style:solid;"></p>
    </section>
    @push('footer_scripts')
    <script type="text/javascript" src="{{ asset('js/card.js') }}"></script>
    @endpush
