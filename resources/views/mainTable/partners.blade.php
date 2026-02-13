@extends('layouts.mainTable')
@section('content')
    <section class="innerpage-cont body-cont list-deatils">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="signup-heading">
                        <h2>Partners</h2>
                        <span>Select and visit all our awesome partners!</span>
                    </div>
                </div>
                @foreach($partners as $partner)
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 partner-list">
                        <div class="partner-thumb">
                            <a  target="_blank" title="{{ $partner->name }}">
                                <img src="{{ $partner->getUrl('logo') }}" alt="{{ $partner->name }}"/>
                            </a>

                        <a class="btn btn-collapse-custom collapsed" data-toggle="collapse" href="#{{str_replace(' ', '', $partner->name)}}" role="button" aria-expanded="false" aria-controls="{{ $partner->name }}">
                            </a>
                            <div class="collapse" id="{{str_replace(' ', '', $partner->name)}}">
                                <div class="card card-body partner-collapse-content">
                                   <h4>
                                       {{ $partner->name }}
                                   </h4>
                                    <p>
                                        {!! nl2br($partner->about_us) !!}
                                    </p>
                                    <a class="btn btn2" href="{{$partner->link}}">Visit Site</a>
                                </div>
                            </div>
                        </div>    
                    </div>
                @endforeach
            </div>
        </div>
         <p style="margin-left: 0em;padding: 0 7em 2em 0;border-width: 120px; border-color: white; border-style:solid;"></p>
    </section>
@endsection