<?php
session_start();

// Redirect if not logged in
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome - Path Traversal Example</title>
    <link rel="stylesheet" href="assets/bootstrap.css">

    <style>
        body {
            background-color: #303030; /* softer dark gray background */
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            color: #f2f2f2;
        }

        .dashboard-container {
            background-color: #3b3b3b; /* container slightly lighter gray */
            border-radius: 15px;
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.35);
            width: 450px;
            padding: 40px 35px;
            text-align: center;
            position: relative;
        }

        .logout-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 6px 12px;
            font-size: 0.9rem;
            background-color: #ffcc00;
            border: none;
            color: #1c1c1c;
            border-radius: 8px;
            transition: 0.2s;
        }

        .logout-btn:hover {
            background-color: #ffd633;
            transform: scale(1.05);
            color: #1c1c1c;
        }

        h2 {
            color: #ffcc00; /* yellow accent for greeting */
            font-weight: 600;
            margin-bottom: 5px;
        }

        p.subtitle {
            color: #b0b0b0;
            margin-bottom: 30px;
        }

        .file-list {
            list-style-type: none;
            padding: 0;
            margin: 0 auto 20px;
        }

        .file-list li {
            margin-bottom: 12px;
        }

        .file-link {
            display: block;
            background-color: #ffcc00;
            color: #1c1c1c;
            padding: 12px 0;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 500;
            transition: 0.2s ease;
        }

        .file-link:hover,
        .file-link:focus,
        .file-link:active { 
            background-color: #ffd633;
            color: #1c1c1c;
            transform: scale(1.03);
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <a href="logout.php" class="logout-btn">Logout</a>

    <h2>Hi, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h2>
    <p class="subtitle">Select a file to view:</p>

    <ul class="file-list">
        <li><a href="fileviewer.php?file=welcome.txt" class="file-link">welcome.txt</a></li>
        <li><a href="fileviewer.php?file=about.txt" class="file-link">about.txt</a></li>
        <li><a href="fileviewer.php?file=notes.txt" class="file-link">notes.txt</a></li>
        <li><a href="fileviewer.php?file=attacks.txt" class="file-link">attacks.txt</a></li>
        <li><a href="fileviewer.php?file=secret.txt" class="file-link">secret.txt</a></li>
    </ul>
</div>

</body>
</html>


