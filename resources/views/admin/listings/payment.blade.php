@extends('layouts.app')

@section('content')
 <a href="{{ route('admin.listings.index') }}" class="btn btn-default" style="float:right" >@lang('quickadmin.qa_back_to_listing')</a>

    <h3 class="page-title">Payment</h3>
     <div class="panel panel-default">
        <div class="panel-heading">
           Payment
        </div>

        <div class="panel-body table-responsive">
                <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                             
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Charge Id</th>
                                <th>Subscription Id</th>
                            </tr>
                        </thead>
                    
                        <tbody>
                            @foreach($invoice_listings as $listing)
                                <tr>
                                    <td>{{Carbon\Carbon::parse($listing->date)->format('Y-m-d')}}</td>
                                    <td>{{$listing->amount}}</td>
                                    <td>{{$listing->stripe_charge_id}}</td>
                                    <td>{{$listing->subscription_id}}</td>   
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            <p>&nbsp;</p>

        </div>
    </div>
@stop
