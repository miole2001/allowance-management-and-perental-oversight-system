<?php
// to display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// database connection
include 'connection.php';

include ('./components/alerts.php');

$warning_msg = [];
$success_msg = [];

if (isset($_POST['submit'])) {

    $image = $_FILES['image']['name'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $c_pass = password_verify($_POST['confirm-password'], $pass);

    $verify_email = $connForAccounts->prepare("SELECT * FROM `user_accounts` WHERE email = ?");
    $verify_email->execute([$email]);

    if ($verify_email->rowCount() > 0) {
        $warning_msg[] = 'Email already taken!';
    } else {
        if ($c_pass == 1) {
            $insert_user = $connForAccounts->prepare("INSERT INTO `user_accounts`(image, name, email, password, user_type) VALUES(?,?,?,?,'user')");
            $insert_user->execute([$image, $name, $email, $pass]);
            $success_msg[] = 'Registered successfully!';
            // Redirect after the alert is shown
            echo '<script>setTimeout(function() { window.location.href = "login.php"; }, 2000);</script>';
        } else {
            $warning_msg[] = 'Confirm password not matched!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form | AM&POS</title> 
    <link rel="stylesheet" href="css/login.css">
   </head>
<body>
    <div class="wrapper">
        <h2>Registration</h2>
        <form action="#" method="POST" enctype="multipart/form-data">
            <div class="input-box">
                <input type="file" name="image" placeholder="Enter your name" required>
            </div>
            <div class="input-box">
                <input type="text" name="name" placeholder="Enter your name" required>
            </div>
            <div class="input-box">
                <input type="text" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Create password" required>
            </div>
            <div class="input-box">
                <input type="password" name="confirm-password" placeholder="Confirm password" required>
            </div>
            <div class="input-box button">
                <input type="Submit" name="submit" value="Register Now">
            </div>
            <div class="text">
                <h3>Already have an account? <a href="login.php">Login now</a></h3>
            </div>
        </form>
    </div>
</body>
</html>