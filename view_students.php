<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'supervisor') {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Query to fetch students under supervision, their companies, and supervisors
$query = "
    SELECT students.username AS student_username, 
           companies.name, 
           supervisors.username AS supervisor_username
    FROM students
    LEFT JOIN companies ON students.company_id = companies.id
    LEFT JOIN supervisors ON students.supervisor_id = supervisors.id
    WHERE supervisors.username = ?";
    
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    die('Query failed: ' . htmlspecialchars($conn->error));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Students</title>
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
                <h2>Students Under Supervision</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Company</th>
                            <th>Supervisor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['student_username']); ?></td>
                            <td><?php echo htmlspecialchars($row['company_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['supervisor_username']); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
