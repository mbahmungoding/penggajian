<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
        }
        .container {
            display: flex;
            height: 100vh;
        }
        .left {
            flex: 1;
            background-color: #007bff;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .left img {
            width: 200px;
            margin-bottom: 20px;
        }
        .left h1 {
            font-size: 2.5em;
        }
        .left p {
            max-width: 300px;
            text-align: center;
            line-height: 1.6;
        }
        .right {
            flex: 1;
            background-color: white;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-container {
            width: 100%;
            max-width: 400px;
        }
        .form-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
        .social-login {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .social-login button {
            flex: 1;
            margin: 0 5px;
            background-color: #f0f0f0;
            color: #333;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Left Section -->
        <div class="left">
            <img src="https://via.placeholder.com/150" alt="Illustration">
            <h1>Welcome to LOREM</h1>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
        </div>

        <!-- Right Section -->
        <div class="right">
            <div class="form-container">
                <h2>Sign In</h2>
                <form action="login_process.php" method="POST">
                    <div class="form-group">
                        <label for="username">Username or Email</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <button type="submit">Sign In</button>
                    </div>
                    <div class="form-group">
                        <a href="forgot_password.php">Forgot Password?</a>
                    </div>
                </form>
                <div class="social-login">
                    <button>Google</button>
                    <button>Facebook</button>
                    <button>Other</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
