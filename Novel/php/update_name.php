<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  } 
include 'db.php';
  
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    if (!empty($_POST['newname'])) {
        $newName = $_POST['newname'];
        $sql = "UPDATE users SET username = :username WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute(array(':username' => $newName, ':id' => $_SESSION['user_id']))) {
            $_SESSION['username'] =$newName ;
            $_SESSION['success'] = "Username Has Been Updated Successfully";
            header("Location: ../account.php");
            exit;  
        } else {
            $_SESSION['err'] = "Something happened. Please try again later.";
            header("Location: ../account.php");
            exit;  
        }
    }}
    else {
        $_SESSION['err'] = "Invalid request method";
        header("Location: ../account.php");
        exit;
    }
    ?>
    