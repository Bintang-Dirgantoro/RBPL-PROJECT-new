<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
</head>
<body>

    <form action="/login" method="POST">
    @csrf

    <label>Username</label><br>
    <input type="text" name="username" required>
    <br>

    <label>Password</label><br>
    <input type="password" name="password" required>
    <br>

    <button type="submit">Login</button>
</form>
</body>
</html>