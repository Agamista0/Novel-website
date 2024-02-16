<?php 
if (session_status() === PHP_SESSION_NONE) {
  session_start();
  $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

} 
if (isset($_SESSION['siteSchema']) && $_SESSION['siteSchema'] === "Dark"){
  echo'<link rel="stylesheet" href="assets/css/includes/darkmode.css">';
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Home</title>
  </head>
  <body>
  <?php include "php/db.php"?>
  <?php include "search-bar.php"?>
  <?php include "backtop.php"?>

  <?php include "navbar.php"?>

    <div class="content">
      <div class="left-side">
        <div class="content-header">
          <div class="sqr">            <i class="fa-solid fa-star"></i>
</div>
          <p> LATEST NOVEL UPDATES</p>
        </div>
        <div class="novels">
          <?php include './php/home.php' ;?>
        </div>
      </div>
      <div class="right-side">
        <div class="history">
          <p>MY READING HISTORY</p>
          
        </div> 
        <div class="history-not-found">
          <?php include './php/Readhistory.php' ;?>
        </div>
        <?php include "popular-sections.php"?>
      </div>
    </div> <?php include "footer.php"?>
    <script>
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
  </body>
  
</html>