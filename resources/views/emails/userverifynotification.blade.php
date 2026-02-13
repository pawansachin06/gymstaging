@component('mail::message')
<table class="welcome-content">
    <tr>
        <td>
            <h3>Hey, {{$user->name}}!</h3>
            <p>Your account is now verified! Check it out below:</p>
            <p><a href="{{route('listing.view', $listing->slug)}}">{{ route('listing.view', $listing->slug) }}</a></p>
        </td>
    </tr>
</table>
@endcomponent
