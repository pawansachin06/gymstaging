
<div class="panel-heading">
    @if(@$faq->id) @lang('quickadmin.qa_edit') @else @lang('quickadmin.qa_create') @endif
</div>

<div class="panel-body">
    <div class="row">
        <div class="col-xs-12 form-group">
            {!! Form::label('Question', trans('quickadmin.faqs.fields.question').'', ['class' => 'control-label']) !!}
            {!! Form::textarea('question', old('question'), ['class' => 'form-control ', 'placeholder' => '', 'rows' => "4"]) !!}
            <p class="help-block"></p>
            @if($errors->has('question'))
                <p class="help-block">
                    {{ $errors->first('question') }}
                </p>
            @endif
        </div>
        <div class="col-xs-12 form-group">
            {!! Form::label('Answer', trans('quickadmin.faqs.fields.answer').'', ['class' => 'control-label']) !!}
            {!! Form::textarea('answer', old('answer'), ['class' => 'form-control ', 'placeholder' => '', 'rows' => "4"]) !!}
            <p class="help-block"></p>
            @if($errors->has('answer'))
                <p class="help-block">
                    {{ $errors->first('answer') }}
                </p>
            @endif
        </div>
        <div class="col-xs-4 form-group">
            {!! Form::label('Status', trans('quickadmin.coupons.fields.status').'', ['class' => 'control-label']) !!}
            <br>
                <label class="switch">
                        <input type="hidden" name="status" value="0">
                        @if(@!$coupon->id)
                        <input type="checkbox" name="status"  value="1" checked ><span class="slider"></span>
                        @else
                        <input type="checkbox" name="status"  value="1" {{@$faq->status == 1 ? 'checked' : ''}} ><span class="slider"></span>
                        @endif
                </label>
            <p class="help-block"></p>
            @if($errors->has('status'))
                <p class="help-block">
                    {{ $errors->first('status') }}
                </p>
            @endif
        </div>
    </div>
    {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
</div>
       
@push('scripts')

<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
@endpush

