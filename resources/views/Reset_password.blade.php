<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Reset - Community App</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            margin: 0;
        }
        .container {
            max-width: 600px;
            background: #ffffff;
            border-radius: 8px;
            padding: 30px;
            margin: 40px auto;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            color: #333333;
            font-size: 24px;
            font-weight: bold;
        }
        .content {
            margin-top: 20px;
            font-size: 16px;
            color: #555555;
            line-height: 1.6;
        }
        .code-box {
            background-color: #f0f0f0;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            color: #28a745;
            margin: 20px 0;
            letter-spacing: 2px;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #888888;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Password Reset Request</div>
        <div class="content">
            <p>Hello,</p>
            <p>We received a request to reset your password for your Community App account.</p>
            <p>Your password reset code is:</p>
            <div class="code-box">{{ $reset_code }}</div>

            <p>Please enter this code in the "Reset Password" screen in the app to set a new password.</p>
            <p>Please note: this reset code will expire at <strong>{{ $reset_expires_at }}</strong>.</p>
            <p>If you did not request a password reset, you can safely ignore this email.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Community App. All rights reserved.
        </div>
    </div>
</body>
</html>
