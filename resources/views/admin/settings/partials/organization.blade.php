<div class="form-group row">
    {{ html()->label('Name', 'value.NAME')->class('col-sm-2 col-form-label') }}
    <div class="col-sm-10">
        {{ html()->text('value[NAME]', old('value.NAME', $modelval['NAME'] ?? ''))->class('form-control') }}
    </div>
</div>
<div class="form-group row">
    {{ html()->label('Logo', 'value.LOGO')->class('col-sm-2 col-form-label') }}
    <div class="col-sm-10">
        <div class="slim imagesize350X70" id="myCropper" data-force-size="350,70">
            @if($img = @$modelval['LOGO'])
                <img src="{{ $img }}"/>
                {{ html()->hidden('value[LOGO]', $img) }}
            @endif
            {{ html()->file('value[LOGO]') }}
        </div>
    </div>
</div>
<div class="form-group row">
    {{ html()->label('Phone', 'value.PHONE')->class('col-sm-2 col-form-label') }}
    <div class="col-sm-10">
        {{ html()->text('value[PHONE]', old('value.PHONE', $modelval['PHONE'] ?? ''))->class('form-control') }}
    </div>
</div>
<div class="form-group row">
    {{ html()->label('Address', 'value.ADDRESS')->class('col-sm-2 col-form-label') }}
    <div class="col-sm-10">
        {{ html()->text('value[ADDRESS]', old('value.ADDRESS', $modelval['ADDRESS'] ?? ''))->class('form-control') }}
    </div>
</div>
<div class="form-group row">
    {{ html()->label('Header Scripts', 'value.HEADER_SCRIPTS')->class('col-sm-2 col-form-label') }}
    <div class="col-sm-10">
        {{ html()->textarea('value[HEADER_SCRIPTS]', old('value.HEADER_SCRIPTS', $modelval['HEADER_SCRIPTS'] ?? ''))->class('form-control')->rows(3) }}
    </div>
</div>
<div class="form-group row">
    {{ html()->label('Verification Price', 'value.VERIFICATION_PRICE')->class('col-sm-2 col-form-label') }}
    <div class="col-sm-10">
        {{ html()->text('value[VERIFICATION_PRICE]', old('value.VERIFICATION_PRICE', $modelval['VERIFICATION_PRICE'] ?? ''))->class('form-control') }}
    </div>
</div>
<div class="form-group row">
    {{ html()->label('Verification Offer Price', 'value.VERIFICATION_OFFER_PRICE')->class('col-sm-2 col-form-label') }}
    <div class="col-sm-10">
        {{ html()->text('value[VERIFICATION_OFFER_PRICE]', old('value.VERIFICATION_OFFER_PRICE', $modelval['VERIFICATION_OFFER_PRICE'] ?? ''))->class('form-control') }}
    </div>
</div>
<div class="form-group row">
    {{ html()->label('Boost Price', 'value.BOOST_PRICE')->class('col-sm-2 col-form-label') }}
    <div class="col-sm-10">
        {{ html()->text('value[BOOST_PRICE]', old('value.BOOST_PRICE', $modelval['BOOST_PRICE'] ?? ''))->class('form-control') }}
    </div>
</div>
<div class="form-group row">
    {{ html()->label('Boost Offer Price', 'value.BOOST_OFFER_PRICE')->class('col-sm-2 col-form-label') }}
    <div class="col-sm-10">
        {{ html()->text('value[BOOST_OFFER_PRICE]', old('value.BOOST_OFFER_PRICE', $modelval['BOOST_OFFER_PRICE'] ?? ''))->class('form-control') }}
    </div>
</div>

