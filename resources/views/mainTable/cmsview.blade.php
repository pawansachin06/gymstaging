@extends('layouts.mainTable',['bodyClass'=>'home-screen'])
@section('content')
    <section class="innerpage-cont body-cont list-deatils">
        <div class="container mt-5"> 
            {!! $record['value'] !!}
        </div>
    </section>
@stop

