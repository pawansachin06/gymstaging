@component('mail::message')
<table class="welcome-content">
    <tr>
        <td>
            <h3>Hey, {{$name}}</h3>
            <p>Click the link below to see your latest review:</p>
            <p><a href="{{route('listing.view', $slug). '#review-li-'.$review_id }}">{{$message}}</a></p>
        </td>
    </tr>
</table>
@endcomponent
