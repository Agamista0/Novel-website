<?php
session_start();

require_once('../php/db.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT id, username, password, is_verified, email , profile_image FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC); 

    if ($user && password_verify($password, $user['password'])) {

        if ($user['is_verified']) {
            $_SESSION["user_id"] = $user['id'];
            $_SESSION["username"] = $user['username'];
            $_SESSION["email"] = $user['email'];
            $_SESSION['profileimg']= $user['profile_image'];


            // Use PDO prepared statements for the user_settings query
            $stmtUserSettings = $pdo->prepare("SELECT site_schema, reading_style, images_per_page FROM user_settings WHERE user_id = :id");
            $stmtUserSettings->bindParam(':id', $user['id'], PDO::PARAM_INT); // Add PDO::PARAM_INT for integer parameters
            $stmtUserSettings->execute();
            $userSettings = $stmtUserSettings->fetch(PDO::FETCH_ASSOC);

            // Bind the results to session variables
            $_SESSION['siteSchema'] = $userSettings['site_schema'];
            $_SESSION['readingStyle'] = $userSettings['reading_style'];
            $_SESSION['imagesPerPage'] = $userSettings['images_per_page'];

            $stmtUserSettings->closeCursor(); // Close the statement

            

        } else {
            $_SESSION["err"] =  "Email not verified. Please verify your email before logging in.";
        }
    } else {
        $_SESSION["err"] = "Invalid username or password";
    }
}

header("Location: /index.php");
exit();

?>