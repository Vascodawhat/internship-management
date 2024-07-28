<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'company') {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Fetch the company information from the session
$company_id = $_SESSION['company_id'];

// Validate company_id
if (!filter_var($company_id, FILTER_VALIDATE_INT)) {
    die('Invalid company ID.');
}

// Debug: Check the company_id value
error_log("Company ID: " . $company_id);

// Query to fetch applications related to the company
$query = "SELECT 
            students.username AS student_username, 
            internship_jobs.job_title, 
            applications.status 
          FROM 
            applications 
          JOIN 
            internship_jobs ON applications.job_id = internship_jobs.id 
          JOIN 
            companies ON internship_jobs.company_id = companies.id 
          JOIN 
            students ON applications.student_id = students.id 
          WHERE 
            companies.id = ?";

$stmt = $conn->prepare($query);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$stmt->bind_param("i", $company_id);
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
    <title>View Applications for Company</title>
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
                <span><?php echo htmlspecialchars($_SESSION['username']); ?> (Company)</span>
            </div>
        </div>
        <div class="main">
            <div class="sidebar">
                <ul>
                    <li><a href="home_company.php">Home</a></li>
                    <li><a href="add_job.php">Add Internship Job</a></li>
                    <li><a href="view_applications_company.php">View Applications</a></li>
                </ul>
            </div>
            <div class="content">
                <h2>Applications for Company</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Student Username</th>
                            <th>Job Title</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['student_username']); ?></td>
                            <td><?php echo htmlspecialchars($row['job_title']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
