<?php

require 'vendor/autoload.php'; // Include PHPMailer autoload file

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('../php/db.php');

// Handle signup form submission

$response = ["success" => false, "message" => ""];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $verificationCode = md5(uniqid(rand(), true)); // Generate a unique verification code

   // Check if email already exists
   $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
   $stmt->bindParam(':email', $email);
   $stmt->execute();
   $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

   if ($existingUser) {
    $_SESSION["err"] = "Email already exists.";
    header("Location: /index.php");
    exit();

   } else {
       // Insert user into database with is_verified set to 0
       $sql = "INSERT INTO users (username, email, password, verification_code) VALUES (?, ?, ?, ?)";
       $stmt = $pdo->prepare($sql);
       $stmt->execute([$username, $email, $password, $verificationCode]); 


       if ($stmt->rowCount() > 0) {
        
        // Send verification email using PHPMailer

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Your SMTP server
            $mail->SMTPAuth   = true;
            $mail->Username   = 'yousefmyiu@gmail.com';
            $mail->Password   = 'cumh hxjv fwmh wbuy';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;   // Set to 465 for SSL

            $mail->setFrom('yousefmyiu@gmail.com'); // Gmail address which you used as SMTP server  
            $mail->addAddress($email, $username);
            
            $mail->isHTML(true);
            $mail->Subject = 'Email Verification';
            $mail->Body    = "Click the following link to verify your email: http://localhost:8000/includes/verify.php?code=$verificationCode";

            $mail->send();

            $_SESSION["success"]="Signup successful! Please check your email to verify your account.";
                      
            header("Location: /index.php");
            exit();

        } catch (Exception $e) {
            $_SESSION["err"] = "Error: Signup failed.";  
     }
    } 

}
}


?> 