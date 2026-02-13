<div class="form-group row">
    {{ Form::label('value.PREFIX', 'Prefix',['class'=>'col-sm-2 col-form-label']) }}
    <div class="col-sm-10">
        {{ Form::text('value[PREFIX]', old('value.PREFIX', @$modelval['PREFIX']), ['class' => 'form-control']) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('value.NUMERINDEX', 'Number Current Index',['class'=>'col-sm-2 col-form-label']) }}
    <div class="col-sm-10">
        {{ Form::text('value[NUMERINDEX]', old('value.NUMERINDEX', @$modelval['NUMERINDEX']), ['class' => 'form-control']) }}
    </div>
</div>
<div class="form-group row">
    {{ Form::label('value.LOGO', 'Logo',['class'=>'col-sm-2 col-form-label']) }}
    <div class="col-sm-10">
        <div class="slim imagesize400X120" id="myCropper" data-force-size="750,200">
            @if($img = @$modelval['LOGO'])
                <img src="{{ $img }}"/>
                {{ Form::hidden('value[LOGO]', $img) }}
            @endif
            {{ Form::file('value[LOGO]') }}
        </div>
    </div>
</div>

<div class="form-group row">
    {{ Form::label('value.GST_REGISTERED', 'GST Registered?',['class'=>'col-sm-2 col-form-label']) }}
    <div class="col-sm-10 mt-1">
        <div class="switch">
            <label>
                {{ Form::hidden('value[GST_REGISTERED]', 0) }}
                {{ Form::checkbox('value[GST_REGISTERED]', 1,  @$modelval['GST_REGISTERED']) }}<span class="lever switch-col-blue"></span>
            </label>
        </div>
    </div>
</div>