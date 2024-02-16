<?php
session_start();

require 'vendor/autoload.php'; // Include PHPMailer autoload file

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('../php/db.php');

// Handle signup form submission

$response = ["success" => false, "message" => ""];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["passwordSignup"], PASSWORD_DEFAULT);
    $verificationCode = md5(uniqid(rand(), true)); // Generate a unique verification code

   // Check if email already exists
   $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
   $stmt->bindParam(':email', $email);
   $stmt->execute();
   $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

   if ($existingUser) {
      $_SESSION["Signup_err"] = "Email already exists.";

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
            $mail->Body =  '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Email Verification</title>
                <style>
                    /* Reset CSS */
                    body, table, td, a {
                        font-family: Arial, sans-serif;
                        font-size: 14px;
                        color: #333333;
                    }

                    /* Container */
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                        border: 1px solid #eaeaea;
                        border-radius: 10px;
                        background-color: #f9f9f9;
                    }

                    /* Logo */
                    .logo {
                        text-align: center;
                        margin-bottom: 20px;
                    }

                    .logo img {
                        width: 150px;
                        height: auto;
                    }

                    /* Message */
                    .message {
                        margin-bottom: 20px;
                        text-align: center;
                    }

                    /* Button */
                    .button {
                        display: inline-block;
                        padding: 10px 20px;
                        background-color: #007bff;
                        color: #ffffff;
                        text-decoration: none;
                        border-radius: 5px;
                    }

                    /* Responsive styles */
                    @media screen and (max-width: 600px) {
                        .container {
                            width: 100%;
                            border-radius: 0;
                        }

                        .logo img {
                            width: 100%;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="logo">
                        <img src="https://boxnovel.com/wp-content/uploads/2018/04/BoxNovelNEW.png" alt="Logo">
                    </div>
                    <div class="message">
                        <p>Dear '.$username.',</p>
                        <p>Please click the button below to verify your email address:</p>
                        <a href="http://172.190.104.119:8000/includes/verify.php?code='.$verificationCode.'" class="button">Verify Email</a>
                    </div>
                </div>
            </body>
            </html>

        ';
            $mail->send();

            $_SESSION["Signup"]="Signup successful! Please check your email to verify your account.";
                      
          
        } catch (Exception $e) {
            $_SESSION["Signup_err"] = "Error: Signup failed.";  
     }

    } 

}

}

$redirect_url = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : '/index.php';
header("Location: " . $redirect_url);
exit();

?> 