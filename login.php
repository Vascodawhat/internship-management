<?php
session_start();

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to fetch user details
    $stmt = $conn->prepare("SELECT id, role FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Set session variables
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['role'];
        $_SESSION['company_id'] = $user['id']; // Set the company_id

        if ($user['role'] == 'company') {
            header("Location: home_company.php");
        } else {
            header("Location: login.php");
        }
    } else {
        echo "Invalid username or password.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
        <div class="logo">
        <a href="login.php"><img src="uitmlogo.png" height ="200" width ="300" alt="UiTM Logo"></a>
            </div>
            <form method="POST" action="authenticate.php">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Login</button>
            </form>
            <a href="sign_up.php">First time user? Please register.</a>
        </div>
    </div>
</body>
</html>