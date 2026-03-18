<table cellpadding="0" cellspacing="0" border="0" style="width:100%;background-color:#ffffff;border-collapse:collapse;">
    <tbody style="font-family:'Google Sans',Roboto,RobotoDraft,Helvetica,Arial,sans-serif;">
        <tr>
            <td style="padding:16px 16px;background:#212121;">
                <table cellpadding="0" cellspacing="0" style="width:100%">
                    <tbody>
                        <tr>
                            <td style="padding:0;text-align:center;">
                                <a href="{{ url('/') }}">
                                    <img src="{{ url('emails/logo-white.png') }}"
                                        alt="GymSelect" width="240px"
                                        height="45px" style="display:inline-block" />
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding:0;">
                <div style="max-width:600px;margin:0 auto;">
                    {{ $slot }}
                </div>
            </td>
        </tr>
        <tr>
            <td style="padding:0;">
                <div style="height:4px;background:linear-gradient(90deg,#18b9b5,#ff1aff)"></div>
            </td>
        </tr>
        <tr>
            <td style="background:#212121;padding:16px;">
                <p style="color:#fafafa;text-align:center;">
                    GymSelect &copy; {{ date('Y') }}
                </p>
            </td>
        </tr>
    </tbody>
</table>