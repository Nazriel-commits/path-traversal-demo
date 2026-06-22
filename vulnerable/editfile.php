<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("Location: login.php");
    exit;
}

$admins = ["AdminNaz", "AdminYihang"];
$baseDir = __DIR__ . "/files/";

$fileName = "";
$fileContents = "";
$message = "";

// deny access to non-admins
if (!in_array($_SESSION["username"], $admins)) {
    die("Access denied: You are not authorized to edit files.");
}

if (isset($_GET["file"])) {
    $file = $_GET["file"];
    $filePath = $baseDir . $file; // vulnerable (no sanitization)

    if (file_exists($filePath)) {
        $fileName = $file;

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["newcontent"])) {
            $newContent = $_POST["newcontent"];
            file_put_contents($filePath, $newContent);
            $message = "File successfully updated!";
        }

        $fileContents = htmlspecialchars(file_get_contents($filePath));
    } else {
        $message = "File not found!";
    }
} else {
    $message = "No file specified.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit File - <?php echo htmlspecialchars($fileName); ?></title>
    <link rel="stylesheet" href="assets/bootstrap.css">
    <style>
        body {
            background-color: #303030;
            color: #f2f2f2;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .editor-container {
            background-color: #3b3b3b;
            padding: 35px 30px 45px 30px;
            border-radius: 15px;
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.35);
            width: 800px;
            max-width: 95%;
            text-align: center;
            position: relative;
        }

        h2 {
            color: #ffcc00;
            margin-bottom: 15px;
        }

        textarea {
            width: 100%;
            height: 400px;
            background-color: #4a4a4a;
            color: #f2f2f2;
            border: none;
            border-radius: 10px;
            padding: 15px;
            resize: vertical;
            font-family: monospace;
            font-size: 0.95rem;
        }

        textarea:focus {
            outline: none;
            border: 1px solid #ffcc00;
            background-color: #555;
        }

        .save-btn {
            background-color: #ffcc00;
            color: #1c1c1c;
            border: none;
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 600;
            transition: 0.2s;
            margin-top: 15px;
        }

        .save-btn:hover {
            background-color: #ffd633;
            transform: scale(1.05);
        }

        .message {
            margin-top: 10px;
            color: #ffcc00;
        }

        .back-btn {
            position: absolute;
            top: 15px;
            left: 15px;
            padding: 8px 14px;
            background-color: #ffcc00;
            color: #1c1c1c;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: 0.2s;
        }

        .back-btn:hover {
            background-color: #ffd633;
            transform: scale(1.05);
            color: #1c1c1c;
        }
    </style>
</head>
<body>

<div class="editor-container">
    <a href="welcome.php" class="back-btn">&larr; Back</a>
    <h2>Editing: <?php echo htmlspecialchars($fileName); ?></h2>

    <?php if (!empty($message)): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="post">
        <textarea name="newcontent"><?php echo $fileContents; ?></textarea>
        <br>
        <button type="submit" class="save-btn">Save Changes</button>
    </form>
</div>

</body>
</html>

