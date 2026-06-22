<?php
session_start();

//Block access if not logged in
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("Location: login.php");
    exit;
}

//Directory where normal files are stored
$baseDir = __DIR__ . "/files/";

//List of admin-only files
$adminFiles = ["secret.txt"];

//List of admin usernames
$admins = ["AdminNaz", "AdminYihang"];

//Initialize variables
$fileContents = "";
$fileName = "";
$message = "";

//Get file parameter from URL
if (isset($_GET['file'])) {
    $file = $_GET['file'];
    $filepath = $baseDir . $file; //vulnerable: no sanitization

    //Admin-only file access check
    if (in_array($file, $adminFiles) && !in_array($_SESSION["username"], $admins)) {
        //Non-admin trying to access admin file -> show only access denied message
        $message = "Access Denied: You do not have permission to view this file.";
    } elseif (file_exists($filepath)) {
        //File exists and allowed -> load contents
        $fileContents = htmlspecialchars(file_get_contents($filepath));
        $fileName = $file;
    } else {
        //File doesn't exist
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
    <title>File Viewer - <?php echo htmlspecialchars($fileName ?: ''); ?></title>
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

        .viewer-container {
            background-color: #3b3b3b;
            padding: 30px 25px 40px 25px;
            border-radius: 15px;
            box-shadow: 0 6px 30px rgba(0,0,0,0.35);
            width: 800px;
            max-width: 95%;
            text-align: center;
            position: relative;
        }

        .message-box {
            background-color: #3b3b3b;
            color: #f2f2f2;
            padding: 18px 20px;
            border-radius: 10px;
            border: 1px solid rgba(255,204,0,0.06);
            margin-bottom: 14px;
        }

        h2.title {
            color: #ffcc00;
            margin-bottom: 15px;
        }

        pre.content {
            background-color: #4a4a4a;
            color: #f2f2f2;
            padding: 15px;
            border-radius: 10px;
            overflow-x: auto;
            text-align: left;
            max-height: 600px;
            white-space: pre-wrap;
            word-wrap: break-word;
            margin-top: 8px;
        }

        .back-btn, .edit-btn {
            position: absolute;
            top: 15px;
            padding: 8px 14px;
            background-color: #ffcc00;
            color: #1c1c1c;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: 0.2s;
        }

        .back-btn { left: 15px; }
        .edit-btn { right: 15px; }

        .back-btn:hover, .edit-btn:hover {
            background-color: #ffd633;
            transform: scale(1.05);
            color: #1c1c1c;
        }

        /*Access-denied style*/
        .access-denied {
            color: #ff6666;
            font-weight: 600;
            font-size: 1.60rem;
        }
    </style>
</head>
<body>

<div class="viewer-container">
    <a href="welcome.php" class="back-btn">&larr; Back</a>

    <!-- Edit button: only visible to admins and only when a file is actually loaded -->
    <?php if (!empty($fileName) && in_array($_SESSION["username"], $admins)) : ?>
        <a href="editfile.php?file=<?php echo urlencode($fileName); ?>" class="edit-btn"> Edit</a>
    <?php endif; ?>

    <!-- If there's a message (errors, no file, access denied) show it prominently -->
    <?php if (!empty($message)) : ?>
        <div class="message-box">
            <?php if (strpos(strtolower($message), 'access') !== false) : ?>
                <div class="access-denied"><?php echo htmlspecialchars($message); ?></div>
            <?php else : ?>
                <div><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Only show the filename + contents if we actually loaded a file -->
    <?php if (!empty($fileName) && $fileContents !== "") : ?>
        <h2 class="title">Showing contents of: <?php echo htmlspecialchars($fileName); ?></h2>
        <pre class="content"><?php echo $fileContents; ?></pre>
    <?php endif; ?>
</div>

</body>
</html>
