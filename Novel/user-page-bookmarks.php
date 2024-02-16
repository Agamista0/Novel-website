<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: index");
    exit();
}

include './php/db.php';

// Check for dark mode and include CSS accordingly
if (isset($_SESSION['siteSchema']) && $_SESSION['siteSchema'] === "Dark") {
    echo '<link rel="stylesheet" href="assets/css/includes/darkmode.css">';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/user-page-bookmarks.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Bookmarks</title>
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
            <a href="user-page-bookmarks" class="highlight"><i class="fa-solid fa-bookmark"></i> Bookmarks</a>
            <a href="history"><i class="fas fa-history"></i> History</a>
            <a href="reader-settings"><i class="fa-solid fa-gear"></i> Reader Settings</a>
            <a href="account"><i class="fa-solid fa-user"></i> Account Settings</a>
        </div>
        <div class="user-settings-right-side">
             <?php
                if (isset($_SESSION['success'])) {
                    echo "<div class='success'>";
                    echo "<p>" . $_SESSION['success'] . "</p>";
                    echo "</div>";
                    unset($_SESSION['success']);
                }

                if (isset($_SESSION['err'])) {
                    echo "<div class='err'>";
                    echo "<p>" . $_SESSION['err'] . "</p>";
                    echo "</div>";
                    unset($_SESSION['err']);
                }
                ?>
            <div class="user-settings-right-side-header">
                <p>Manga Name</p>
                <p>Updated Time</p>
                <p>Edit</p>
            </div>
            <form id="bookmark_form" action="./php/DeleteBookmark" method="post">
            
            <?php include './php/bookmarks.php'; ?>
                
                    <div class="delete-container">
                    <input type="checkbox" class="checkall">
                    <label for="checkall">Check All</label>
                    <button class="delete-btn" type="submit" name="delete_bookmark">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/bookmarks.js"></script>
</body>
</html>

<script>
     

     document.querySelector('.checkall').addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('input[name="selected_bookmarks[]"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = this.checked;
        }.bind(this));
    });
    // Get the success message div
    const successMessage = document.querySelector('.success');
    // If the success message div exists, show it and then hide it after 5 seconds
    if (successMessage) {
        successMessage.style.display = 'block';
        setTimeout(function() {
            successMessage.style.display = 'none';
        }, 3000); // 5000 milliseconds = 5 seconds
    }
     // Get the error message div
     const errorMessage = document.querySelector('.err');

    // If the error message div exists, show it and then hide it after 5 seconds
    if (errorMessage) {
    errorMessage.style.display = 'block';
    setTimeout(function() {
        errorMessage.style.display = 'none';
    }, 3000); // 5000 milliseconds = 5 seconds
}
</script>

</html>