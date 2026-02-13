<div class="col-12 col-md-12 col-lg-6 col-xl-6 mx-auto">
    <p>
        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => @$placeholder['user.name'],'blur-validate']) !!}
        <span data-validate-field="name" class="text-danger">{{ $errors->first('name') }}</span>
    </p>
    <p>
        {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Email','blur-validate']) !!}
        <span data-validate-field="email" class="text-danger">{{ $errors->first('email') }}</span>
    </p>
    <p>
        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password','blur-validate']) !!}
        <span data-validate-field="password" class="text-danger">{{ $errors->first('password') }}</span>
    </p>
    <p>
        {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password','blur-validate']) !!}
        <span data-validate-field="password_confirmation" class="text-danger">{{ $errors->first('password_confirmation') }}</span>
    </p>
    <p>
        {!! Form::checkbox('terms_and_conditions','TC','',['selected' => 'false']) !!}
        <span class="tc_text"> I have read the <a href="{{ route('cms','terms_conditions') }}">Terms and Conditions</a> and <a href="{{ route('cms','privacy_policy') }}">Privacy Policy</a> I am happy to proceed.</span>
        <span data-validate-field="terms_and_conditions" class="text-danger">{{ $errors->first('terms_and_conditions') }}</span>
    </p>
    <p>
        @if(env('ENABLE_SIGNUP_RECAPTCHA', 0))
            <div class="g-recaptcha"
                data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}">
            </div>
        @endif
    </p>
    <span class="form_errors"> </span>
    <button type="button" class="btn btn2 btn-block" onclick="$('#step-form').steps('next');">
        Next
    </button>
</div>
