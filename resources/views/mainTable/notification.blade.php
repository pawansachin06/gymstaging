@extends('layouts.mainTable',['bodyClass'=>'home-screen'])
@section('content')
    <section class="innerpage-cont body-cont list-deatils">
        <ul class="tr-dropdown notification-dropdown">
            <li><a href='#'class="dropdown-item notification-heading">Notifications</a></li>
            @if($notifications->isEmpty())
                <li><a href='#' class="dropdown-item"><span class="msg_info">No Notifications Here</span></a></li>
            @else
                @foreach($notifications as $notification)
                    <li>
                        <a href="{{route('user.read_notification',[$notification->id])}}" class="dropdown-item {{ ($notification->mark_as_read == 0) ? 'unread_msg' : ''}}">
                            <span class="msg_info">{{$notification->message}}</span>
                            <i class="float-right text-day">{{\Carbon\Carbon::parse($notification->created_at)->diffForHumans(null, true, true)}}</i>
                        </a>
                    </li>
                @endForeach
            @endif
        </ul>
    </section>
@endsection
