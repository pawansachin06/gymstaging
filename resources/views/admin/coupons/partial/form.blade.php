
<div class="panel-heading">
    @if(@$coupon->id) @lang('quickadmin.qa_edit') @else @lang('quickadmin.qa_create') @endif
</div>
{{ html()->hidden('coupon_type', @$partner->coupon_type) }}
<div class="panel-body">
    <div class="row">
        <div class="col-xs-4 form-group">
            {{ html()->label(trans('quickadmin.coupons.fields.code'), 'code')->class('control-label') }}
            {{ html()->text('code', old('code'))->class('form-control')->placeholder('') }}
            <p class="help-block"></p>
            @if($errors->has('code'))
                <p class="help-block">
                    {{ $errors->first('code') }}
                </p>
            @endif
        </div>
        <div class="col-xs-4 form-group">
                {{ html()->label(trans('quickadmin.coupons.fields.business'), 'business')->class('control-label') }}
                {{ html()->multiselect('business[]', $businesses, old('business'))->class('form-control select2') }}
                <p class="help-block"></p>
                @if($errors->has('business'))
                    <p class="help-block">
                        {{ $errors->first('business') }}
                    </p>
                @endif
            </div>
            <div class="col-xs-4 form-group">
                {{ html()->label(trans('quickadmin.coupons.fields.status'))->class('control-label') }}
                <br>
                    <label class="switch">
                            <input type="hidden" name="status" value="0">
                            @if(@!$coupon->id)
                            <input type="checkbox" name="status"  value="1" checked ><span class="slider"></span>
                            @else
                            <input type="checkbox" name="status"  value="1" {{@$coupon->status == 1 ? 'checked' : ''}} ><span class="slider"></span>
                            @endif
                    </label>
                <p class="help-block"></p>
                @if($errors->has('status'))
                    <p class="help-block">
                        {{ $errors->first('status') }}
                    </p>
                @endif
            </div>
            @if(@$coupon->coupon_type != "V")
            <div class="col-xs-4 form-group">
                {{ html()->label(trans('quickadmin.coupons.fields.monthly'))->class('control-label') }}
                <br>
                    <label class="switch">
                            <input type="hidden" name="monthly" value="0">
                            @if(@!$coupon->id)
                            <input type="checkbox" name="monthly"  value="1" checked ><span class="slider"></span>
                            @else
                            <input type="checkbox" name="monthly"  value="1" {{@$coupon->monthly == 1 ? 'checked' : ''}} ><span class="slider"></span>
                            @endif
                    </label>
                <p class="help-block"></p>
                @if($errors->has('monthly'))
                    <p class="help-block">
                        {{ $errors->first('monthly') }}
                    </p>
                @endif
            </div>

            <div class="col-xs-4 form-group">
                {{ html()->label(trans('quickadmin.coupons.fields.yearly'))->class('control-label') }}
                <br>
                    <label class="switch">
                            <input type="hidden" name="yearly" value="0">
                            @if(@!$coupon->id)
                            <input type="checkbox" name="yearly"  value="1" checked ><span class="slider"></span>
                            @else
                            <input type="checkbox" name="yearly"  value="1" {{@$coupon->yearly == 1 ? 'checked' : ''}} ><span class="slider"></span>
                            @endif
                    </label>
                <p class="help-block"></p>
                @if($errors->has('yearly'))
                    <p class="help-block">
                        {{ $errors->first('yearly') }}
                    </p>
                @endif
            </div>
            @endif

            <div class="col-xs-4 form-group">
                {{ html()->label(trans('quickadmin.listings.fields.description'), 'description')->class('control-label') }}
                {{ html()->textarea('description', old('description'))->class('form-control')->placeholder('')->rows(4) }}
            </div>
        </div>
        @if(@!$coupon->id)
        <div class="row">
                <div class="col-xs-4 form-group">
                        {{ html()->label(trans('quickadmin.coupons.fields.type'), 'type')->class('control-label') }}
                        {{ html()->select('type', \App\Models\Coupon::$types, old('type'))->class('form-control') }}
                        <p class="help-block"></p>
                        @if($errors->has('type'))
                            <p class="help-block">
                                {{ $errors->first('type') }}
                            </p>
                        @endif
                </div>
                <div class="col-xs-4 form-group">
                        {{ html()->label(trans('quickadmin.coupons.fields.value'), 'value')->class('control-label') }}
                        {{ html()->text('value', old('value'))->class('form-control')->placeholder('') }}
                        <p class="help-block"></p>
                        @if($errors->has('value'))
                            <p class="help-block">
                                {{ $errors->first('value') }}
                            </p>
                        @endif
                </div>
       
                <div class="col-xs-4 form-group">
                    {{ html()->label(trans('quickadmin.coupons.fields.duration'), 'duration')->class('control-label') }}
                    {{ html()->select('duration', \App\Models\Coupon::$duarationOptions, old('duration'))->class('form-control') }}
                    <p class="help-block"></p>
                    @if($errors->has('duration'))
                        <p class="help-block">
                            {{ $errors->first('duration') }}
                        </p>
                    @endif
                </div>
            </div>
            @endif
        
        <div class="row">
            @if(@!$coupon->id)
            <div class="col-xs-4 form-group">
                {{ html()->label(trans('quickadmin.coupons.fields.max_redemptions'), 'max_redemptions')->class('control-label') }}
                {{ html()->text('max_redemptions', old('max_redemptions'))->class('form-control')->placeholder('') }}
                <p class="help-block"></p>
                @if($errors->has('max_redemptions'))
                    <p class="help-block">
                        {{ $errors->first('max_redemptions') }}
                    </p>
                @endif
            </div>
            @endif
            @if(@!$coupon->id)
            <div class="col-xs-4 form-group">
                    {{ html()->label(trans('quickadmin.coupons.fields.minprice'), 'minprice')->class('control-label') }}
                    {{ html()->text('minprice', old('minprice'))->class('form-control')->placeholder('') }}
                    <p class="help-block"></p>
                    @if($errors->has('minprice'))
                        <p class="help-block">
                            {{ $errors->first('minprice') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                    {{ html()->label(trans('quickadmin.coupons.fields.expires_at'), 'expires_at')->class('control-label') }}
                    {{ html()->text('expires_at', old('expires_at'))->class('form-control datetimepicker')->placeholder('') }}
                    <p class="help-block"></p>
                    @if($errors->has('expires_at'))
                        <p class="help-block">
                            {{ $errors->first('expires_at') }}
                        </p>
                    @endif
                </div>
        @endif 
        </div>
    
    @if(@$coupon->id)
    <div class="row">
        <div class="col-xs-12 form-group">
            <span class="control-label">Note</span>
            : Other coupon details (currency, duration, amount_off) are, by design, not editable.
        </div>
    </div>
    @endif
    {{ html()->submit(trans('quickadmin.qa_save'))->class('btn btn-danger') }}
    </div>
       
@push('scripts')
<link rel='stylesheet' href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
<script src="{!!asset('adminlte/plugins/select2/select2.min.js')!!}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment.js"></script>
<link rel='stylesheet' href="{{ asset('adminlte/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
<script src="{!!asset('adminlte/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')!!}"></script>

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

<script>
$(document).ready(function () {
$('.select2').select2();
$('.datetimepicker').datetimepicker({
                format : 'YYYY-MM-DD' ,
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                      up: "fa fa-arrow-up",
                previous: "fa fa-arrow-left",
                    next: "fa fa-arrow-right",
                    down: "fa fa-arrow-down"
                }
            });
});
</script>
@endpush

