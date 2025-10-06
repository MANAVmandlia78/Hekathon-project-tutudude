<?php
session_start();

// Redirect already logged-in users
if (isset($_SESSION['user_id'])) {
    header("Location: street_food_website.php");
    exit();
}

$error_message = "";
$success_message = "";

if ($_POST) {
    include 'config.php';

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $action = $_POST['action'];

    if ($action == 'signin') {
        // Sign in logic
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['role'] = $user['role'];  // store role in session

                // Redirect after login
                header("Location: street_food_website.php");
                exit();
            } else {
                $error_message = "Invalid email or password!";
            }
        } else {
            $error_message = "Invalid email or password!";
        }
    } elseif ($action == 'register') {
        // Registration logic
        $confirm_password = $_POST['confirm_password'];
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $role = isset($_POST['role']) ? mysqli_real_escape_string($conn, $_POST['role']) : 'buyer';

        if ($password !== $confirm_password) {
            $error_message = "Passwords do not match!";
        } else {
            $check_query = "SELECT * FROM users WHERE email = '$email'";
            $check_result = mysqli_query($conn, $check_query);

            if (mysqli_num_rows($check_result) > 0) {
                $error_message = "Email already exists!";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $insert_query = "INSERT INTO users (name, email, password, role, created_at) 
                                 VALUES ('$name', '$email', '$hashed_password', '$role', NOW())";

                if (mysqli_query($conn, $insert_query)) {
                    $success_message = "Registration successful! You can now sign in.";
                } else {
                    $error_message = "Registration failed! Please try again.";
                }
            }
        }
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Menia - Login</title>
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
        }

        /* Header */
        .header {
            background: white;
            padding: 15px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: relative;
            z-index: 100;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .logo {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 40px;
        }

        .nav-menu a {
            text-decoration: none;
            color: #666;
            font-size: 16px;
            font-weight: 500;
        }

        .cart-icon {
            width: 20px;
            height: 20px;
            border: 2px solid #333;
            border-radius: 2px;
        }

        /* Main Container */
        .main-container {
            display: flex;
            max-width: 1200px;
            margin: 0 auto;
            min-height: calc(100vh - 80px);
        }

        /* Left Side - Photo Strip Grid */
        .left-section {
            flex: 1;
            padding: 0;
            position: relative;
            background: white;
            overflow: hidden;
        }

        .photo-strip-grid {
            display: flex;
            height: calc(100vh - 80px);
            gap: 2px;
        }

        .photo-strip {
            flex: 1;
            background-image: url('food imaguu.avif');
            background-size: 600% 100%;
            background-repeat: no-repeat;
            position: relative;
            transition: transform 0.3s ease, filter 0.3s ease;
            filter: brightness(0.8) contrast(1.1);
        }

        .photo-strip:hover {
            transform: scaleY(1.02);
            filter: brightness(1) contrast(1.2);
            z-index: 5;
        }

        .photo-strip:nth-child(1) { background-position: 0% center; }
        .photo-strip:nth-child(2) { background-position: 20% center; }
        .photo-strip:nth-child(3) { background-position: 40% center; }
        .photo-strip:nth-child(4) { background-position: 60% center; }
        .photo-strip:nth-child(5) { background-position: 80% center; }
        .photo-strip:nth-child(6) { background-position: 100% center; }

        .photo-strip::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(
                180deg, 
                rgba(57, 51, 51, 0.1) 0%, 
                rgba(57, 51, 51, 0.1) 50%, 
                rgba(57, 51, 51, 0.1) 100%
            );
            transition: opacity 0.3s ease;
        }

        .photo-strip:hover::before {
            opacity: 0.7;
        }

        /* Right Side - Login Form */
        .right-section {
            flex: 1;
            background: white;
            padding: 60px 80px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Alert Messages */
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

        /* Tab Headers */
        .auth-tabs {
            display: flex;
            margin-bottom: 40px;
            border-bottom: 1px solid #e0e0e0;
        }

        .tab {
            flex: 1;
            padding: 20px 0;
            text-align: center;
            font-size: 18px;
            font-weight: 500;
            color: #999;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.3s;
        }

        .tab.active {
            color: #333;
            border-bottom-color: #333;
        }

        /* Form Styles */
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
        }

        .submit-btn:hover {
            background: #555;
        }

        .forgot-password {
            text-align: center;
            margin: 20px 0 40px 0;
        }

        .forgot-password a {
            color: #666;
            text-decoration: none;
            font-size: 14px;
        }

        /* Social Media Section */
        .social-section {
            text-align: center;
        }

        .social-divider {
            position: relative;
            margin: 30px 0;
        }

        .social-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #ddd;
        }

        .social-divider .star {
            background: white;
            padding: 0 20px;
            font-size: 20px;
            color: #666;
        }

        .social-buttons {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .social-btn {
            flex: 1;
            padding: 12px;
            border: 1px solid #ddd;
            background: white;
            color: #666;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .social-btn:hover {
            border-color: #333;
            color: #333;
        }

        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
            }
            
            .right-section {
                padding: 40px 30px;
            }
            
            .nav-menu {
                display: none;
            }
            
            .photo-strip-grid {
                height: 300px;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="nav-container">
            <div class="logo">FOOD MENIA</div>
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#service">Service</a></li>
                    <li><a href="#project">Project</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="logout.php">Logout</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            <div class="cart-icon"></div>
        </div>
    </header>

<div class="main-container">
        <!-- Left Section -->
        <div class="left-section">
            <div class="photo-strip-grid">
                <div class="photo-strip"></div>
                <div class="photo-strip"></div>
                <div class="photo-strip"></div>
                <div class="photo-strip"></div>
                <div class="photo-strip"></div>
                <div class="photo-strip"></div>
            </div>
        </div>

        <!-- Right Section -->
        <div class="right-section">
            <?php if ($error_message): ?>
                <div class="alert alert-error"><?php echo $error_message; ?></div>
            <?php endif; ?>
            
            <?php if ($success_message): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php endif; ?>

            <div class="auth-tabs">
                <div class="tab active" id="signin-tab">SignIn</div>
                <div class="tab" id="register-tab">Register</div>
            </div>

            <form id="auth-form" method="POST" action="">
                <input type="hidden" name="action" id="form-action" value="signin">
                
                <div class="form-group" id="name-group" style="display: none;">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name">
                </div>

                <!-- Role dropdown (for registration only) -->
                <div class="form-group" id="role-group" style="display: none;">
                    <label for="role">Register as</label>
                    <select id="role" name="role">
                        <option value="buyer" selected>Buyer</option>
                        <option value="seller">Seller</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="email">Email Id</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group" id="confirm-password-group" style="display: none;">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm_password">
                </div>

                <button type="submit" class="submit-btn" id="submit-btn">SUBMIT</button>
            </form>
        </div>
    </div>

    <script>
        const signinTab = document.getElementById('signin-tab');
        const registerTab = document.getElementById('register-tab');
        const confirmPasswordGroup = document.getElementById('confirm-password-group');
        const nameGroup = document.getElementById('name-group');
        const roleGroup = document.getElementById('role-group');
        const submitBtn = document.getElementById('submit-btn');
        const formAction = document.getElementById('form-action');
        const nameInput = document.getElementById('name');
        const confirmPasswordInput = document.getElementById('confirm-password');

        signinTab.addEventListener('click', () => {
            signinTab.classList.add('active');
            registerTab.classList.remove('active');
            confirmPasswordGroup.style.display = 'none';
            nameGroup.style.display = 'none';
            roleGroup.style.display = 'none';
            submitBtn.textContent = 'SIGN IN';
            formAction.value = 'signin';
            nameInput.required = false;
            confirmPasswordInput.required = false;
        });

        registerTab.addEventListener('click', () => {
            registerTab.classList.add('active');
            signinTab.classList.remove('active');
            confirmPasswordGroup.style.display = 'block';
            nameGroup.style.display = 'block';
            roleGroup.style.display = 'block';
            submitBtn.textContent = 'REGISTER';
            formAction.value = 'register';
            nameInput.required = true;
            confirmPasswordInput.required = true;
        });

        document.getElementById('auth-form').addEventListener('submit', function(e) {
            const isRegister = registerTab.classList.contains('active');
            if (isRegister) {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirm-password').value;

                if (password !== confirmPassword) {
                    e.preventDefault();
                    alert('Passwords do not match!');
                }
                if (password.length < 6) {
                    e.preventDefault();
                    alert('Password must be at least 6 characters long!');
                }
            }
        });
    </script>
</body>
</html>