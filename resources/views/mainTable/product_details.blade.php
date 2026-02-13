@extends('layouts.mainTable')
<link href="{{ asset('css/master.css') }}" rel="stylesheet">
@section('content')
    <section class="product_detail_section">
       <div class="container">
          <div class="row">
             <div class="col-md-6 order_two">
                <div class="product_left)description product-detais">
                   <h3 class="product_heading">{{$product_details->name}} </h3>
                   <p class="price_count">£{{$product_details->price}}</p>
                   <p class="product_detail_text">
                      {!! $product_details->description !!}
                   </p>
                   @if(!$product_details->productfaqs->isEmpty())
                     <div id="accordion" class="product_accordion">
                        <h3>Frequently Asked Questions</h3>
                          {{-- <div class="card mb-0">
                            @foreach($product_details->productfaqs as $key => $value)
                               <div class="card-header collapsed" data-toggle="collapse" href="#products_{{$value->id}}">
                                  <a class="card-title">
                                  {{$value->question}}
                                  </a>
                               </div>
                               <div id="products_{{$value->id}}" class="card-body collapse" data-parent="#accordion" >
                                  <p>{{$value->answer}}</p>
                               </div> 
                             @endforeach
                          </div>
                     </div> --}}
                     <div class="custom-accordion faq-video">
                           @if(!$product_details->productfaqs->isEmpty())
                               <ul class="faq_accordion">
                                   @foreach($product_details->productfaqs as $key => $value)
                                       <li>
                                           <a>{{ $value->question }}</a>
                                           <div class="answer">{!! nl2br($value->answer) !!}</div>
                                       </li>
                                   @endforeach
                               </ul>
                           @endif
                       </div>
                   </div>
                   @endif
                </div>
             </div>
             <div class="col-md-6">
                <div class="product_thumnail_slider">
                   <div class = "card-wrapper">
                      <div class="cards">
                         <!-- card left -->
                         @if(!$product_details->productimages->isEmpty())
                             <div class="product-imgs">
                                <div class="img-display">
                                   <div class="img-showcase">
                                    @foreach($product_details->productimages as $key => $value)
                                      <img src="{{asset('/storage/images/products/'.$value->image)}}" alt="{{$value->image}}">
                                    @endforeach
                                   </div>
                                </div>
                                <div class="img-select">
                                  @foreach($product_details->productimages as $key => $value)
                                   <div class="img-item">
                                      <a href="#" data-id="{{$key+1}}">
                                      <img src="{{asset('/storage/images/products/'.$value->image)}}" alt="{{$value->image}}">
                                      </a>
                                   </div>
                                  @endforeach
                                </div>
                             </div>
                         @endif
                         <!-- card right -->
                         <div class="product-content">
                            <div class="purchase-info">
                              <a href="{{ route('product.order_now', ['product_id' => base64_encode($product_details->id)]) }}">
                               <button type="button" class="order_now">
                                  Order now
                               </button>
                              </a>
                            </div>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
       </div>
    </section>
    @push('footer_scripts')
    <script type="text/javascript" src="{{ asset('js/card.js') }}"></script>
    <script>
      $('.faq_accordion a').click(function (j) {
           var dropDown = $(this).closest('li').find('.answer');

           $(this).closest('.faq_accordion').find('.answer').not(dropDown).slideUp();

           if ($(this).hasClass('active')) {
               $(this).removeClass('active');
           } else {
               $(this).closest('.faq_accordion').find('a.active').removeClass('active');
               $(this).addClass('active');
           }

           dropDown.stop(false, true).slideToggle();

           j.preventDefault();
       });
    // Product details page thumnail slide js
         const imgs = document.querySelectorAll('.img-select a');
         const imgBtns = [...imgs];
         let imgId = 1;
         
         imgBtns.forEach((imgItem) => {
             imgItem.addEventListener('click', (event) => {
                 event.preventDefault();
                 imgId = imgItem.dataset.id;
                 slideImage();
             });
         });
         
         function slideImage(){
            @if(!$product_details->productimages->isEmpty())
               @if($product_details->productimages->count() > 0)
                  const displayWidth = document.querySelector('.img-showcase img:first-child').clientWidth;
         
                  document.querySelector('.img-showcase').style.transform = `translateX(${- (imgId - 1) * displayWidth}px)`;
               @endif
            @endif
         }
         
         window.addEventListener('resize', slideImage);
         
          $(document).ready(function () {
                 if ($(window).width() > 560 && $(window).width() < 991) {
                     $('body').addClass('ipad-custom-bp');
                 }
             });
      </script>
    @endpush
