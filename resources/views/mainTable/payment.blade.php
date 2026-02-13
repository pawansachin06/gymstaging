@extends('layouts.mainTable')
@push('header_scripts')
    <link href="{{asset('css/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/owl.theme.default.min.css')}}" rel="stylesheet">
@endpush
@section('content')
    <section class="innerpage-cont body-cont list-deatils">
        <div class="listing-deatils-heading">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                    <div  class="panel panel-default">
                                        <div class="panel-heading">
                                          <h1>  Payment </h1>
                            </div>
                            <div class="panel-body table-responsive">
                                    <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Amount</th>
                                                    <th>Charge Id</th>
                                                    <th>Subscription name</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($invoice_listings as $listing)
                                                    <tr>
                                                        <td>{{Carbon\Carbon::parse($listing->date)->format('Y-m-d')}}</td>
                                                        <td>{{$listing->amount}}</td>
                                                        <td>{{$listing->stripe_charge_id}}</td>
                                                        <td>{{$listing->subscription->name}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                <p>&nbsp;</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
