<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Employee System</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: linear-gradient(135deg, #1e3a5f 0%, #2b6cb0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .wrapper {
            width: 100%;
            max-width: 420px;
        }

        .brand {
            text-align: center;
            margin-bottom: 28px;
        }

        .brand h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.3px;
        }

        .brand p {
            color: rgba(255,255,255,0.7);
            font-size: 0.9rem;
            margin-top: 4px;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.25);
            padding: 40px 36px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        input {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.95rem;
            color: #2d3748;
            background: #f7fafc;
            outline: none;
            transition: border-color 0.2s, background 0.2s;
        }

        input:focus {
            border-color: #3182ce;
            background: #fff;
        }

        .error-box {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 8px;
            padding: 11px 14px;
            color: #c53030;
            font-size: 0.85rem;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .error-box::before {
            content: '⚠';
            font-size: 1rem;
        }

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #2b6cb0, #3182ce);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.1s;
            margin-top: 8px;
            letter-spacing: 0.02em;
        }

        button:hover { opacity: 0.92; }
        button:active { transform: scale(0.99); }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.8rem;
            color: rgba(255,255,255,0.5);
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="brand">
            <h1>Employee System</h1>
            <p>Sign in to access the employee directory</p>
        </div>

        <div class="card">
            @if ($errors->has('login'))
                <div class="error-box">{{ $errors->first('login') }}</div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username"
                           value="{{ old('username') }}" placeholder="Enter your username" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password"
                           placeholder="Enter your password" required>
                </div>
                <button type="submit">Sign In</button>
            </form>
        </div>

        <p class="footer">BRI Study Case &mdash; Backend API System</p>
    </div>
</body>
</html>
