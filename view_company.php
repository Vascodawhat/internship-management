<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'supervisor') {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Query to fetch company information
$query = "SELECT id, company_name, company_details FROM companies";
$result = $conn->query($query);

if ($result === false) {
    die('Query failed: ' . htmlspecialchars($conn->error));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Company Information</title>
    <link rel="stylesheet" href="homepage.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="login.php"><img src="uitmlogo.png" alt="UiTM logo"></a>
            <div class="user-info">
                <span><?php echo htmlspecialchars($_SESSION['username']); ?> (Supervisor)</span>
            </div>
        </div>
        <div class="main">
            <div class="sidebar">
                <ul>
                    <li><a href="home_supervisor.php">Home</a></li>
                    <li><a href="view_students.php">View List of Students under supervision</a></li>
                    <li><a href="view_company.php">View company information where his/her student do the intern</a></li>
                </ul>
            </div>
            <div class="content">
                <h2>Company Information</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Company Name</th>
                            <th>Company Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['company_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['company_details']); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
