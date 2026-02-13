@component('mail::message')
<table class="welcome-content">
    <tr>
        <td>
            <h3>Hi Admin,</h3>
            <p>You have a new message from below User.</p>
            <p>Name : {{$name}}</p>
            <p>Email: {{$email}}</p>
            <p>Subject: {{$subject}}</p>
            <p>Message: {{$message}}</p>
        </td>
    </tr>
</table>
@endcomponent
