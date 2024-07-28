<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $supervisor_id = $_POST['supervisor_id'];

    // Perform necessary validation and sanitization here

    // Update the student's supervisor in the database
    $stmt = $conn->prepare("UPDATE students SET supervisor_id = ? WHERE id = ?");
    $stmt->bind_param("ii", $supervisor_id, $student_id);

    if ($stmt->execute()) {
        echo "Supervisor assigned successfully.";
    } else {
        echo "Error assigning supervisor: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assign Supervisor</title>
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
                    <li><a href="assign_supervisor.php">Assign Supervisor</a></li>
                    <li><a href="view_supervisors.php">View Supervisors</a></li>
                </ul>
            </div>
            <div class="content">
                <h2>Assign Supervisor to Student</h2>
                <form method="post" action="assign_supervisor.php">
                    <label for="student_id">Student ID:</label>
                    <input type="text" id="student_id" name="student_id" required><br><br>
                    <label for="supervisor_id">Supervisor ID:</label>
                    <input type="text" id="supervisor_id" name="supervisor_id" required><br><br>
                    <input type="submit" value="Assign Supervisor">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
