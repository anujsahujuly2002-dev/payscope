<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @section('title')
        Login
    @endsection
    @include('admin.layouts.title-meta')
    @include('admin.layouts.header')
</head>
<body style="margin: 0; padding: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f7f7f7; color: #333333;">
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #f7f7f7; padding: 20px;">
        <tr>
            <td align="center">
                <table cellpadding="0" cellspacing="0" border="0" width="600" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="padding: 30px 0; background-color: #f8f9fa; border-bottom: 1px solid #e9ecef;">
                            <span class="logo-lg">
                                <img src="{{ URL::asset('/assets/images/logo-dark.png') }}" alt="Company Logo" height="40" style="max-width: 180px; height: auto;">
                            </span>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <h1 style="color: #2c3e50; font-size: 24px; font-weight: 600; margin: 0 0 20px 0; text-align: center;">Profile Verification</h1>

                            <p style="color: #555; font-size: 16px; line-height: 1.5; margin-bottom: 25px; text-align: center;">
                                Your 6-digit OTP for profile verification is:
                            </p>

                            <div style="background-color: #f8f9fa; border-radius: 6px; border: 1px solid #e9ecef; font-family: monospace; font-size: 32px; font-weight: 700; letter-spacing: 5px; margin: 0 auto 30px; padding: 15px; text-align: center; width: 60%;">
                                {{$otp}}
                            </div>

                            <p style="color: #666; font-size: 14px; line-height: 1.5; text-align: center; margin-bottom: 10px;">
                                This code will expire in 10 minutes.
                            </p>

                            <p style="color: #666; font-size: 14px; line-height: 1.5; text-align: center; margin-bottom: 0;">
                                If you did not request this verification, please ignore this email or contact support.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8f9fa; border-top: 1px solid #e9ecef; padding: 20px 30px; text-align: center;">
                            <p style="color: #999; font-size: 13px; margin: 0;">
                                &copy; {{ date('Y') }} Groscope. All rights reserved.
                            </p>
                            <p style="color: #999; font-size: 12px; margin: 10px 0 0 0;">
                                This is an automated message. Please do not reply.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    @include('admin.layouts.scripts')
</body>
</html>
