<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome Employer</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f7f7f7; padding:20px;">
    <div style="max-width:600px; margin:0 auto; background:#ffffff; padding:30px; border-radius:10px; border:1px solid #e5e5e5;">
        
        <h2 style="margin-top:0; color:#1c2c3e;">Welcome to ConstructKaro</h2>

        <p>Dear <strong>{{ $employer->name }}</strong>,</p>

        <p>Your Client account has been created successfully.</p>

        <p><strong>Company Name:</strong> {{ $employer->company_name }}</p>
        <p><strong>Login Email:</strong> {{ $employer->email }}</p>
        <p><strong>Password:</strong> {{ $plainPassword }}</p>

        <p>
            You can log in here:<br>
            <a href="{{ $loginUrl }}">{{ $loginUrl }}</a>
        </p>

        <p>Please change your password after first login.</p>

        <br>
        <p>Regards,<br><strong>ConstructKaro Team</strong></p>
    </div>
</body>
</html>