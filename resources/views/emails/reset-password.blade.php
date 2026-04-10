<x-emails.wrapper>
    <div style="padding:16px 16px;">
        <p>Hi, {{ $name }},</p>
        <p>
            We received a request to reset your password. Click the link below to create a new one.<br />
            If you didn’t request this, you can safely ignore this email.
        </p>
        <p>
            <a href="{{ route('password.reset', [$token, 'email' => $email]) }}" style="background-color:#17a2b8;color:#ffffff;text-decoration:none;padding:10px 25px;border-radius:6px;">
                Reset Password
            </a>
        </p>
    </div>
</x-emails.wrapper>