<?php
// Display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connection.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];

    $verify_admin = $connForAccounts->prepare("SELECT email FROM `admin_account` WHERE id = ?");
    $verify_admin->execute([$user_id]);
    
    if ($verify_admin->rowCount() > 0) {
        $admin = $verify_admin->fetch(PDO::FETCH_ASSOC);
        $email = $admin['email'];
        $user_type = 'admin';

        // Log admin logout
        $log_stmt = $connForLogs->prepare("INSERT INTO admin_logs (email, activity_type, user_type) VALUES (?, 'Logout', ?)");
        $log_stmt->execute([$email, $user_type]);

    } else {
        // Check parent table
        $verify_parent = $connForAccounts->prepare("SELECT email FROM `user_accounts` WHERE id = ?");
        $verify_parent->execute([$user_id]);
        
        if ($verify_parent->rowCount() > 0) {
            $parent = $verify_parent->fetch(PDO::FETCH_ASSOC);
            $email = $parent['email'];
            $user_type = 'parent';

            // Log parent logout
            $log_stmt = $connForLogs->prepare("INSERT INTO user_logs (email, activity_type, user_type) VALUES (?, 'Logout', ?)");
            $log_stmt->execute([$email, $user_type]);

        } else {
            // Check student table
            $verify_student = $connForAccounts->prepare("SELECT email FROM `student_accounts` WHERE id = ?");
            $verify_student->execute([$user_id]);

            if ($verify_student->rowCount() > 0) {
                $student = $verify_student->fetch(PDO::FETCH_ASSOC);
                $email = $student['email'];
                $user_type = 'student';

                // Log student logout
                $log_stmt = $connForLogs->prepare("INSERT INTO user_logs (email, activity_type, user_type) VALUES (?, 'Logout', ?)");
                $log_stmt->execute([$email, $user_type]);
            }
        }
    }
}

// Clear the cookie
setcookie('user_id', '', time() - 1, '/');

// Redirect to login page
header('Location: index.php');
exit();

?>
