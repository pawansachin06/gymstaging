@extends('layouts.mainTable',['bodyClass'=>'home-screen'])
@section('content')
    <section class="body-cont">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 col-xl-12 mx-auto">
                    @include('partials.heading',['title'=>'Join','subtitle'=>'Fill out your information to get started.'])
                    <form method="POST" action="{{ route('store.personal.user') }}" enctype="multipart/form-data" id="step-form">
                        {{ csrf_field() }}
                        <h3>
                            <span class="title">Join</span>
                            <span class="subtitle">Fill out your information to get started.</span>
                        </h3>
                        <fieldset class="pb-5">
                            <div class="col-12 col-md-12 col-lg-6 col-xl-6 mx-auto">
                                <p>
                                    {{ html()->text('name', old('name'))->class('form-control')->placeholder('Name')->attribute('blur-validate') }}
                                    <span data-validate-field="name" class="text-danger">{{ $errors->first('name') }}</span>
                                </p>
                                <p>
                                    {{ html()->email('email', old('email'))->class('form-control')->placeholder('Email')->attribute('blur-validate') }}
                                    <span data-validate-field="email" class="text-danger">{{ $errors->first('email') }}</span>
                                </p>
                                <p>
                                    {{ html()->password('password')->class('form-control')->placeholder('Password')->attribute('blur-validate') }}
                                    <span data-validate-field="password" class="text-danger">{{ $errors->first('password') }}</span>
                                </p>
                                <p>
                                    {{ html()->password('password_confirmation')->class('form-control')->placeholder('Confirm Password')->attribute('blur-validate') }}
                                    <span data-validate-field="password_confirmation" class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                </p>
                                <p>
                                    {{ html()->checkbox('terms_and_conditions', false, 'TC') }}
                                    <span class="tc_text"> I have read the <a href="{{ route('cms','terms_conditions') }}">Terms and Conditions</a> and <a href="{{ route('cms','privacy_policy') }}">Privacy Policy</a> I am happy to proceed.</span>
                                    <br>
                                    <span data-validate-field="terms_and_conditions" class="text-danger">{{ $errors->first('terms_and_conditions') }}</span>
                                </p>
                                {{-- <p>                              
                                    @if(env('GOOGLE_RECAPTCHA_KEY'))
                                    <div class="g-recaptcha"
                                         data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}">
                                    </div>
                                    @endif
                                </p> --}}
                                <button type="button" class="btn btn2 btn-block" onclick="$('#step-form').steps('next');">
                                    Next
                                </button>
                            </div>
                        </fieldset>

                        <h3>
                            <span class="title">Profile Photo</span>
                            <span class="subtitle">Upload a photo to your profile.</span>
                        </h3>
                        <fieldset class="pb-5">
                            <div class="col-12 col-md-12 col-lg-6 col-xl-6 mx-auto">
                                <div class="wrapper">
                                    <div class="file-upload" id="upload-holder">
                                        {{ html()->file('avatar') }}
                                        <i class="fas fa-plus"></i>
                                    </div>
                                </div>
                                <button type="button" class="btn btn2 btn-block" onclick="$('#step-form').steps('finish');">Join</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('footer_scripts')
    @include('partials.script-step-wizard')
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <script type="text/javascript">

        var fileTypes = {!! json_encode(\App\Http\Controllers\Traits\FileUploadTrait::$accepted_type) !!};

        function readURL(input) {
            if (input.files && input.files[0]) {
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

        function fileValidate(files, fileTypes) {
            var extension = files.name.split('.').pop().toLowerCase();
            return fileTypes.indexOf(extension) > -1;
        }


        $(document).ready(function () {
            var form = $("#step-form"),
                heading = $('.signup-heading');
            form.steps({
                headerTag: "h3",
                bodyTag: "fieldset",
                transitionEffect: "slideLeft",
                titleTemplate: 'Step #index#',
                enablePagination: false,
                labels: {
                    finish: "Join"
                },
                onStepChanging: function (event, currentIndex, newIndex) {
                   
                    var response = false;
                    $('[data-validate-field]').text('');
                    $.ajax({
                        async: false,
                        url: "{{ route('validate.business.user','personal') }}",
                        method: 'post',
                        data: form.serialize() + "&step=" + currentIndex,
                        success: function (result) {
                            response = true;
                        },
                        error: function (xhr) {
                            var msg = $.parseJSON(xhr.responseText);
                            var errorMessage = "";
                            if(msg.errors) {
                                $.each(msg.errors, function (k, v) {
                                    if(k=='g-recaptcha-response'){
                                        $('.form_errors').html(v); 
                                    }
                                    
                                    $(`[data-validate-field=${k}]`).text(v);

                                });
                            }
                        }
                    });
                    if (response) {
                        elem = $(`#step-form-h-${newIndex}`);
                        heading.find('h2').html(elem.find('.title').html());
                        heading.find('span').html(elem.find('.subtitle').html());
                        return true;
                    }
                    return false;
                },
                onStepChanged: function (event, currentIndex, newIndex) {
                    if (currentIndex < newIndex) {
                        $(`.steps ul li.current`).nextAll().removeClass("done");
                    }
                },
                onFinished: function (event, currentIndex) {
                    form.submit();
                }
            });
            $("[name='avatar']").change(function () {
                readURL(this);
            });

            $("[blur-validate]").on('blur',function() {             
                let _that = $(this),
                    attrName = _that.attr('name'),
                    data = {};
                 
                 if(attrName=='password' || attrName=='password_confirmation' ) {
                     data[`password_confirmation`] = $("input[name='password_confirmation']").val();
                     data[`password`] = $("input[name='password']").val();
                   } else{
                    data[`${attrName}`] = _that.val();
                   }
                 
                $(`[data-validate-field="${attrName}"]`).text('');
                $.post("{{ route('validate.business.user','personal') }}", data).fail(function(result) {
                    if(result.status = 422){
                        var response = result.responseJSON;
                       
                        if(response.errors[attrName]) {
                          var  emailResponse = response.errors[attrName];
                          if(emailResponse && emailResponse.length){
                            $(`[data-validate-field="${attrName}"]`).html(emailResponse[0]);
                          } 
                        }
                    }
                });
            }); 

        });
    </script>
@endpush
