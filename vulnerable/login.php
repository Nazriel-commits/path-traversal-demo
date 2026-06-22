<?php
session_start();

$usersFile = "users.txt";
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // If no errors, check credentials
    if (empty($username_err) && empty($password_err)) {
        if (file_exists($usersFile)) {
            $users = file($usersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $found = false;

            foreach ($users as $user) {
                $user = trim($user); // Remove leading/trailing spaces
                list($stored_user, $stored_pass) = explode(":", $user, 2);

                if ($username === $stored_user && $password === $stored_pass) {
                    $_SESSION["loggedin"] = true;
                    $_SESSION["username"] = $username;
                    header("Location: welcome.php");
                    exit;
                }
            }

            $login_err = "Invalid username or password.";
        } else {
            $login_err = "No users registered yet.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Path Traversal Example</title>
    <link rel="stylesheet" href="assets/bootstrap.css">

    <style>
        body {
            background-color: #303030;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: #f2f2f2;
        }

        .login-container {
            background-color: #3b3b3b;
            border-radius: 15px;
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.5);
            width: 380px;
            padding: 35px 30px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 8px;
            color: #ffcc00;
            font-weight: 600;
        }

        .login-container p.title {
            color: #b0b0b0;
            margin-bottom: 25px;
            font-size: 0.95rem;
        }

        .form-label {
            color: #f2f2f2;
        }

        .form-control {
            border-radius: 10px;
            background-color: #4a4a4a;
            border: none;
            color: #f2f2f2;
        }

        .form-control:focus {
            background-color: #444;
            border: 1px solid #ffcc00;
            color: #fff;
            box-shadow: none;
        }

        .btn-primary {
            background-color: #ffcc00;
            color: #1c1c1c;
            border: none;
            border-radius: 10px;
            padding: 10px;
            width: 100%;
            margin-top: 15px;
            font-weight: 600;
            transition: 0.2s;
        }

        .btn-primary:hover {
            background-color: #ffd633;
            transform: scale(1.03);
        }

        .error-text {
            color: #ff6666;
            font-size: 0.9em;
        }

        a {
            text-decoration: none;
            color: #ffcc00;
        }

        a:hover {
            text-decoration: underline;
            color: #ffd633;
        }

        .alert-danger {
            background-color: #661f1f;
            color: #f2f2f2;
            border: none;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Path Traversal Example</h2>
    <p class="title">Login to continue</p>

    <?php if (!empty($login_err)) : ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($login_err); ?></div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="mb-3 text-start">
            <label class="form-label">Username</label>
            <input type="text" name="username" 
                   class="form-control" 
                   value="<?php echo htmlspecialchars($username); ?>">
            <span class="error-text"><?php echo $username_err; ?></span>
        </div>    

        <div class="mb-3 text-start">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control">
            <span class="error-text"><?php echo $password_err; ?></span>
        </div>

        <input type="submit" class="btn btn-primary" value="Login">
    </form>

    <p class="mt-3">Don’t have an account? <a href="register.php">Register here</a>.</p>
</div>

</body>
</html>


