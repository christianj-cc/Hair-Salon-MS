<!DOCTYPE html>
<html>

<head>
    <title>Account Reactivated</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif; background-color: #f4f7fb;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f7fb; padding: 30px 0;">
        <tr>
            <td align="center">
                <table width="500" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 8px 20px rgba(0,0,0,0.05); overflow: hidden;">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #ae2810; padding: 30px 25px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 600;">{{ config('app.name') }}</h1>
                            <p style="margin: 8px 0 0; color: #f9dbd5; font-size: 16px;">Account Reactivated</p>
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td style="padding: 35px 30px;">
                            <h2 style="margin-top: 0; color: #2c3e4e; font-size: 22px;">Hello {{ $customer->first_name }},</h2>
                            <p style="color: #4a627a; font-size: 16px; line-height: 1.5;">Your account with <strong>{{ config('app.name') }}</strong> has been <strong style="color: #ae2810;">reactivated</strong>.</p>

                            <p style="color: #4a627a; font-size: 16px; line-height: 1.5;">You can now log in and book appointments again.</p>

                            <div style="text-align: center; margin: 35px 0;">
                                <a href="{{ route('login') }}" style="background-color: #ae2810; color: #ffffff; padding: 14px 32px; border-radius: 40px; text-decoration: none; font-weight: 600; font-size: 16px; display: inline-block; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">Log In Now</a>
                            </div>

                            <p style="color: #7e95ab; font-size: 14px;">We’re glad to have you back!</p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8f9fc; padding: 20px 30px; text-align: center; border-top: 1px solid #e9ecef;">
                            <p style="margin: 0; color: #8a9db0; font-size: 13px;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>