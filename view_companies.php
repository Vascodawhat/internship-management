<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Query to fetch companies
$companies_query = "SELECT * FROM companies";
$companies_result = $conn->query($companies_query);

if ($companies_result === false) {
    die('Query failed: ' . htmlspecialchars($conn->error));
}

// Query to fetch students
$students_query = "SELECT students.username AS student_username, companies.company_name, supervisors.username AS supervisor_username
                   FROM students
                   LEFT JOIN companies ON students.company_id = companies.id
                   LEFT JOIN supervisors ON students.supervisor_id = supervisors.id";
$students_result = $conn->query($students_query);

if ($students_result === false) {
    die('Query failed: ' . htmlspecialchars($conn->error));
}

// Query to fetch supervisors
$supervisors_query = "SELECT * FROM supervisors";
$supervisors_result = $conn->query($supervisors_query);

if ($supervisors_result === false) {
    die('Query failed: ' . htmlspecialchars($conn->error));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Companies, Students, and Supervisors</title>
    <link rel="stylesheet" href="homepage.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="login.php"><img src="uitmlogo.png" alt="UiTM logo"></a>
            <div class="user-info">
                <span><?php echo htmlspecialchars($_SESSION['username']); ?> (Admin)</span>
            </div>
        </div>
        <div class="main">
            <div class="sidebar">
                <ul>
                    <li><a href="home_admin.php">Home</a></li>
                    <li><a href="view_companies.php">View Companies, Students, and Supervisors</a></li>
                    <li><a href="assign_supervisor.php">Assign Supervisor to a student</a></li>
                </ul>
            </div>
            <div class="content">
                <h2>Companies</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $companies_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['company_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['company_details']); ?></td>
                        </tr>
                        <?php 
                    
                    } ?>
                    </tbody>
                </table>
                <br>
                <h2>Students</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Supervisor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $students_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['student_username']); ?></td>
                            <td><?php echo htmlspecialchars($row['company_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['supervisor_username']); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <br>
                <h2>Supervisors</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $supervisors_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
