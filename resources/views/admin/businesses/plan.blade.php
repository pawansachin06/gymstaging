@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('content')
    <h3 class="page-title">@lang('quickadmin.plans.title')</h3>
    <div class="panel panel-default">
        <div class="panel-heading">
        Plans
        </div>
        {{ html()->form('POST', route('admin.businesses.plan_store'))->open() }}
        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <td>Business</td>
                        <td align="center" colspan="3">Monthly</td>
                        <td align="center" colspan="3">Yearly</td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;    
                    @endphp
                    @foreach($businesses as $business)
                    @php
                        $monthly_plan = $business->plans()->where('frequency', 'M')->first();
                        $yearly_plan = $business->plans()->where('frequency', 'Y')->first();
                    @endphp
                    
                    <tr>
                        <td>{{$business->name}}</td>
                     
                        {{ html()->hidden("plans[$i][business_id]", $business->id) }}
                        {{ html()->hidden("plans[$i][frequency]", 'M') }}
                        <td colspan ="3">
                            {{ html()->select("plans[$i][plan_id]", $monthlyPlans, @$monthly_plan->plan_id)->class('form-control')->placeholder('Select your plan') }}
                        </td>
                        @php
                        $i++;
                        @endphp

                        {{ html()->hidden("plans[$i][business_id]", $business->id) }}
                        {{ html()->hidden("plans[$i][frequency]", 'Y') }}
                        <td colspan ="3">
                            {{ html()->select("plans[$i][plan_id]", $yearlyPlans, @$yearly_plan->plan_id)->class('form-control input-width')->placeholder('Select your plan') }}
                        </td>
                        @php
                        $i++;
                        @endphp
                    </tr>
                    
                    @endforeach
                </tbody>
            </table>
            {{ html()->submit('Save')->class('btn btn-danger') }}
            {{ html()->form()->close() }}

        </div>
    </div>
@stop


