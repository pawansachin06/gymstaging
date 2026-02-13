@extends('layouts.mainTable')
<link href="{{ asset('css/master.css') }}" rel="stylesheet">
@section('content')
    <section class="product_detail_section">
         <div class="container">
            <div class="row">
               @php
                $proimage = (isset($product_details->productimages[0])) ? $product_details->productimages[0]->image: 'default-product-image.png';
               @endphp
               <div class="col-md-6">
                  <div class="product_left_description">
                     <figure><img src="{{asset('/storage/images/products/'.$proimage)}}" alt="{{$product_details->name}}"></figure>
                     <h3 class="product_heading "><b>{{$product_details->name}}</b> </h3>
                     <p class="price_count" id="price_count">£{{$product_details->price}}</p>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="product_payment_cards">
                    <form action="{{ route('product.order.create', ['product_id' => $product_details->id]) }}" name="order_form" id="order_form" method="POST">
                     <div class="form-container row">
                        <div class="payment-title col-md-12">
                           <h3>Contact & Billing Information</h3>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="product_id" id="product_id" value="{{$product_details->id}}">
                        <input type="hidden" name="product_name" id="product_name" value="{{$product_details->name}}">
                        <input type="hidden" name="product_price" id="product_price" value="{{$product_details->price}}">
                        <input type="hidden" name="discount_price" id="discount_price" value="{{$product_details->price}}">
                        <input type="hidden" name="is_coupon_applied" id="is_coupon_applied" value="0">
                        <input type="hidden" name="payment_method_id" id="payment_method_id">
                        <div class="field-container col-md-12">
                           <input id="name" name="name" maxlength="20" type="text" placeholder="Name" required value="{{ auth()->user()->name ?? '' }}">
                        </div>
                        <div class="field-container col-md-12">
                           <input id="name" name="email" type="email" placeholder="Email" required value="{{ auth()->user()->email ?? '' }}">
                        </div>
                        <div class="field-container" id="card-element"></div>
                        <div class="field-container col-md-8">
                           <input id="discount_code" name="discount_code" type="text" placeholder="Discount Code">
                        </div>
                        <div class="field-container col-md-4" id="appy_remove_coupon_container">
                          <input id="applynow" type="button" value="Apply">
                        </div>
                        
                        <div class="field-container col-md-12" id="couponErrorSuccess"></div>
                        <div class="field-container col-md-12">
                           <input id="order_now" type="submit" class="order_now" value="Order now">
                        </div>
                     </div>
                   </form>
                  </div>
               </div>
            </div>
         </div>
         </div>
          <p style="margin-left: 0em;padding: 0 7em 2em 0;border-width: 80px; border-color: white; border-style:solid;"></p>
      </section>
    @push('footer_scripts')
    <script type="text/javascript" src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        var stripe = Stripe('{{ config('stripe.key') }}');
        const elementstyle = {
           base: {
                color: '#00a4e2',
                fontSmoothing: 'antialiased',
                '::placeholder': {
                    color: '#999',
                },
            },
            invalid: {
                color: '#e5424d',
                ':focus': {
                    color: '#303238',
                },
            },
        };
        const elements = stripe.elements();
        var cardElement = elements.create('card', {
            style: elementstyle,
            hidePostalCode: true
        });
        cardElement.mount('#card-element');
        async function callStripeApiToStorePaymentMethod()
        {
            const {error, paymentMethod} =  await stripe.createPaymentMethod({
                type:'card',
                card:cardElement
             });
            if (error) {
                swal("Error", error.message, "error");
                return false;
            }
            $('#payment_method_id').val(paymentMethod.id);
            $('#order_form').submit();
        }
         $('#order_now').click(function(event) {
            event.preventDefault();
            callStripeApiToStorePaymentMethod();
         });
      $(document).ready(function () {
         $('body').on('click', '#applynow', function(event) {
             if( $.trim($('#discount_code').val()) == ''){
                // swal('Please enter discount coupon code..');
                $('#couponErrorSuccess').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"> Please enter discount coupon code...<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
             }else{
                let product_id     = $("input[name=product_id]").val();
                let product_price  = $("input[name=product_price]").val();
                let discount_code  = $.trim($("input[name=discount_code]").val());
                let _token         = '{{ csrf_token() }}';

                $.ajax({
                  url: '{{ route("product.applycouponcode") }}',
                  type: 'post',
                   data:{
                    product_id:product_id,
                    product_price:product_price,
                    discount_code:discount_code,
                    _token: _token
                  },
                  dataType: 'json',
                  success:function(data) {
                    if(data.code == '0'){
                      let product_price  = $("input[name=discount_price]").val($('#product_price').val());
                       $('#price_count').text('£'+$('#product_price').val());
                       $('#couponErrorSuccess').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"> Oops..!! '+ data.message +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }else{
                      let product_price  = $("input[name=discount_price]").val(data.discounted_price);
                      $('#price_count').text('£'+data.new_price);
                      if(data.product_price == data.discounted_price){
                        $('#is_coupon_applied').val(1);
                        $('#couponErrorSuccess').html('<div class="alert alert-success alert-dismissible fade show" role="alert"> Congratulations..!! '+ data.message + ' You have got full discount of £' + data.discounted_price +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        $('#appy_remove_coupon_container').html("<input id=removeCoupon type=button value=Remove>");
                      }else{
                        $('#is_coupon_applied').val(1);
                        $('#couponErrorSuccess').html('<div class="alert alert-success alert-dismissible fade show" role="alert"> Congratulations..!! '+ data.message + ' You have got discount of £' + data.discounted_price +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        $('#appy_remove_coupon_container').html("<input id=removeCoupon type=button value=Remove>");
                      }    
                    }
                  },
                  error: function(data) {
                    let product_price  = $("input[name=discount_price]").val($('#product_price').val());
                    $('#price_count').text('£'+$('#product_price').val());
                  }
              });
             }
          });
          $('body').on('click', '#removeCoupon', function(event) {
              event.preventDefault();
              $('#discount_code').val('');
              let product_price  = $("input[name=discount_price]").val($('#product_price').val());
              $('#price_count').text('£'+$('#product_price').val());
              $('#couponErrorSuccess').html('');
              $('#appy_remove_coupon_container').html("<input id=applynow type=button value=Apply>");
          });
      });
       
    </script>
    @endpush
