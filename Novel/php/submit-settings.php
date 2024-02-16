<?php
include "db.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  } 
$userId = $_SESSION["user_id"];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $siteSchema = $_POST['Site_Schema'];
    $readingStyle = $_POST['Reading_Style'];
    $imagesPerPage = $_POST['images_per_page'];

    $sql_check = "SELECT COUNT(*) FROM user_settings WHERE user_id = :user_id";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->bindParam(':user_id', $userId, PDO::PARAM_INT); // Correct variable name here
    $stmt_check->execute();
    $user_settings_exist = ($stmt_check->fetchColumn() > 0); // Fetch the column value before comparing

    // Don't echo here
    // echo $stmt_check->fetchColumn();

    if ($user_settings_exist) {
        $sql = "UPDATE user_settings SET site_schema = :site_schema, reading_style = :reading_style, images_per_page = :images_per_page WHERE user_id = :user_id";
    } else {
        $sql = "INSERT INTO user_settings (user_id ,site_schema, reading_style, images_per_page) VALUES (:user_id ,:site_schema, :reading_style, :images_per_page)";
    }

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':site_schema', $siteSchema);
    $stmt->bindParam(':reading_style', $readingStyle);
    $stmt->bindParam(':images_per_page', $imagesPerPage);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT); 


    if ($stmt->execute()) {
        $_SESSION['success'] = 'Settings Changed Successfully!';
        $_SESSION['siteSchema'] = $siteSchema;  
        $_SESSION['readingStyle'] = $readingStyle;  
        $_SESSION['imagesPerPage'] = $imagesPerPage;  
 
        header("Location: ../reader-settings");
        exit();  
    } else {
        $_SESSION['err'] = 'Something Went Wrong!';  
        header("Location: ../reader-settings");
        exit();  
    }
}
?>
