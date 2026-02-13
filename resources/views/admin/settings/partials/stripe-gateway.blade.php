<div class="form-group row">
    {{ html()->label('Stripe Key', 'value.STRIPE_KEY')->class('col-sm-2 col-form-label') }}
    <div class="col-sm-10">
        {{ html()->text('value[STRIPE_KEY]', old('value.STRIPE_KEY', $modelval['STRIPE_KEY'] ?? ''))->class('form-control') }}
    </div>
</div>
<div class="form-group row">
    {{ html()->label('Stripe Secret', 'value.STRIPE_SECRET')->class('col-sm-2 col-form-label') }}
    <div class="col-sm-10">
        {{ html()->text('value[STRIPE_SECRET]', old('value.STRIPE_SECRET', $modelval['STRIPE_SECRET'] ?? ''))->class('form-control') }}
    </div>
</div>
<div class="form-group row">
    {{ html()->label('Stripe Currency', 'value.STRIPE_CURRENCY')->class('col-sm-2 col-form-label') }}
    <div class="col-sm-10">
        {{ html()->select('value[STRIPE_CURRENCY]', \App\UserSetting::$stripeCurrencies, old('value.STRIPE_CURRENCY', $modelval['STRIPE_CURRENCY'] ?? ''))->class('form-control') }}
    </div>
</div>