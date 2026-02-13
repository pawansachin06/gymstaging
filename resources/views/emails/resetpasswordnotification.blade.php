@component('mail::message')
<table class="welcome-content">
    <tr>
        <td>
            <h3>Hey, {{ $name }}!</h3>
            <p>You are receiving this email because your requested a password reset for your account:</p>
            <br>
            <p><a href="{{ route('password.reset',$token) }}" style="background-color: #17a2b8;color: #ffffff;text-decoration: none;padding: 10px 25px;border-radius: 6px;">Reset Password</a></p>
            <br>
            <p>If you did not request a password reset, no further action is required.</p>
        </td>
    </tr>
</table>
@endcomponent
