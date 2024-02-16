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
               <a href="user-page-bookmarks" ><i class="fa-solid fa-bookmark"></i> Bookmarks</a>
               <a href="history" ><i class="fas fa-history"></i> History</a>
               <a href="reader-settings"><i class="fa-solid fa-gear"></i> Reader Settings</a>
               <a href="account" class="highlight"><i class="fa-solid fa-user"></i> Account Settings</a>
            </div>
            <div class="user-settings-right-side">
               <form class="profile-picture-container" action="php/img-update" method="post" enctype="multipart/form-data" >
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
               <form class="update-info-container" action="php/update_name" method="post" enctype="multipart/form-data">
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
               <form class="update-info-container" action="php/update_email" method="post" enctype="multipart/form-data">
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
               <form class="update-info-container" action="php/password_update" method="POST">
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