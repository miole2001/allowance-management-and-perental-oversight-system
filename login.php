<?php
    // Display errors for debugging
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Database connection
    include 'connection.php';
    include './components/alerts.php';

    $warning_msg = []; // Initialize the warning message array

    if (isset($_POST['submit'])) {
        $email = trim($_POST['email']);
        $pass = trim($_POST['password']);

        if (!empty($email) && !empty($pass)) {
            // Check if the user is an admin
            $verify_admin = $connForAccounts->prepare("SELECT * FROM `admin_account` WHERE email = ? LIMIT 1");
            $verify_admin->execute([$email]);

            if ($verify_admin->rowCount() > 0) {
                // Admin found
                $fetch = $verify_admin->fetch(PDO::FETCH_ASSOC);
                
                // Verify admin password
                if (password_verify($pass, $fetch['password'])) {
                    $action_type = 'Login';

                    // Log admin login activity
                    $log_stmt = $connForLogs->prepare("INSERT INTO admin_logs (email, activity_type, user_type) VALUES (?, ?, 'admin')");
                    $log_stmt->execute([$email, $action_type]);

                    // Set cookie and redirect to admin dashboard
                    setcookie('user_id', $fetch['id'], time() + 60 * 60 * 24 * 30, '/');
                    header('Location: admin/admin.php');
                    exit();
                } else {
                    $warning_msg[] = 'Incorrect admin password!';
                }
            } else {
                // Check if the user is a client (in the client table)
                $verify_client = $connForAccounts->prepare("SELECT * FROM `user_accounts` WHERE email = ? LIMIT 1");
                $verify_client->execute([$email]);

                if ($verify_client->rowCount() > 0) {
                    // Client found
                    $fetch = $verify_client->fetch(PDO::FETCH_ASSOC);
                    
                    // Verify client password
                    if (password_verify($pass, $fetch['password'])) {
                        $action_type = 'Login';

                        // Log client login activity
                        $log_stmt = $connForLogs->prepare("INSERT INTO user_logs (email, activity_type, user_type) VALUES (?, ?, 'user')");
                        $log_stmt->execute([$email, $action_type]);

                        // Set cookie and redirect to client dashboard
                        setcookie('user_id', $fetch['id'], time() + 60 * 60 * 24 * 30, '/');
                        header('Location: user/user.php');
                        exit();
                    } else {
                        $warning_msg[] = 'Incorrect user password!';
                    }
                } else {
                    $warning_msg[] = 'No account found with this email!';
                }
            }
        } else {
            $warning_msg[] = 'Please fill in all fields!';
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