<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background: #ffffff; padding: 40px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .logo { text-align: center; margin-bottom: 30px; }
        .logo h1 { color: #7b57ff; margin: 0; font-size: 28px; }
        .content { text-align: center; }
        .code { font-size: 36px; font-weight: bold; letter-spacing: 5px; color: #7b57ff; background: #f0ecff; padding: 15px 30px; border-radius: 8px; display: inline-block; margin: 20px 0; }
        .footer { margin-top: 30px; text-align: center; font-size: 13px; color: #888; border-top: 1px solid #eee; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <h1>WellMind.LK</h1>
        </div>
        <div class="content">
            <h2>Verify Your Email</h2>
            <p>Thank you for creating an account with WellMind.LK. Your wellness journey starts here!</p>
            <p>Please use the verification code below to complete your registration:</p>
            <div class="code">{{ $code }}</div>
            <p>This code will expire in 15 minutes.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} WellMind.LK. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
