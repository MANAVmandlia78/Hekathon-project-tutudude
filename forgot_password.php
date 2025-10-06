<?php
session_start();

$message = "";
$error_message = "";

if ($_POST) {
    include 'config.php';
    
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Check if email exists
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Generate reset token
        $token = bin2hex(random_bytes(32));
        $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        // Delete any existing tokens for this user
        $delete_query = "DELETE FROM password_reset_tokens WHERE user_id = " . $user['id'];
        mysqli_query($conn, $delete_query);
        
        // Insert new token
        $insert_query = "INSERT INTO password_reset_tokens (user_id, token, expires_at) VALUES ('" . $user['id'] . "', '$token', '$expires_at')";
        
        if (mysqli_query($conn, $insert_query)) {
            // In a real application, you would send an email here
            // For now, we'll just show the reset link
            $reset_link = "http://" . $_SERVER['HTTP_HOST'] . "/reset_password.php?token=" . $token;
            $message = "Password reset link: <a href='$reset_link'>$reset_link</a><br>(In a real application, this would be sent to your email)";
        } else {
            $error_message = "Failed to generate reset link. Please try again.";
        }
    } else {
        $error_message = "Email address not found.";
    }
    
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Menia - Forgot Password</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .forgot-password-container {
            background: white;
            padding: 60px 80px;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            max-width: 500px;
            width: 100%;
        }

        .logo {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 40px;
        }

        .title {
            text-align: center;
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 40px;
            font-size: 16px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 14px;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .form-group {
            margin-bottom: 30px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: #666;
            font-size: 14px;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 15px 0;
            border: none;
            border-bottom: 1px solid #ddd;
            font-size: 16px;
            background: transparent;
            outline: none;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            border-bottom-color: #333;
        }

        .submit-btn {
            width: 100%;
            padding: 18px;
            background: #333;
            color: white;
            border: none;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            margin-bottom: 20px;
            transition: background 0.3s;
            border-radius: 4px;
        }

        .submit-btn:hover {
            background: #555;
        }

        .back-to-login {
            text-align: center;
            margin-top: 30px;
        }

        .back-to-login a {
            color: #666;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }

        .back-to-login a:hover {
            color: #333;
        }

        @media (max-width: 768px) {
            .forgot-password-container {
                padding: 40px 30px;
                margin: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="forgot-password-container">
        <div class="logo">FOOD MENIA</div>
        
        <h1 class="title">Forgot Password</h1>
        <p class="subtitle">Enter your email address and we'll send you a link to reset your password.</p>
        
        <?php if ($error_message): ?>
            <div class="alert alert-error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <button type="submit" class="submit-btn">Send Reset Link</button>
        </form>
        
        <div class="back-to-login">
            <a href="login.php">← Back to Login</a>
        </div>
    </div>
</body>
</html>