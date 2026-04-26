<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden</title>
    <style>
        body { background: #f8fafc; font-family: Arial, sans-serif; margin: 0; }
        .box { max-width: 520px; margin: 10vh auto; background: #ffffff; border: 1px solid #e2e8f0; padding: 2rem; border-radius: 0.75rem; text-align: center; box-shadow: 0 10px 24px rgba(0,0,0,.08); }
        h1 { color:#1f2937; margin-bottom:0.5rem; }
        p { color:#4b5563; margin:0.5rem 0 1.3rem; }
        a { color:#0f766e; text-decoration:none; font-weight:600; }
    </style>
</head>
<body>
    <div class="box">
        <h1>403 Forbidden</h1>
        <p>You don’t have permission to access this page.</p>
        <a href="{{ route('dashboard') }}">Go to Dashboard</a>
    </div>
</body>
</html>
