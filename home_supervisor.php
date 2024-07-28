<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - Supervisor</title>
    <link rel="stylesheet" href="homepage.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="login.php"><img src="uitmlogo.png" alt="UiTM logo"></a>
            <div class="user-info">
                <span><?php echo $username; ?> (Supervisor)</span>
            </div>
        </div>
        <div class="main">
            <div class="sidebar">
                <ul>
                <li><a href="view_students.php">View List of Students under supervision</a></li>
                <li><a href="view_company.php">View company information where his/her student do the intern</a></li>
                </ul>
            </div>
            <div class="content">
                <h2>Welcome, <?php echo $username; ?>!</h2>
                <p>You can view students under your supervision and their internship details here.</p>
            </div>
        </div>
    </div>
</body>
</html>
