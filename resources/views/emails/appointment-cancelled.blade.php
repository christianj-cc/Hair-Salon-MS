<!DOCTYPE html>
<html>

<head>
    <title>Appointment Cancelled</title>
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
                            <p style="margin: 8px 0 0; color: #f9dbd5; font-size: 16px;">Appointment Cancelled</p>
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td style="padding: 35px 30px;">
                            <h2 style="margin-top: 0; color: #2c3e4e; font-size: 22px;">Hello {{ $appointment->customer->first_name }},</h2>
                            <p style="color: #4a627a; font-size: 16px; line-height: 1.5;">Your appointment on <strong>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}</strong> at <strong>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</strong> has been <strong style="color: #ae2810;">cancelled</strong>.</p>

                            @if($reason)
                            <div style="background-color: #f9f9fc; border-left: 4px solid #ae2810; padding: 12px 16px; margin: 25px 0; border-radius: 8px;">
                                <p style="margin: 0 0 4px; font-size: 14px; color: #5a6e7c;"><strong>Cancellation reason:</strong></p>
                                <p style="margin: 0; font-size: 14px; color: #2c3e4e;">{{ $reason }}</p>
                            </div>
                            @endif

                            <p style="color: #4a627a; font-size: 16px; line-height: 1.5;">If you did not request this cancellation or wish to reschedule, please contact us.</p>

                            <div style="text-align: center; margin: 35px 0;">
                                <a href="{{ route('customer.appointments.create') }}" style="background-color: #ae2810; color: #ffffff; padding: 14px 32px; border-radius: 40px; text-decoration: none; font-weight: 600; font-size: 16px; display: inline-block; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">Book a New Appointment</a>
                            </div>

                            <p style="color: #7e95ab; font-size: 14px;">We hope to serve you again soon.</p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8f9fc; padding: 20px 30px; text-align: center; border-top: 1px solid #e9ecef;">
                            <p style="margin: 0; color: #8a9db0; font-size: 13px;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
    </table>
    </tr>
    </table>
</body>

</html>