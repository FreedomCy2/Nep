<?php
// Handle login form submission (optional demo only)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // --- Example authentication logic ---
    if ($username === "admin" && $password === "1234") {
        $message = "Login successful! (Demo only)";
    } else {
        $message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Flow - Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('your-background.jpg') no-repeat center center/cover;
        }

        .container {
            display: flex;
            width: 800px;
            height: 500px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            background: #ffffff;
        }

        /* Left side */
        .left-side {
            width: 45%;
            background: #68D6EC;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 30px 20px;
        }

        .logo {
            text-align: center;
        }

        .logo img {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }

        .features {
            margin-top: 20px;
        }

        .features p {
            font-size: 16px;
            margin: 15px 0;
            text-align: center;
            font-weight: 500;
        }

        .copyright {
            text-align: center;
            font-size: 12px;
            color: #e0e0e0;
        }

        /* Right side (Login Form) */
        .right-side {
            width: 55%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: #fff;
        }

        .login-form {
            width: 100%;
            max-width: 300px;
        }

        .login-form h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .login-form input {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
            font-size: 14px;
        }

        .login-form button {
            width: 100%;
            padding: 12px;
            background: #68D6EC;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-form button:hover {
            background: #4fb7c9;
        }

        .links {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }

        .links a {
            color: #68D6EC;
            text-decoration: none;
            margin: 0 5px;
        }

        .links a:hover {
            text-decoration: underline;
        }

        .message {
            text-align: center;
            margin-bottom: 10px;
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Left Side -->
        <div class="left-side">
            <div>
                <div class="logo">
                    <img src="your-logo.png" alt="Clinic Flow Logo">
                </div>
                <div class="features">
                    <p>Staff & User Management</p>
                    <p>Analytics & Reporting</p>
                    <p>Database Administration</p>
                    <p>Security & Permissions</p>
                </div>
            </div>
            <div class="copyright">
                Copyright ©2025 Clinic Flow
            </div>
        </div>

        <!-- Right Side -->
        <div class="right-side">
            <form class="login-form" method="POST" action="">
                <h2>Login</h2>

                <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>

                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>

                <button type="submit">Login</button>

                <div class="links">
                    <p>Don't have an account? <a href="register.php">Register</a></p>
                    <p><a href="forgot_password.php">Forgot your password?</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
