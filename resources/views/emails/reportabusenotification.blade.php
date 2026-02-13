@component('mail::message')
<table class="welcome-content">
    <tr>
        <td>
            <h3>Hi,</h3>
            <p>You have a new Report Abuse message from this <a href="{{route('listing.view', $slug). '#review-li-'.$review_id }}">review</a></p>
            <p>Message: {{$message}}</p>
        </td>
    </tr>
</table>
@endcomponent
