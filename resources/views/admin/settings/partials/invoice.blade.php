<div class="form-group row">
    {{ html()->label('Prefix', 'value.PREFIX')->class('col-sm-2 col-form-label') }}
    <div class="col-sm-10">
        {{ html()->text('value[PREFIX]', old('value.PREFIX', $modelval['PREFIX'] ?? ''))->class('form-control') }}
    </div>
</div>
<div class="form-group row">
    {{ html()->label('Number Current Index', 'value.NUMERINDEX')->class('col-sm-2 col-form-label') }}
    <div class="col-sm-10">
        {{ html()->text('value[NUMERINDEX]', old('value.NUMERINDEX', $modelval['NUMERINDEX'] ?? ''))->class('form-control') }}
    </div>
</div>
<div class="form-group row">
    {{ html()->label('Logo', 'value.LOGO')->class('col-sm-2 col-form-label') }}
    <div class="col-sm-10">
        <div class="slim imagesize400X120" id="myCropper" data-force-size="750,200">
            @if($img = @$modelval['LOGO'])
                <img src="{{ $img }}"/>
                {{ html()->hidden('value[LOGO]', $img) }}
            @endif
            {{ html()->file('value[LOGO]') }}
        </div>
    </div>
</div>

<div class="form-group row">
    {{ html()->label('GST Registered?', 'value.GST_REGISTERED')->class('col-sm-2 col-form-label') }}
    <div class="col-sm-10 mt-1">
        <div class="switch">
            <label>
                {{ html()->hidden('value[GST_REGISTERED]', 0) }}
                {{ html()->checkbox('value[GST_REGISTERED]', (bool)($modelval['GST_REGISTERED'] ?? false), 1) }}
                <span class="lever switch-col-blue"></span>
            </label>
        </div>
    </div>
</div>