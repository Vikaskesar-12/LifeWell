<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIFWEL Account Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .luvshare-wrap {
            background: #ffffff;
            padding: 20px;
            margin: 20px auto;
            max-width: 600px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .luvshare-wrap .header-wrap {
            background: var(--btn-color, linear-gradient(to right, #d7181f, #000));
            width: 100%;
            /* margin: 0 auto; */
            text-align: center;
            padding: 1px;
            /* position: absolute; */
            top: 0;
            left: 0;
            right: 0;
            z-index: 99;
        }

        .header-wrap img {
            width: 80px;
            /* Adjust the logo size */
            padding: 8px;
            display: block;
            margin: 0 auto;
        }

        .box-shadow {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }

        p {
            margin-bottom: 15px;
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }

        .verification-code {
            font-size: 24px;
            font-weight: bold;
            color: #099D90;
        }

        .expires {
            color: #ff0000;
        }

        .footer-text {
            font-size: 14px;
            color: #555;
            text-align: center;
            /* Center the text */
        }

        .footer-text a {
            color: #099D90;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="luvshare-wrap">

        <div class="header-wrap">

            <img src="{{ secure_asset('frontend/img/logo/logo.png') }}" alt="LIFWEL Logo">
        </div>

        <div class="box-shadow">
            <p>Hi {{ $name }},</p>
            <p>Welcome to LIFWEL!</p>
            <p>We are thrilled to have you on board. You are just one step away from unlocking all the amazing features
                LIFWEL has to offer.</p>
            <p>To complete your registration, please use the following verification code:</p>
            <p>Your OTP: <span class="verification-code">{{ $otp }}</span></p>
            <p class="expires">Expires in: 10 minutes</p>
            <p>If you did not sign up for LIFWEL, please ignore this email.</p>
            <p>Best Regards,</p>
            <p>Team LIFWEL</p>
        </div>
        <p class="footer-text">© {{ date('Y') }} <a href="{{ url('/') }}">LIFWEL</a>. All rights reserved.</p>
    </div>
</body>

</html>
