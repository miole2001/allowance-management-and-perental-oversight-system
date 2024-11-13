<?php
// to display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// database connection
include 'connection.php';

include ('./components/alerts.php');


$warning_msg = []; // Initialize the warning message array

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    // Prepare SQL statement to fetch user by email
    $verify_user = $connForAccounts->prepare("SELECT * FROM `user_accounts` WHERE email = ? LIMIT 1");
    $verify_user->execute([$email]);

    if ($verify_user->rowCount() > 0) {
        $fetch = $verify_user->fetch(PDO::FETCH_ASSOC);
        $user_type = $fetch['user_type'];
        $action_type = 'Login';

        // Log the attempt
        if ($user_type === 'admin') {
            $log_stmt = $connForLogs->prepare("INSERT INTO admin_logs (email, activity_type, user_type) VALUES (?, ?, ?)");
            $log_stmt->execute([$email, $action_type, $user_type]);
            setcookie('user_id', $fetch['id'], time() + 60 * 60 * 24 * 30, '/');
            if ($verify_user) {
                header('Location: admin/admin.php');
                exit();
            }
        } else if ($user_type === 'user'){
            $log_stmt = $connForLogs->prepare("INSERT INTO user_logs (email, activity_type, user_type) VALUES (?, ?, ?)");
            $log_stmt->execute([$email, $action_type, $user_type]);
            if ($verify_user) {
                setcookie('user_id', $fetch['id'], time() + 60 * 60 * 24 * 30, '/');
                header('Location: user/user.php');
                exit();
            }
        } else {

        }
            } else {
        $warning_msg[] = 'Incorrect email!';
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form | AM&POS</title> 
    <link rel="stylesheet" href="css/login.css">
   </head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <form action="#" method="POST">
            <div class="input-box">
                <input type="text" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Create password" required>
            </div>
            <div class="input-box button">
                <input type="submit" name="submit" value="Login">
            </div>
            <div div class="text">
                <h3>Don't have an account? <a href="register.php">Login now</a></h3>
            </div>
        </form>
    </div>
</body>
</html>