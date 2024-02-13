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
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/reader.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Document</title>
</head>
<body>
<?php include "search-bar.php"?>
  <?php include "backtop.php"?>

  <?php include "navbar.php"?>
<form class="container" action="php/submit-settings.php" method="POST">
    <div class="user-settings-header">
        <p>User Settings</p>
    </div>

    <div class="user-content-container">
        <div class="user-settings-left-side">
            <a href="user-page-bookmarks.php" ><i class="fa-solid fa-bookmark"></i> Bookmarks</a>
            <a href="history.php" ><i class="fas fa-history"></i> History</a>
            <a href="reader-settings.php" class="highlight"> <i class="fa-solid fa-gear"></i> Reader Settings</a>
            <a href="account.php" ><i class="fa-solid fa-user"></i> Account Settings</a>
        </div>

        <div class="user-settings-right-side">
            <div class="user-settings-right-side-header">
                <p>READING SETTINGS</p>
            </div>
            <div class="<?php if (isset($_SESSION['success'])) { echo "success"; } elseif (isset($_SESSION['err'])) { echo "err"; } ?>">
                <?php
                if (isset($_SESSION['success'])) {
                    echo "<p>" . $_SESSION['success'] . "</p>";
                    unset($_SESSION['success']);
                }
                if (isset($_SESSION['err'])) {
                    echo "<p>" . $_SESSION['err'] . "</p>";
                    unset($_SESSION['err']);
                }
                ?>
            </div>
            <div class="options-container">
                <p class="header-reader">
                    Site Schema
                </p>

                <div class="containerr">
                    <input type="radio" class="" name="Site Schema" value="Light" <?php if (isset($_SESSION['siteSchema']) && $_SESSION['siteSchema'] == "Light") echo "checked"; ?>>
                    <label for=" ">Light</label>
                </div>
                <div class="containerr">
                    <input type="radio" class="" name="Site Schema" value="Dark" <?php if (isset($_SESSION['siteSchema']) && $_SESSION['siteSchema'] == "Dark") echo "checked"; ?>>
                    <label for=" ">Dark</label>
                </div>
                <div class="containerr">
                    <input type="radio" class="" name="Site Schema" value="Default" <?php if (isset($_SESSION['siteSchema']) && $_SESSION['siteSchema'] == "Default") echo "checked"; ?>>
                    <label for=" ">Default</label>
                </div>
            </div>

            <div class="options-container">
                <p class="header-reader">
                    Reading Style
                </p>

                <div class="containerr">
                    <input type="radio" class="" name="Reading Style" value="Default" <?php if (isset($_SESSION['readingStyle']) && $_SESSION['readingStyle'] == "Default") echo "checked"; ?>>
                    <label for=" ">Default</label>
                </div>
                <div class="containerr">
                    <input type="radio" class="" name="Reading Style" value="Paged" <?php if (isset($_SESSION['readingStyle']) && $_SESSION['readingStyle'] == "Paged") echo "checked"; ?>>
                    <label for=" ">Paged</label>
                </div>
                <div class="containerr">
                    <input type="radio" class="" name="Reading Style" value="List" <?php if (isset($_SESSION['readingStyle']) && $_SESSION['readingStyle'] == "List") echo "checked"; ?>>
                    <label for=""> List</label>
                </div>
            </div>

            <div class="options-container">
                <p class="header-reader">
                    Images Per Page
                </p>

                <div class="containerr">
                    <input type="radio" class="" name="images per page" value="Default" <?php if (isset($_SESSION['imagesPerPage']) && $_SESSION['imagesPerPage'] == "Default") echo "checked"; ?>>
                    <label for=" ">Load 1 image per page (default)</label>
                </div>
                <div class="containerr">
                    <input type="radio" class="" name="images per page" value="1" <?php if (isset($_SESSION['imagesPerPage']) && $_SESSION['imagesPerPage'] == "1") echo "checked"; ?>>
                    <label for=" ">Load 3 images per page</label>
                </div>
                <div class="containerr">
                    <input type="radio" class="" name="images per page" value="3" <?php if (isset($_SESSION['imagesPerPage']) && $_SESSION['imagesPerPage'] == "3") echo "checked"; ?>>
                    <label for=" "> Load 6 images per page</label>
                </div>
                <div class="containerr">
                    <input type="radio" class="" name="images per page" value="6" <?php if (isset($_SESSION['imagesPerPage']) && $_SESSION['imagesPerPage'] == "6") echo "checked"; ?>>
                    <label for=" ">Load 10 images per page</label>
                </div>
            </div>
            <div class="btn-submit">
                <button>Submit</button>
            </div>
        </div>
    </div>
</form>
</body>
</html>
