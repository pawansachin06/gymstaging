@extends('layouts.mainTable')
@section('content')
    <section class="innerpage-cont body-cont list-deatils">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 col-xl-12 mb-5">
                    {{ html()->form('POST', route('user.updateprofile'))->id('account_form')->acceptsFiles()->onsubmit('return validateForm();')->open() }}
                    {{ html()->hidden('type', $type) }}
                   <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="signup-heading about-us-custom">
                        <H2>Account Info</H2>
                         <span>View your GymSelect discount code & update your account info.</span>
                          </div>
                            </div>
                            
                            <div class="bg-white rounded shadow mt-5 business-join-cont"
                            
                         <div class="col-12 col-md-12 col-lg-6 col-xl-5 offset-xl-4">
                                
                                    <p><text style="color:white">.</p>
          <p><center><b>Your GymSelect 20% discount code:<text style="color:#00BFC0"> GSM20</text></center></b></p>
          <p><center><a href="https://gymselectme.com/products"><text style="color:#00BFC0"><b><u>Shop Business</u></b></text></center></a>
          <p><text style="color:white">.</p>
       
          
                                    
            </div>
            
            
            <div class="bg-white rounded shadow mt-5 business-join-cont"
                        <div class="login-form-fields">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-10 col-xl-5 offset-lg-1 offset-xl-4 acc-profile-photo">
                                    {{-- <img src="{{ asset('gymselect\images\user-img.jpg') }}"> <br /> --}}
                                 
                                </div>
                            </div>
                            
                             
                            <div class="col-12 col-md-12 col-lg-6 col-xl-5 offset-xl-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name *</label>
                                    {{ html()->text('name', old('name', $user->name ?? ''))->class('form-control')->placeholder('Name') }}
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email *</label>
                                    {{ html()->email('email', old('email', $user->email ?? ''))->class('form-control')->placeholder('Email') }}
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6 col-xl-5 offset-xl-4">
                                <div class="form-group">
                                    <label for="password">Change password</label>
                                    {{ html()->password('password')->id('password')->class('form-control')->placeholder('New password') }}
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm New Password</label>
                                    {{ html()->password('password_confirmation')->id('password_confirmation')->class('form-control')->placeholder('Confirm New Password') }}
                                    <div class="field_error text-danger"></div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn2 btn-block  border-radius">
                                        Save
                                    </button>
                                    {{-- <button type="submit" class="btn btn2 btn-dark btn-block border-radius">Cancel</button> --}}
                                    <p><text style="color:white">.</p>
                                    <p><text style="color:white">.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    
                    {{ html()->form()->close() }}
                </div>
            </div>
        </div>
    </section>
    <div class="col-12 col-md-12 col-lg-6 col-xl-5 ">
        {{-- <div class="form-group">
                      <label for="exampleInputEmail1">Username *</label>
                      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

                    </div> --}}
        {{-- <div class="form-group">
                      <label for="exampleInputEmail1">Phone Number *</label>
                      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

                    </div> --}}
        {{-- <div class="form-group">
                      <label for="exampleInputEmail1">Street Address *</label>
                      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

                    </div> --}}

        {{-- <div class="form-group">
                      <label for="exampleInputEmail1">City *</label>
                      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

                    </div> --}}


        {{-- <div class="form-group">
                      <label for="exampleInputEmail1">Region *</label>
                      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

                    </div> --}}


        {{-- <div class="form-group">
                      <label for="exampleInputEmail1">Postcode *</label>
                      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

                    </div> --}}
        {{-- <div class="form-group forgot-password">
                      <a href="#"> Forgot Password? </a>
                    </div> --}}
    </div>
    
@endsection
@push('footer_scripts')
    <script>
        var profile_image = "{{ $user->avatar ?? null }}",
            storagePath = "{{asset('/storage/thumb')}}";

        $(document).ready(function () {
            $("[name='avatar']").change(function (e) {
                readURL(this);
            });

            if (profile_image) {
                $('#upload-holder').css({
                    'background-image': 'url(' + storagePath + "/" + profile_image + ')',
                    'background-size': 'cover',
                }).hide().fadeIn(650);
            }

            $('#password_confirmation').on('blur', function () {
                validateForm();
            });
        });

        function validateForm(){
            let $passElem = $('#password'),
                $confirmPassElem = $('#password_confirmation');
            if($passElem.val() != ''){
                $errorElem = $confirmPassElem.closest('.form-group').find('.field_error');
                if($passElem.val() != $confirmPassElem.val()){
                    $errorElem.html('Your confirm password does not match')
                    return false;
                }else{
                    $errorElem.html('');
                }
            }
            return true;
        }

        function fileValidate(files, fileTypes) {
            var extension = files.name.split('.').pop().toLowerCase();
            return fileTypes.indexOf(extension) > -1;
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var fileTypes = ['png', 'jpg', 'jpeg', 'gif'];
                var isSuccess = fileValidate(input.files[0], fileTypes);
                if (isSuccess) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#upload-holder').css({
                            'background-image': 'url(' + e.target.result + ')',
                            'background-size': 'cover',
                        }).hide().fadeIn(650);
                    }
                    reader.readAsDataURL(input.files[0]);
                } else {
                    swal("Wrong file format", "Please upload only png,jpg and gif files", "error");
                }
            }
        }
    </script>
@endpush
