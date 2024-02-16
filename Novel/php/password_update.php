<?php
include 'db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  } 
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (!empty($_POST['old_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
        $oldPassword = $_POST['old_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        // Check if new password matches confirm password
        if ($newPassword !== $confirmPassword) {
            $_SESSION['err'] = "New password and confirm password do not match";
            header("Location: ../account");
            exit;  
        }

        $sql = "SELECT password FROM users WHERE id = :userid";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':userid' => $_SESSION['user_id']));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($oldPassword, $row['password'])) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $sql = "UPDATE users SET password = :password WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $success = $stmt->execute(array(':password' => $hashedPassword, ':id' => $_SESSION['user_id']));

            if ($success) {
                $_SESSION['success'] = "Password has been updated successfully";
                header("Location: ../account");
                exit;  
            } else {
                $_SESSION['err'] = "Something went wrong. Please try again later.";
                header("Location: ../account");
                exit;  
            }
        } else {
            $_SESSION['err'] = "Old password is incorrect";
            header("Location: ../account");
            exit;  
        }
    } else {
        $_SESSION['err'] = "Old, new, and confirm passwords cannot be empty";
        header("Location: ../account");
        exit;  
    }
} else {
    $_SESSION['err'] = "Invalid request method";
    header("Location: ../account");
    exit;
}