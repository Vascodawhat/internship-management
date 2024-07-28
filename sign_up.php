<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
    <div class="logo">
                <img src="uitmlogo.png" height ="200" width ="300" alt="UiTM Logo">
            </div>
        <form action="register.php" method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Repeat Password" required>
            <select name="role" required>
                <option value="student">Student</option>
                <option value="supervisor">Supervisor</option>
                <option value="company">Company</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</body>
</html>
