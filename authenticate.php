<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user details
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'supervisor') {
            // Check if a supervisor record exists for this user
            $supervisor_stmt = $conn->prepare("SELECT * FROM supervisors WHERE username = ?");
            $supervisor_stmt->bind_param("s", $username);
            $supervisor_stmt->execute();
            $supervisor_result = $supervisor_stmt->get_result();
            $supervisor = $supervisor_result->fetch_assoc();

            if (!$supervisor) {
                // Insert a new supervisor record if it does not exist
                $insert_stmt = $conn->prepare("INSERT INTO supervisors (username) VALUES (?)");
                $insert_stmt->bind_param("s", $username);
                $insert_stmt->execute();
                
                // Retrieve the new supervisor record to get the ID
                $supervisor_id = $conn->insert_id;
                $_SESSION['supervisor_id'] = $supervisor_id;
            } else {
                $_SESSION['supervisor_id'] = $supervisor['id'];
            }
            
            header("Location: home_supervisor.php");
        } elseif ($user['role'] == 'student') {
            // Check if a student record exists for this user
            $student_stmt = $conn->prepare("SELECT * FROM students WHERE username = ?");
            $student_stmt->bind_param("s", $username);
            $student_stmt->execute();
            $student_result = $student_stmt->get_result();
            $student = $student_result->fetch_assoc();

            if (!$student) {
                // Insert a new student record if it does not exist
                $insert_stmt = $conn->prepare("INSERT INTO students (username) VALUES (?)");
                $insert_stmt->bind_param("s", $username);
                $insert_stmt->execute();
                
                // Retrieve the new student record to get the ID
                $student_id = $conn->insert_id;
                $_SESSION['student_id'] = $student_id;
            } else {
                $_SESSION['student_id'] = $student['id'];
            }

            header("Location: home_student.php");
        } elseif ($user['role'] == 'company') {
            // Check if a company record exists for this user
            $company_stmt = $conn->prepare("SELECT * FROM companies WHERE user_id = ?");
            $company_stmt->bind_param("i", $user['id']);
            $company_stmt->execute();
            $company_result = $company_stmt->get_result();
            $company = $company_result->fetch_assoc();

            if (!$company) {
                // Insert a new company record if it does not exist
                $insert_stmt = $conn->prepare("INSERT INTO companies (user_id, name) VALUES (?, ?)");
                $company_name = $username; // Assuming the company name is the same as the username
                $insert_stmt->bind_param("is", $user['id'], $company_name);
                $insert_stmt->execute();
                
                // Retrieve the new company record to get the ID
                $company_id = $conn->insert_id;
                $_SESSION['company_id'] = $company_id;
            } else {
                $_SESSION['company_id'] = $company['id'];
            }
            
            header("Location: home_company.php");
        } else {
            // Handle other roles or redirect to a general home page
            header("Location: home.php");
        }
    } else {
        echo "Invalid username or password";
    }
}
?>
