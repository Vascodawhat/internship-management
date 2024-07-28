<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'config.php';

$query = "SELECT * FROM supervisors";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Supervisors</title>
    <link rel="stylesheet" href="homepage.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="login.php"><img src="uitmlogo.png" alt="UiTM logo"></a>
            <div class="user-info">
                <span><?php echo $_SESSION['username']; ?> (Admin)</span>
            </div>
        </div>
        <div class="main">
            <div class="sidebar">
                <ul>
                    <li><a href="home_admin.php">Home</a></li>
                    <li><a href="view_supervisors.php">View Supervisors</a></li>
                </ul>
            </div>
            <div class="content">
                <h2>List of Supervisors</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo htmlspecialchars($row['email'] ? $row['email'] : 'No email available'); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
