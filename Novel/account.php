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
}  ?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="assets/css/account.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <title>Document</title>
   </head>
   <body>
   <?php include "search-bar.php"?>
  <?php include "backtop.php"?>

  <?php include "navbar.php"?>
      <div class="container"  >         
         <div class="user-settings-header">
            <p>User Settings</p>
         </div>
         <div class="<?php
          if (isset($_SESSION['success'])) { echo "success"; } elseif (isset($_SESSION['err'])) { echo "err"; } ?>">
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
         <div class="user-content-container">
            <div class="user-settings-left-side">
               <a href="user-page-bookmarks.php" ><i class="fa-solid fa-bookmark"></i> Bookmarks</a>
               <a href="history.php" ><i class="fas fa-history"></i> History</a>
               <a href="reader-settings.php"><i class="fa-solid fa-gear"></i> Reader Settings</a>
               <a href="account.php" class="highlight"><i class="fa-solid fa-user"></i> Account Settings</a>
            </div>
            <div class="user-settings-right-side">
               <form class="profile-picture-container" action="php/img-update.php" method="post" enctype="multipart/form-data" >
               <img src="<?php echo isset($_SESSION['profileimg']) ? $_SESSION['profileimg'] : '../assets/pictures/profile.jpg'; ?>" alt="" srcset="">
                  <div class="img-info">
                     <p class="img-info-header">
                        Only for .jpg .png or .gif file
                     </p>
                     <input type="file" name="picture" accept="image/*" class="pfpinp">
                     <br>
                     <button class="upload">
                     Upload
                     </button>
                  </div>
               </form>
               <form class="update-info-container" action="php/update_name.php" method="post" enctype="multipart/form-data">
                  <p class="update-info-container-p">
                     Change Your Display name
                  </p>
                  <div class="update-input-container">
                     <div class="containerr">
                        <label for="Currentname"  class="account-label">Current Display name</label>
                        <p class="old-info" name="Currentname"> <?php echo $_SESSION['username'];?> </p>
                     </div>
                     <div class="containerr">
                        <label  class="account-label" for="newname">New Display name</label>
                        <input type="text" name="newname" id="" class="input-update">
                     </div>
                     <div class="button-container">
                        <button>Submit</button>
                     </div>
                  </div>
               </form>
               <form class="update-info-container" action="php/update_email.php" method="post" enctype="multipart/form-data">
                  <p class="update-info-container-p">
                     Change Your email address
                  </p>
                  <div class="update-input-container">
                     <div class="containerr">
                        <label class="account-label" for="YourEmail">Your Email
                        </label>
                        <p class="old-info" name="YourEmail"> <?php echo $_SESSION['email'];?></p>
                     </div>
                     <div class="containerr">
                        <label class="account-label" for="NewEmail">Your New Email</label>
                        <input type="text" name="NewEmail" id="" class="input-update">
                     </div>
                     <div class="button-container">
                        <button>Submit</button>
                     </div>
                  </div>
               </form>
               <form class="update-info-container" action="php/password_update.php" method="POST">
                  <p class="update-info-container-p">
                     Change Your Password
                  </p>
                  <div class="update-input-container">
                     <div class="containerr">
                        <label class="account-label" for="Current Password
                           ">Current Password
                        </label>
                        <input type="text" name="old_password" id="" class="input-update">
                     </div>
                     <div class="containerr">
                        <label class="account-label" for="New Password">New Password</label>
                        <input type="text" name="new_password" id="" class="input-update">
                     </div>
                     <div class="containerr">
                        <label class="account-label" for="Comfirm Password  ">Comfirm Password
                        </label>
                        <input type="text" name="confirm_password" id="" class="input-update">
                     </div>
                     <div class="button-container">
                        <button>Submit</button>
                     </div>
                  </div>
               </div>
            </div>
               </form>
               </div>
   </body>
</html>