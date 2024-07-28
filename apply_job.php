<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['job_id'])) {
    $job_id = intval($_GET['job_id']);
    $student_id = $_SESSION['student_id']; // Ensure this is correctly set in the session

    // Check if the job exists
    $stmt = $conn->prepare("SELECT * FROM internship_jobs WHERE id = ?");
    $stmt->bind_param("i", $job_id);
    $stmt->execute();
    $job = $stmt->get_result()->fetch_assoc();

    if ($job) {
        // Insert application record
        $stmt = $conn->prepare("INSERT INTO applications (student_id, job_id, status) VALUES (?, ?, 'pending')");
        $stmt->bind_param("ii", $student_id, $job_id);
        if ($stmt->execute()) {
            echo "Applied successfully!";
        } else {
            echo "Error applying for job: " . $stmt->error;
        }
    } else {
        echo "Job not found.";
    }
} else {
    echo "No job ID provided.";
}
?>
