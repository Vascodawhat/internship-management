<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Updated SQL query to join with the companies table
$query = "
    SELECT 
        internship_jobs.id,
        internship_jobs.job_title,
        internship_jobs.description AS job_description,
        companies.name AS company_name
    FROM 
        internship_jobs
    JOIN 
        companies ON internship_jobs.company_id = companies.id
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Internship Jobs</title>
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
                <span><?php echo $_SESSION['username']; ?> (Student)</span>
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
                <h2>Available Internship Jobs</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Job Title</th>
                            <th>Company</th>
                            <th>Description</th>
                            <th>Apply</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['job_title']; ?></td>
                            <td><?php echo $row['company_name']; ?></td>
                            <td><?php echo $row['job_description']; ?></td>
                            <td><a href="apply_job.php?job_id=<?php echo $row['id']; ?>">Apply</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
