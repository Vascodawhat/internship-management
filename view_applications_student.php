<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Fetch the student ID based on the username
$student_username = $_SESSION['username'];

// Get the student ID from the `students` table
$student_query = "SELECT id FROM students WHERE username = ?";
$student_stmt = $conn->prepare($student_query);
$student_stmt->bind_param("s", $student_username);
$student_stmt->execute();
$student_result = $student_stmt->get_result();
$student_row = $student_result->fetch_assoc();
$student_id = $student_row['id'];

// Fetch the applications for the logged-in student
$query = "SELECT 
            internship_jobs.job_title, 
            companies.company_name, 
            applications.status 
          FROM 
            applications 
          JOIN 
            internship_jobs ON applications.job_id = internship_jobs.id 
          JOIN 
            companies ON internship_jobs.company_id = companies.id 
          WHERE 
            applications.student_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Application Status</title>
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
                <span><?php echo htmlspecialchars($student_username); ?> (Student)</span>
            </div>
        </div>
        <div class="main">
            <div class="sidebar">
                <ul>
                    <li><a href="home_student.php">Home</a></li>
                    <li><a href="view_jobs.php">View Internship Jobs</a></li>
                    <li><a href="view_applications_student.php">View Application Status</a></li>
                </ul>
            </div>
            <div class="content">
                <h2>Your Internship Applications</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Job Title</th>
                            <th>Company</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['job_title']); ?></td>
                            <td><?php echo htmlspecialchars($row['company_name']); ?></td>
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
