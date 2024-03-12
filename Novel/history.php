<?php 
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: index");
    exit();
}
if (isset($_SESSION['siteSchema']) && $_SESSION['siteSchema'] === "Dark"){
    echo'<link rel="stylesheet" href="assets/css/includes/darkmode.css">';
} 

include './php/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/histroy.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>History</title>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4758581028009642"
     crossorigin="anonymous"></script>
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
                <a href="user-page-bookmarks" ><i class="fa-solid fa-bookmark"></i> Bookmarks</a>
                <a href="history" class="highlight"><i class="fas fa-history"></i> History</a>
                <a href="reader-settings"><i class="fa-solid fa-gear"></i> Reader Settings</a>
                <a href="account"><i class="fa-solid fa-user"></i> Account Settings</a>
            </div>

            <div class="user-settings-right-side">
                <div class="novels">
                  <?php include './php/history.php';?>
                </div>
            </div>

        </div>

    </div>
</body>
</html>