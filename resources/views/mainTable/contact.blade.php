@extends('layouts.mainTable',['bodyClass'=>'home-screen'])
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
@section('content')
@include('sweetalert::alert')
     <section class="innerpage-cont body-cont list-deatils">
        <div class="container mob-hed-radius"> 
                <div class=""> 
                    <div class="contact-cont acc-deatils-cont"> 
                        {{ html()->form('POST', route('contact.sendmail'))->attribute('autocomplete', 'off')->open() }}
                        <div class="login-form-fields contact-mob-pad"> 
                            <div class="row">  

                                <div class="col-12 col-md-12 col-lg-12 mb-3"> <div class="signup-heading">
                                    <h4> Contact</h4>
                                    <p>How can we help you?</p>
                                </div> 
                            </div>
                               
                            <div class="col-12 col-md-12 col-lg-12 mb-3">
                                <div class=" bg-white rounded shadow mt-5 business-join-cont">
                                     <div class="px-4 py-4 show">
                                        <div class="col-12 col-md-12 col-lg-6 col-xl-6  mx-auto business-option">  
                                          
                                           <iframe
  src="https://api.leadconnectorhq.com/widget/form/HHd1CQ1ibGRm0P2IOMsj"
  style="width:100%;height:100%;border:none;border-radius:3px"
  id="inline-HHd1CQ1ibGRm0P2IOMsj" 
  data-layout="{'id':'INLINE'}"
  data-trigger-type="alwaysShow"
  data-trigger-value=""
  data-activation-type="alwaysActivated"
  data-activation-value=""
  data-deactivation-type="neverDeactivate"
  data-deactivation-value=""
  data-form-name="Form 1"
  data-height="567"
  data-layout-iframe-id="inline-HHd1CQ1ibGRm0P2IOMsj"
  data-form-id="HHd1CQ1ibGRm0P2IOMsj"
  title="Form 1"
      >
</iframe>
<script src="https://link.msgsndr.com/js/form_embed.js"></script>
                                          
                                        </div>
                                    </div>
                                </div>
                            </div>
                                
                          

                                
                            </div>
                            
                            </form>
                        </div>
                        {{ html()->form()->close() }}
                    </div>
                </div>
        </div>
   
        </section>
        
@stop
@push('footer_scripts')
<script src='https://www.google.com/recaptcha/api.js'></script>
@endpush

