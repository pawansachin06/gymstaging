@component('mail::message')
    <table class="welcome-content">
        <tr>
            <td>
                <h3>Hey, Admin,</h3>
                <p> {{ $owner->name }} has requested verification.</p>
                <p>View there account here:</p>
                <p><a href="{{ route('listing.view', $listing->slug) }}">{{ route('listing.view', $listing->slug) }}</a></p>
            </td>
        </tr>
    </table>
@endcomponent
