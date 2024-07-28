<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'company') {
    header("Location: login.php");
    exit();
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $job_title = $_POST['job_title'];
    $description = $_POST['description'];
    $company_id = $_SESSION['company_id']; // Ensure this is set in the session

    if ($company_id) {
        $stmt = $conn->prepare("INSERT INTO internship_jobs (job_title, description, company_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $job_title, $description, $company_id);

        if ($stmt->execute()) {
            echo "Job added successfully.";
        } else {
            echo "Error adding job: " . $stmt->error;
        }
    } else {
        echo "Company ID is not set.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Internship Job</title>
    <link rel="stylesheet" href="homepage.css">
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
                <h2>Add Internship Job</h2>
                <form method="post" action="add_job.php">
                    <label for="job_title">Job Title:</label>
                    <input type="text" id="job_title" name="job_title" required><br><br>
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required></textarea><br><br>
                    <input type="submit" value="Add Job">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
