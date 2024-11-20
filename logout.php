<?php

include 'connection.php';

// Check if user is logged in
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];

    // First, check if the user is an admin
    $verify_admin = $connForAccounts->prepare("SELECT email FROM `admin_account` WHERE id = ?");
    $verify_admin->execute([$user_id]);

    if ($verify_admin->rowCount() > 0) {
        // Admin found
        $admin = $verify_admin->fetch(PDO::FETCH_ASSOC);
        $email = $admin['email'];
        $user_type = 'admin';

        // Log the logout action for admin
        $log_stmt = $connForLogs->prepare("INSERT INTO admin_logs (email, activity_type, user_type) VALUES (?, 'Logout', ?)");
        $log_stmt->execute([$email, $user_type]);
    } else {
        // Check if the user is a client (user)
        $verify_client = $connForAccounts->prepare("SELECT email FROM `user_accounts` WHERE id = ?");
        $verify_client->execute([$user_id]);

        if ($verify_client->rowCount() > 0) {
            // Client found
            $client = $verify_client->fetch(PDO::FETCH_ASSOC);
            $email = $client['email'];
            $user_type = 'user';

            // Log the logout action for client
            $log_stmt = $connForLogs->prepare("INSERT INTO user_logs (email, activity_type, user_type) VALUES (?, 'Logout', ?)");
            $log_stmt->execute([$email, $user_type]);
        } else {
            // If the user ID doesn't exist in either table, handle it (e.g., invalid user)
            echo "User not found.";
            exit;
        }
    }
}

// Clear the cookie
setcookie('user_id', '', time() - 1, '/');

// Redirect to landing page
header('Location: index.php');
exit();

?>
