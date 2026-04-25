<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - POS System</title>
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background: #e2e5e8; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            height: 100vh; 
            margin: 0;
        }
        .login-card { 
            background: white; 
            padding: 2.5rem; 
            border-radius: 16px; 
            width: 100%; 
            max-width: 400px; 
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
        }
        h2 { margin: 0 0 0.5rem 0; font-size: 1.5rem; text-align: center; color: #1e293b; }
        p { text-align: center; color: #64748b; margin-bottom: 2rem; font-size: 0.9rem; }
        
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.85rem; color: #475569; }
        input { 
            width: 100%; 
            padding: 12px; 
            border: 1px solid #e2e8f0; 
            border-radius: 8px; 
            box-sizing: border-box;
            font-size: 1rem;
            transition: border-color 0.2s;
        }
        input:focus { outline: none; border-color: #3b82f6; ring: 2px solid #dbeafe; }
        
        button { 
            width: 100%; 
            padding: 12px; 
            background: #3b82f6; 
            color: white; 
            border: none; 
            border-radius: 8px; 
            font-weight: 700; 
            cursor: pointer; 
            font-size: 1rem;
            margin-top: 1rem;
        }
        button:hover { background: #2563eb; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Selamat Datang</h2>
        <p>Silakan masuk ke akun Anda</p>

        <form action="/login" method="POST">
            @csrf
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Contoh: kasir01" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit">Login ke Sistem</button>
        </form>
    </div>
</body>
</html>