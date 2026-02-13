@component('mail::message')
<table class="welcome-content">
    <tr>
        <td>
            <h3>Welcome, {{$name}}!</h3>
            <p>Activate your account by clicking on the button below!</p>
            <p><a href="{{ route('verify.token',$token) }}" style="background-color: #17a2b8;color: #ffffff;text-decoration: none;padding: 10px 25px;border-radius: 6px;">Activate Account</a></p>
            <br>
            <h5>Thank for signing up!</h5>
            <h5>The GymSelect Team</h5>
        </td>
    </tr>
</table>
@endcomponent
