
<div class="panel-heading">
    @if(@$coupon->id) @lang('quickadmin.qa_edit') @else @lang('quickadmin.qa_create') @endif
</div>

<div class="panel-body">
    <div class="row">
        <div class="col-xs-4 form-group">
            {!! Form::label('code', trans('quickadmin.verificationcoupons.fields.code').'', ['class' => 'control-label']) !!}
            {!! Form::text('code', old('code'),['class' => 'form-control', 'placeholder' => '']) !!}
            <p class="help-block"></p>
            @if($errors->has('code'))
                <p class="help-block">
                    {{ $errors->first('code') }}
                </p>
            @endif
        </div>
        <div class="col-xs-4 form-group">
            {!! Form::label('Business', trans('quickadmin.verificationcoupons.fields.business').'', ['class' => 'control-label']) !!}
            {!! Form::select('business[]',$businesses, old('business'), ['class' => 'form-control select2' , 'multiple' => "multiple"]) !!}
            <p class="help-block"></p>
            @if($errors->has('business'))
                <p class="help-block">
                    {{ $errors->first('business') }}
                </p>
            @endif
        </div>
        <div class="col-xs-4 form-group">
            {!! Form::label('type', trans('quickadmin.verificationcoupons.fields.type').'', ['class' => 'control-label']) !!}
            {!! Form::select('type', \App\Models\Coupon::$types, old('type'), ['class' => 'form-control']) !!}
            <p class="help-block"></p>
            @if($errors->has('type'))
                <p class="help-block">
                    {{ $errors->first('type') }}
                </p>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-xs-4 form-group">
            {!! Form::label('value', trans('quickadmin.verificationcoupons.fields.value').'', ['class' => 'control-label']) !!}
            {!! Form::text('value', old('value'), ['class' => 'form-control', 'placeholder' => '']) !!}
            <p class="help-block"></p>
            @if($errors->has('value'))
                <p class="help-block">
                    {{ $errors->first('value') }}
                </p>
            @endif
        </div>
        <div class="col-xs-4 form-group">
            {!! Form::label('Status', trans('quickadmin.verificationcoupons.fields.status').'', ['class' => 'control-label']) !!}
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
    </div>
    @if(@!$coupon->id)
        <div class="row">
            <div class="col-xs-4 form-group">
                {!! Form::label('description', trans('quickadmin.listings.fields.description').'', ['class' => 'control-label']) !!}
                {!! Form::textarea('description', old('description'), ['class' => 'form-control ', 'placeholder' => '', 'rows' => "4"]) !!}
            </div>
        </div>
    @endif

    @if(@$coupon->id)
        <div class="row">
            <div class="col-xs-12 form-group">
                <span class="control-label">Note</span>
                : Other coupon details (currency, duration, amount_off) are, by design, not editable.
            </div>
        </div>
    @endif
    {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
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

