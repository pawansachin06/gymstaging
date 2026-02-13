<div class="form-group row">
    {{ Form::label('value.NAME', 'Name',['class'=>'col-sm-2 col-form-label']) }}
    <div class="col-sm-10">
        {{ Form::text('value[NAME]', old('value.NAME', @$modelval['NAME']), ['class' => 'form-control']) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('value.LOGO', 'Logo',['class'=>'col-sm-2 col-form-label']) }}
    <div class="col-sm-10">
        <div class="slim imagesize350X70" id="myCropper" data-force-size="350,70">
            @if($img = @$modelval['LOGO'])
                <img src="{{ $img }}"/>
                {{ Form::hidden('value[LOGO]', $img) }}
            @endif
            {{ Form::file('value[LOGO]') }}
        </div>
    </div>
</div>
<div class="form-group row">
    {{ Form::label('value.PHONE', 'Phone',['class'=>'col-sm-2 col-form-label']) }}
    <div class="col-sm-10">
        {{ Form::text('value[PHONE]', old('value.PHONE', @$modelval['PHONE']), ['class' => 'form-control']) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('value.ADDRESS', 'Address',['class'=>'col-sm-2 col-form-label']) }}
    <div class="col-sm-10">
        {{ Form::text('value[ADDRESS]', old('value.ADDRESS', @$modelval['ADDRESS']), ['class' => 'form-control']) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('value.HEADER_SCRIPTS', 'Header Scripts',['class'=>'col-sm-2 col-form-label']) }}
    <div class="col-sm-10">
        {{ Form::textarea('value[HEADER_SCRIPTS]', old('value.HEADER_SCRIPTS', @$modelval['HEADER_SCRIPTS']), ['class' => 'form-control']) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('value.VERIFICATION_PRICE', 'Verification Price',['class'=>'col-sm-2 col-form-label']) }}
    <div class="col-sm-10">
        {{ Form::text('value[VERIFICATION_PRICE]', old('value.VERIFICATION_PRICE', @$modelval['VERIFICATION_PRICE']), ['class' => 'form-control']) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('value.VERIFICATION_OFFER_PRICE', 'Verification Offer Price',['class'=>'col-sm-2 col-form-label']) }}
    <div class="col-sm-10">
        {{ Form::text('value[VERIFICATION_OFFER_PRICE]', old('value.VERIFICATION_OFFER_PRICE', @$modelval['VERIFICATION_OFFER_PRICE']), ['class' => 'form-control']) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('value.BOOST_PRICE', 'Boost Price',['class'=>'col-sm-2 col-form-label']) }}
    <div class="col-sm-10">
        {{ Form::text('value[BOOST_PRICE]', old('value.BOOST_PRICE', @$modelval['BOOST_PRICE']), ['class' => 'form-control']) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('value.BOOST_OFFER_PRICE', 'Boost Offer Price',['class'=>'col-sm-2 col-form-label']) }}
    <div class="col-sm-10">
        {{ Form::text('value[BOOST_OFFER_PRICE]', old('value.BOOST_OFFER_PRICE', @$modelval['BOOST_OFFER_PRICE']), ['class' => 'form-control']) }}
    </div>
</div>

