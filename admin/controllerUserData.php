<?php

require_once 'includes/firebaseRDB.php';
require_once 'includes/config.php'; // Include the config file

// Initialize Firebase
$firebase = new firebaseRDB($databaseURL);

$email = "";
$errors = array();

function debug_log($message) {
    error_log(print_r($message, true));
}

if (isset($_POST['check-email'])) {
    debug_log("Form submitted");
    $email = $_POST['email'];
    debug_log("Email submitted: " . $email);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format!";
    } else {
        // Fetch user data from Firebase
        $data = $firebase->retrieve("admin");
        debug_log("Data retrieved from Firebase:");
        debug_log($data);

        $admin = json_decode($data, true);

        if ($admin && isset($admin['email']) && $admin['email'] === $email) {
            $token = bin2hex(random_bytes(16));
            $token_hash = hash("sha256", $token);
            $expiry = date("Y-m-d H:i:s", time() + 60 * 30); // 30 minutes expiry

            // Update the user's reset token and expiration in Firebase
            $admin["reset_token_hash"] = $token_hash;
            $admin["reset_token_expires_at"] = $expiry;

            $updateResult = $firebase->update("admin", null, $admin);
            debug_log("Update result:");
            debug_log($updateResult);

            // Send email with reset link
            $subject = "Password Reset";
            $message = <<<END
            Click <a href="https://mccalumnitracker.com/admin/new-password.php?token=$token">here</a> to reset your password.
            END;
            $sender = "From: johnchristianfariola@gmail.com";

            // Assuming $mail is already set up in mailer.php
            $mail = require __DIR__ . "/mailer.php";
            $mail->setFrom("noreply@example.com");
            $mail->addAddress($email);
            $mail->Subject = $subject;
            $mail->Body = $message;

            try {
                if ($mail->send()) {
                    $info = "We've sent a password reset code to your email - $email";
                    $_SESSION['info'] = $info;
                    $_SESSION['email'] = $email;
                    header('location: index.php'); // Redirect to index.php instead of reset-code.php
                    exit();
                } else {
                    $errors['otp-error'] = "Failed while sending code!";
                }
            } catch (Exception $e) {
                $errors['otp-error'] = "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
            }
        } else {
            $errors['email'] = "This email address does not exist!";
        }
    }
}

if (isset($_POST['change-password'])) {
    $_SESSION['info'] = "";
    $token = $_POST["token"];
    $token_hash = hash("sha256", $token);

    // Fetch the admin data from Firebase
    $data = $firebase->retrieve("admin");
    $admin = json_decode($data, true);

    debug_log("Admin data retrieved for password change:");
    debug_log($admin);

    if (!$admin || !isset($admin['reset_token_hash']) || $admin['reset_token_hash'] !== $token_hash) {
        $errors['token'] = "Token not found or invalid";
    } else {
        if (isset($admin["reset_token_expires_at"]) && strtotime($admin["reset_token_expires_at"]) <= time()) {
            $errors['token'] = "Token has expired";
        } elseif (strlen($_POST["password"]) < 8) {
            $errors['password'] = "Password must be at least 8 characters";
        } elseif (!preg_match("/[a-z]/i", $_POST["password"])) {
            $errors['password'] = "Password must contain at least one letter";
        } elseif (!preg_match("/[0-9]/", $_POST["password"])) {
            $errors['password'] = "Password must contain at least one number";
        } elseif ($_POST["password"] !== $_POST["password_confirmation"]) {
            $errors['password'] = "Passwords must match";
        } else {
            $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

            // Update the user's password in Firebase and clear reset token
            $admin["password"] = $password_hash;
            $admin["reset_token_hash"] = null;
            $admin["reset_token_expires_at"] = null;

            $updateResult = $firebase->update("admin", null, $admin);
            debug_log("Password update result:");
            debug_log($updateResult);

            $_SESSION['info'] = "Your password has been changed. Now you can log in with your new password.";
            header('Location: index.php');
            exit();
        }
    }
}

// Display errors if any
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color: red;'>$error</p>";
    }
}
?>
    