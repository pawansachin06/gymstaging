<div class="form-group row">
    {{ Form::label('value.STRIPE_KEY', 'Stripe Key',['class'=>'col-sm-2 col-form-label']) }}
    <div class="col-sm-10">
        {{ Form::text('value[STRIPE_KEY]', old('value.STRIPE_KEY', @$modelval['STRIPE_KEY']), ['class' => 'form-control']) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('value.STRIPE_SECRET', 'Stripe Secret',['class'=>'col-sm-2 col-form-label']) }}
    <div class="col-sm-10">
        {{ Form::text('value[STRIPE_SECRET]', old('value.STRIPE_SECRET', @$modelval['STRIPE_SECRET']), ['class' => 'form-control']) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('value.STRIPE_CURRENCY', 'Stripe Currency',['class'=>'col-sm-2 col-form-label']) }}
    <div class="col-sm-10">
        {{ Form::select('value[STRIPE_CURRENCY]', \App\UserSetting::$stripeCurrencies, old('value.STRIPE_CURRENCY', @$modelval['STRIPE_CURRENCY']), ['class' => 'form-control']) }}
    </div>
</div>