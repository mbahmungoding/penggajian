<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaleSkip Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        .container {
            display: flex;
            width: 800px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            background-color: #fff;
        }
        .left {
            background: linear-gradient(135deg, #4A90E2, #002f6c);
            color: #fff;
            padding: 40px;
            flex: 1;
        }
        .left h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }
        .left p {
            font-size: 16px;
            line-height: 1.5;
        }
        .right {
            padding: 40px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .right h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4A90E2;
            color: #fff;
            text-align: center;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #357ABD;
        }
        .google-login {
            background-color: #fff;
            color: #4A90E2;
            border: 1px solid #4A90E2;
        }
        .google-login:hover {
            background-color: #f0f8ff;
        }
        a {
            color: #4A90E2;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left">
            <h1>Hello SaleSkip! 👋</h1>
            <p>Skip repetitive and manual sales-marketing tasks. Get highly productive through automation and save tons of time!</p>
        </div>
        <div class="right">
            <h2>Welcome Back!</h2>
            <p>Don't have an account? <a href="register.php">Create a new account now</a>, it's FREE! Takes less than a minute.</p>
            <form action="login_handler.php" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn">Login Now</button>
                <button type="button" class="btn google-login">Login with Google</button>
            </form>
            <p><a href="forgot_password.php">Forgot password?</a></p>
        </div>
    </div>
</body>
</html>
