<x-emails.wrapper>
    <div style="padding:16px 16px;">
        <h2 style="margin:0 0 16px 0;font-size:24px;">Help us protect your account</h2>
        <p style="margin:0 0 16px 0;">
            Before you sign in, we need to verify your identity.
            Enter the following code on the sign-in page.
        </p>
        <p style="margin:0 0 16px 0;font-size:32px;">
            <strong>{{ $otp }}</strong>
        </p>
        <p style="margin:0;">
            <small>
                If you have not recently tried to sign into GymSelect, we recommend changing your password.
                Your verification code expires after 15 minutes.
            </small>
        </p>
    </div>
</x-emails.wrapper>