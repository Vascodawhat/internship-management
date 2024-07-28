<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];


$role = $_SESSION['role'];
$username = $_SESSION['username'];

switch ($role) {
    case 'student':
        include 'home_student.php';
        break;
    case 'supervisor':
        include 'home_supervisor.php';
        break;
    case 'company':
        include 'home_company.php';
        break;
    case 'admin':
        include 'home_admin.php';
        break;
    default:
        echo "Invalid role";
        break;
}
?>
