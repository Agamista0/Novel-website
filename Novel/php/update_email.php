<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  } 
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

if (!empty($_POST['NewEmail'])) {
   $newEmail = $_POST['NewEmail'];
   $sql = "UPDATE users SET email = :email WHERE id = :id";
   $stmt = $pdo->prepare($sql);
   if ($stmt->execute(array(':email' => $newEmail, ':id' => $_SESSION['user_id']))) {
        $_SESSION['email'] =$newEmail ;
       $_SESSION['success'] = "Email Has Been Updated Successfully";
       header("Location: ../account");
       exit;  
   } else {
       $_SESSION['err'] = "Something happened. Please try again later.";
       header("Location: ../account");
       exit;  
   }
}}
else {
    $_SESSION['err'] = "Invalid request method";
    header("Location: ../account.");
    exit;
}
?>
