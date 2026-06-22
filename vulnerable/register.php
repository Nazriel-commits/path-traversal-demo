<?php
session_start();

$usersFile = "users.txt"; // flat file storage

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        $username = trim($_POST["username"]);

        // Check if user already exists
        if (file_exists($usersFile)) {
            $users = file($usersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($users as $user) {
                list($stored_user, $stored_pass) = explode(":", $user);
                if ($username === $stored_user) {
                    $username_err = "This username is already taken.";
                    break;
                }
            }
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if ($password !== $confirm_password) {
            $confirm_password_err = "Passwords do not match.";
        }
    }

    // If no errors, save user to users.txt
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        $userData = $username . ":" . md5($password) . "\n";
        file_put_contents($usersFile, $userData, FILE_APPEND | LOCK_EX);
        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Path Traversal Example</title>
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
            margin: 0;
        }

        .register-container {
            background-color: #3b3b3b;
            border-radius: 15px;
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.35);
            width: 400px;
            padding: 35px 30px;
            text-align: center;
        }

        .register-container h2 {
            margin-bottom: 8px;
            color: #ffcc00;
            font-weight: 600;
        }

        .register-container p.title {
            color: #b0b0b0;
            margin-bottom: 25px;
            font-size: 0.95rem;
        }

        .form-label {
            color: #f2f2f2;
            text-align: left;
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
        }

        .form-control {
            border-radius: 10px;
            background-color: #4a4a4a;
            border: none;
            color: #f2f2f2;
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 10px;
        }

        .form-control:focus {
            background-color: #555;
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
            margin-top: 10px;
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
            display: block;
            text-align: left;
            margin-bottom: 10px;
        }

        a {
            text-decoration: none;
            color: #ffcc00;
        }

        a:hover {
            text-decoration: underline;
            color: #ffd633;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2>Create Account</h2>
    <p class="title">Please fill this form to register.</p>

    <form action="" method="post">
        <div class="text-start">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control"
                   value="<?php echo htmlspecialchars($username); ?>">
            <span class="error-text"><?php echo $username_err; ?></span>
        </div>

        <div class="text-start">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control">
            <span class="error-text"><?php echo $password_err; ?></span>
        </div>

        <div class="text-start">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control">
            <span class="error-text"><?php echo $confirm_password_err; ?></span>
        </div>

        <input type="submit" class="btn btn-primary" value="Register">
    </form>

    <p class="mt-3">Already have an account? <a href="login.php">Login here</a>.</p>
</div>

</body>
</html>
