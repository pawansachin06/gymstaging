@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.verificationcoupons.title')</h3>
    @can('coupon_create')
        <p>
            <a href="{{ route('admin.verificationcoupon.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
        </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_verificationcoupons_switch')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-inline">
                    <div class="form-group mr-3">
                        <label for="gym_coupon">Gym coupon</label>
                        <label class="switch">
                            <input type="hidden" name="gym_verification_coupon" value="0">
                            <input type="checkbox" name="gym_verification_coupon" value="1" {{ $toggleCoupon['gym'] == '1' ? 'checked' : '' }} class="switch-coupon"><span class="slider"></span>
                        </label>
                    </div>
                    <div class="form-group mr-3">
                        <label for="gym_coupon">Coach coupon</label>
                        <label class="switch">
                            <input type="hidden" name="coach_verification_coupon" value="0">
                            <input type="checkbox" name="coach_verification_coupon" value="1" {{ $toggleCoupon['coach'] == '1' ? 'checked' : '' }}  class="switch-coupon"><span class="slider"></span>
                        </label>
                    </div>
                    <div class="form-group mr-3">
                        <label for="gym_coupon">Physio coupon</label>
                        <label class="switch">
                            <input type="hidden" name="physio_verification_coupon" value="0">
                            <input type="checkbox" name="physio_verification_coupon" value="1" {{ $toggleCoupon['physio'] == '1' ? 'checked' : '' }}  class="switch-coupon"><span class="slider"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_verificationcoupons')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($verificationcoupons) > 0 ? 'datatable' : '' }}">
                <thead>
                <tr>

                    <th>@lang('quickadmin.verificationcoupons.fields.code')</th>
                    <th>@lang('quickadmin.verificationcoupons.fields.type')</th>
                    <th>@lang('quickadmin.verificationcoupons.fields.value')</th>
                    <th>@lang('quickadmin.verificationcoupons.fields.redemptions')</th>
                    <th>@lang('quickadmin.verificationcoupons.fields.max_redemptions')</th>
                    <th>@lang('quickadmin.verificationcoupons.fields.status')</th>
                    <th>Coupon Type</th>
                    <th>Option</th>
                </tr>
                </thead>

                <tbody>
                @if (count($verificationcoupons) > 0)
                    @foreach ($verificationcoupons as $coupon)
                        <tr data-entry-id="{{ $coupon->id }}">
                            <td field-key='code'>{{ $coupon->code }}</td>
                            <td field-key='type'>{{ $coupon->type ? 'Percentage' : 'Flat Amount' }}</td>
                            <td field-key='value'>
                                <span class="label label-info label-many">{{ $coupon->value }}</span>
                            </td>
                            <td field-key='count'>{{$coupon->redemptions }}</td>
                            <td field-key='max_redemptions'>{{$coupon->max_redemptions }}</td>
                            <td field-key='status'>{{$coupon->status }}</td>
                            <td field-key='coupon_type'>
                                @foreach($coupon->business as $business)
                                    <span class="label label-primary label-many">{{ $business->label }}</span>
                                @endforeach
                            </td>
                            @can('coupon_edit')
                                <td><a href="{{ route('admin.verificationcoupon.edit',$coupon->id) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a></td>
                            @endcan
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="11">@lang('quickadmin.qa_no_entries_in_table')</td>
                    </tr>
                @endif

                </tbody>
            </table>
        </div>
    </div>
@stop

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
        .mr-3 {
            margin-right: 3rem;
        }
    </style>

    <script>
        $(function (){
            $('.switch-coupon').on('change', function (){
                $.post('{{ route('admin.verificationcoupon.toggle') }}',{ field: $(this).attr('name'), value: $(this).is(':checked') ? 1 : 0 });
            });
        });
    </script>
@endpush
