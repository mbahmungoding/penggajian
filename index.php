<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="icon" href="logo.png" type="image/x-icon">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 40px;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-logo img {
            max-width: 150px;
            height: auto;
        }

        .login-container h4 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .login-container .form-group {
            margin-bottom: 25px;
        }

        .login-container .form-control {
            border-radius: 20px;
            padding: 10px 15px;
        }

        .login-container .btn-primary {
            width: 100%;
            border-radius: 20px;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            background-color: #4267B2;
            border: none;
        }

        .login-container .btn-primary:hover {
            background-color: #365899;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-logo">
            <img src="logo.png" alt="Company Logo">
        </div>
        <h4>Welcome</h4>
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>