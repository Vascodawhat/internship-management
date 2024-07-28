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
    <title>Home - Company</title>
    <link rel="stylesheet" href="homepage.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="login.php"><img src="uitmlogo.png" alt="UiTM logo"></a>
            <div class="user-info">
                <span><?php echo $username; ?> (Company)</span>
            </div>
        </div>
        <div class="main">
            <div class="sidebar">
                <ul>
                    <li><a href="add_job.php">Add Internship Job</a></li>
                    <li><a href="view_applications_company.php">View Applications</a></li>
                </ul>
            </div>
            <div class="content">
                <h2>Welcome, <?php echo $username; ?>!</h2>
                <p>This is your home page.</p>
            </div>
        </div>
    </div>
</body>
</html>

