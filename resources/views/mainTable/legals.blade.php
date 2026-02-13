@extends('layouts.mainTable',['bodyClass'=>'home-screen'])
@section('content')

    <section class="body-cont">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 col-xl-12 mx-auto">
                    @include('partials.heading',['title'=>'Legals','subtitle'=>'Click and view our legals'])

                    <div class="bg-white rounded shadow mt-5 business-join-cont">
                        <div class="px-4 py-4 show row">
                            <div class="col-12 col-md-12 col-lg-6 col-xl-6 mx-auto legal-option pad-custom-15">
                                <ul class="nav-selection nav nav-pills flex-column my-3">
                                    <li class="nav-item btn btn2 btn-block mb-2"><a href="{{ route('cms','privacy_policy') }}"> Privacy Policy </a></li>
                                    <li class="nav-item btn btn2 btn-block mb-2"><a href="{{ route('cms','terms_conditions') }}"> T's & C's </a></li>
                                    <li class="nav-item btn btn2 btn-block mb-2"><a href="javascript:void(0);" data-target="#cookieModal" data-toggle="modal"> Cookie Policy </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- End rounded tabs -->
                </div>
            </div>
        </div>
         <p style="margin-left: 0em;padding: 0 7em 2em 0;border-width: 80px; border-color: white; border-style:solid;"></p>
    </section>
@endsection
