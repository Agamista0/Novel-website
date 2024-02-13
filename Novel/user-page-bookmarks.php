<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_SESSION['siteSchema']) && $_SESSION['siteSchema'] === "Dark"){
    echo'<link rel="stylesheet" href="assets/css/includes/darkmode.css">';
} 
include './php/db.php' ;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/user-page-bookmarks.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>bookmarks</title>
</head>
<body>
<?php include "search-bar.php"?>
  <?php include "backtop.php"?>

  <?php include "navbar.php"?>
    <div class="container">
        <div class="user-settings-header">
            <p>User Settings</p>
        </div>

        <div class="user-content-container">
            <div class="user-settings-left-side">
                <a href="user-page-bookmarks.php" class="highlight"><i class="fa-solid fa-bookmark"></i> Bookmarks</a>
                <a href="history.php"><i class="fas fa-history"></i> History</a>
                <a href="reader-settings.php"><i class="fa-solid fa-gear"></i> Reader Settings</a>
                <a href="account.php"><i class="fa-solid fa-user"></i> Account Settings</a>
            </div>
            <div class="user-settings-right-side">
                <div class="user-settings-right-side-header">
                    <p>Manga Name</p>
                    <p>Updated Time</p>
                    <p>Edit</p>
                </div>
                <? include './php/bookmarks.php' ;?>
                    
                
                <div class="delete-container">
                    <input type="checkbox" name="" id="" class="checkall">
                    <label for="checkall">Check All</label>
                    <button class="delete-btn">delete</button>
                </div>
            </div>
        </div>

    </div>
</body>
</html>