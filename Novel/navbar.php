<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/includes/nav.css">

    <title>Document</title>
</head>
<body>
         
<div class="modal" <?php if(isset($_SESSION['Signup_err']) || isset($_SESSION['Signup']) ) {echo'style="display:flex;"';} ?> >
        <div class="modal-content" >
            <span class="close">&times;</span>
            <h2>Signup for JadeNovels</h2>
            <?php if(isset($_SESSION['Signup'])) {echo'<div class="success">'.  $_SESSION['Signup'] . '</div>' ; unset($_SESSION['Signup']);} ?>
            <?php if(isset($_SESSION['Signup_err'])) {echo'<div class="err">'.  $_SESSION['Signup_err'] . '</div>' ; unset($_SESSION['Signup_err']);} ?>
            <form id="signup-form" action="/includes/signup" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password"  name="passwordSignup" id="password" required>
                </div>
                <button type="submit" class="btn">Sign Up</button>
            </form>
            <div class="options">
                <p>Already have an account? <a class="open-login">Log in</a></p>
                <p>Lost your password? <a href="#">Reset Password</a></p>
            </div>
        </div>
    </div>
    <div class="modal-login" <?php if(isset($_SESSION['login_err'])) {echo'style="display:flex;"';} ?>>
        <div class="modal-content">
          
            <span class="close-login">&times;</span>
            <h2>Sign In to Jade Novels</h2>
            <?php if(isset($_SESSION['login_err'])) {echo'<div class="err">'.  $_SESSION['login_err'] . '</div>' ; unset($_SESSION['login_err']);} ?>
            <form id="login-form" action="/includes/signin" method="post">
                <div class="form-group">
                    <label for="username_email">Username or Email Address</label>
                    <input type="text" name="username" id="username_email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="form-group">
                    <input type="checkbox" id="remember">
                    <label for="remember">Remember Me</label>
                </div>
                <button type="submit" class="btn">Sign In</button>
            </form>
            <div class="options">
                <p>Lost your password? <a href="#">Reset Password</a></p>
             </div>
        </div>
    </div>
<div class="overaly">
          
          </div>
<div class="custom-navigation-bar">
      <div class="custom-navigation-bar-container">
        <img src="/assets/pictures/5.png " alt="" class="logo" id="logo">
        <div class="custom-nav-links">
          <ul>
            <li>
              <a href="/user-page-bookmarks">User Settings</a>
            </li>
            <li>
              <a href="/advanced">ALL NOVEL</a>
            </li>
            <li>
              <a href="/advanced?status=COMPLETED">COMPLETED</a>
            </li>
            <li>
              <a href="/advanced?tags=CHINESE+NOVEL">CHINESE NOVEL</a>
            </li>
          </ul>
          <ul>
            <li>
              <a href="/advanced?tags=KOREAN+NOVEL">KOREAN NOVEL</a>
            </li>
            <li>
              <a href="/advanced?tags=JAPANESE+NOVEL">JAPANESE NOVEL</a>
            </li>
            
          </ul>
        </div>
      </div>
      <div class="custom-navigation-bar-btns">
        <a class="custom-search-button-nav">
          <i class="fas fa-search"></i>
        </a>
        <a class="custom-advanced-button-nav" href="/advanced"> Advanced </a>
        <img src="/assets/icons/bars.png" alt="" class="fa-bars" id="toggleButton">
      </div>
    </div>
    <div class="custom-secondary-navbar">
      <ul class="custom-secondary-navbar-ul">
        <li>
          <a href="/advanced?genres%5B%5D=Action">ACTION</a>
        </li>
        <li>
          <a href="/advanced?genres%5B%5D=Adventure">ADVENTURE</a>
        </li>
        <li>
          <a href="/advanced?genres%5B%5D=Fantasy">FANTASY</a>
        </li>
        <li>
          <a href="/advanced?genres%5B%5D=Romance">ROMANCE</a>
        </li>
        <li>
          <a href="/advanced?genres%5B%5D=Harem">HAREM</a>
        </li>
        <li>
          <a href="/advanced?genres%5B%5D=Martial+Arts">MARTIAL ARTS</a>
        </li>
        <li>
          <a  class="MORE" href="#" onmouseover="toggleDropdown(true)" onmouseout="toggleDropdown(false)">MORE <i class="fa-solid fa-caret-left fa-flip-horizontal"></i></a>
        </li>
      </ul>
      <ul class="custom-secondary-navbar-ul phone">
        <li>
          <a href="/advanced?genres%5B%5D=Action">ACTION</a>
        </li>
        <li>
          <a href="/advanced?genres%5B%5D=Adventure">ADVENTURE</a>
        </li>
        <li>
          <a href="/advanced?genres%5B%5D=Fantasy">FANTASY</a>
        </li>
        
      </ul>
      <i class="fa-solid fa-ellipsis fa-rotate-90 fa-ellipsis-nav phone-nav-list-btn"></i>
      <ul class="nav-list-dropdown">
     <ul>
     <li>
            <a href="/advanced?tags=KOREAN+NOVEL">KOREAN NOVEL</a>
          </li>
          <li>
            <a href="/advanced?tags=JAPANESE+NOVEL">JAPANESE NOVEL</a>
          </li>
          <li>
            <a href="/advanced?genres%5B%5D=Ecchi">ECCHI</a>
          </li>
     </ul>
          <ul>
          <li>
            <a href="/advanced?genres%5B%5D=Shounen">SHOUNEN</a>
          </li>
          <li>
            <a href="/advanced?genres%5B%5D=Comedy">COMEDY</a>
          </li>
          <li>
            <a href="/advanced?genres%5B%5D=School+Life">SCHOOL LIFE</a>
          </li>
          </ul>
          <ul>
          <li>
            <a href="/advanced?genres%5B%5D=Drama">DRAMA</a>
          </li>
          <li>
            <a href="/advanced?genres%5B%5D=Horror">HORROR</a>
          </li>
          <li>
            <a href="/advanced?genres%5B%5D=Shoujo">SHOUJO</a>
          </li>
          </ul>
          <ul>
          <li>
            <a href="/advanced?genres%5B%5D=Josei">JOSEI</a>
          </li>
          <li>
            <a href="/advanced?genres%5B%5D=Mature">MATURE</a>
          </li>
          <li>
            <a href="/advanced?genres%5B%5D=Mystery">MYSTERY</a>
          </li>
          </ul>
          <ul>
          <li>
            <a href="/advanced?genres%5B%5D=Psychological">PSYCHOLOGICAL</a>
          </li>
          <li>
            <a href="/advanced?genres%5B%5D=Sci-fi">SCI-FI</a>
          </li>
          <li>
            <a href="/advanced?genres%5B%5D=Seinen">SEINEN</a>
          </li>
          </ul>
          <ul>
          <li>
            <a href="/advanced?genres%5B%5D=Slice+of+Life">SLICE OF LIFE</a>
          </li>
          <li>
            <a href="/advanced?genres%5B%5D=Tragedy">TRAGEDY</a>
          </li>
          <li>
            <a href="/advanced?genres%5B%5D=Supernatural">SUPERNATURAL</a>
          </li>
          </ul>
      </ul>
      <div class="custom-navigation-bar-btns2" <?php if(isset($_SESSION['user_id'])){echo"style='display:none;'";} ?>>
        <a class="open-login"> Sign in </a>
        <a class="open"> Sign up </a>
      </div>
      <div class="user-loggedin-container" <?php  if(isset($_SESSION['user_id'])){echo"style='display:flex'";}  else{echo"style='display:none'";} ?>>
  <?php 
    echo '<p class="loggedin-name">'.$_SESSION["username"].' </p>' ; 
    echo '<img  class="profile-loggedin-pic" src="/'.$_SESSION["profileimg"].'" onmouseover="showList()" onmouseout="hideList()">'; 
  ?>
  <div id="hover-list" style="display: none;">
    <a href="/account"> User Settings</a>
    <a href="/logOut">Log out</a>
 
  </div>
</div>
    </div>
    <ul class="dropdown" id="myDropdown" >
    <ul>
    <li>
            <a href="/advanced?tags=KOREAN+NOVEL">KOREAN NOVEL</a>
          </li>
          <li>
            <a href="/advanced?tags=JAPANESE+NOVEL">JAPANESE NOVEL</a>
          </li>
          <li>
            <a href="/advanced?genres%5B%5D=Ecchi">ECCHI</a>
          </li>
          <li>
            <a href="/advanced?genres%5B%5D=Shounen">SHOUNEN</a>
          </li>
          <li>
            <a href="/advanced?genres%5B%5D=Comedy">COMEDY</a>
          </li>
          <li>
            <a href="/advanced?genres%5B%5D=School+Life">SCHOOL LIFE</a>
          </li>
          <li>
            <a href="/advanced?genres%5B%5D=Drama">DRAMA</a>
          </li>
          <ul>
      <li>
            <a href="/advanced?genres%5B%5D=Horror">HORROR</a>
          </li>
          <li>
            <a href="/advanced?genres%5B%5D=Shoujo">SHOUJO</a>
          </li>
          <li>
            <a href="/advanced?genres%5B%5D=Josei">JOSEI</a>
          </li>
          <li>
            <a href="/advanced?genres%5B%5D=Mature">MATURE</a>
          </li>
          <li>
            <a href="/advanced?genres%5B%5D=Mystery">MYSTERY</a>
          </li>
      </ul>
    </ul>

    

   <ul>
   <li>
            <a href="/advanced?genres%5B%5D=Psychological">PSYCHOLOGICAL</a>
          </li>
          <li>
            <a href="/advanced?genres%5B%5D=Sci-fi">SCI-FI</a>
          </li>
          <li>
            <a href="/advanced?genres%5B%5D=Seinen">SEINEN</a>
          </li>
          <li>
            <a href="/advanced?genres%5B%5D=Slice+of+Life">SLICE OF LIFE</a>
          </li>
          <li>
            <a href="/advanced?genres%5B%5D=Tragedy">TRAGEDY</a>
          </li>
          <li>
            <a href="/advanced?genres%5B%5D=Supernatural">SUPERNATURAL</a>
          </li>
   </ul>
        </ul>
        <div class="navbar-phone">
        <img src="/assets/pictures/x.svg" alt="" class="x-btn">
              <div class="navbar-phone-btns-container" <?php if(isset($_SESSION['user_id'])){echo"style='display:none;'";} ?>>


                <button href="" class="navbar-phone-btns open-login-phone">
                    Sign in
                </button>
                <button href="" class="navbar-phone-btns open-phone open-sign-phone">
                    Sign up
                </button>
     
              </div>


              <div class="user-loggedin-container-sidebar" <?php if(isset($_SESSION['user_id'])){echo"style='display:flex'";} else{echo"style='display:none'";} ?>>
<?php 
      echo '<img src="/'.$_SESSION["profileimg"].'" class="profile-loggedin-pic-sidebar">';  
      echo '<p class="loggedin-name-sidebar">'.$_SESSION["username"].'</p>'; 
?>
  </div>

<ul class="phoneli">
   <?php if(isset($_SESSION['user_id'])) 
      echo '<li><a class=" " href="/user-page-bookmarks">User Settings</a></li>' ;
    ?>
     <li><a class=" " href="/advanced">ALL NOVELS</a></li>
    <li><a class=" " href="/advanced?status=Completed">COMPLETED</a></li>
    <li><a class=" " href="/advanced?tags=CHINESE+NOVEL">CHINESE NOVEL</a></li>
    <li><a class=" " href="/advanced?tags=KOREAN+NOVEL">KOREAN NOVEL</a></li>
    <li><a class=" " href="/advanced.?tags=JAPANESE+NOVEL">JAPANESE NOVEL</a></li>
    <?php if(isset($_SESSION['user_id'])) 
      echo '<li><a class=" " href="logOut">LOGOUT</a></li>' ;
    ?>

</ul>
        </div>
        </div>
        </div>

 
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var dropdown = document.querySelector('.MORE');
    var dropdownList = document.querySelector('.dropdown');

    function toggleDropdown(isShow) {
      dropdownList.classList.toggle('show', isShow);
    }

    dropdown.addEventListener('mouseenter', function () {
      toggleDropdown(true);
    });

    dropdownList.addEventListener('mouseleave', function () {
      toggleDropdown(false);
    });

    document.addEventListener('mouseleave', function (event) {
      if (!dropdownList.contains(event.relatedTarget) && !dropdown.contains(event.relatedTarget)) {
        toggleDropdown(false);
      }
    });

    document.addEventListener('click', function (event) {
      if (!dropdownList.contains(event.target) && !dropdown.contains(event.target)) {
        toggleDropdown(false);
      }
    });

    const modal = document.querySelector('.modal');
    const openButtons = document.querySelectorAll('.open');
    const closeButtons = document.querySelectorAll('.close');

    openButtons.forEach(button => {
      button.addEventListener('click', function () {
        modal.style.display = 'flex';
      });
    });

    closeButtons.forEach(button => {
      button.addEventListener('click', function () {
        modal.style.display = 'none';
      });
    });



     const openButtonsphone = document.querySelectorAll('.open-sign-phone');
 
     openButtonsphone.forEach(button => {
      button.addEventListener('click', function () {
        modal.style.display = 'flex';
      });
    });

    closeButtons.forEach(button => {
      button.addEventListener('click', function () {
        modal.style.display = 'none';
      });
    });



    const modalLogin = document.querySelector('.modal-login');
    const openLoginButtons = document.querySelectorAll('.open-login, .open-login-phone');
    const closeLoginButtons = document.querySelectorAll('.close-login');

    openLoginButtons.forEach(button => {
      button.addEventListener('click', function () {
        modalLogin.style.display = 'flex';
      });
    });

    closeLoginButtons.forEach(button => {
      button.addEventListener('click', function () {
        modalLogin.style.display = 'none';
      });
    });
    const navbarPhoneBtns = document.querySelector('.navbar-phone-btns');
    const phoneli = document.querySelector('.phoneli');
    const navbarPhone = document.querySelector('.navbar-phone');
    const toggler = document.querySelector('.fa-bars');
    const xBtn = document.querySelector('.x-btn');

    toggler.addEventListener('click', function () {
      navbarPhone.classList.toggle('navbar-phone-show');
      navbarPhoneBtns.classList.toggle('show-block');
      phoneli.classList.toggle('show-block');

    });

    xBtn.addEventListener('click', function () {
      navbarPhone.classList.remove('navbar-phone-show');
      navbarPhoneBtns.classList.remove('show-block');
      phoneli.classList.remove('show-block');

    });
  });
  <?php  if(isset($_SESSION['user_id'])) { echo
  
  '
  document.addEventListener("DOMContentLoaded", function() {
    const profilePic = document.querySelector(".profile-loggedin-pic");
    const hoverList = document.getElementById("hover-list");

    profilePic.addEventListener("mouseenter", function() {
      hoverList.style.display = "flex";
    });

    hoverList.addEventListener("mouseleave", function() {
      hoverList.style.display = "none";
    });
  });
  ';

  
} 
?>
  document.addEventListener('DOMContentLoaded', function () {
    var dropdownButtonPhone = document.querySelector('.phone-nav-list-btn');
    var dropdownListPhone = document.querySelector('.nav-list-dropdown');

    dropdownButtonPhone.addEventListener('click', function () {
        if (dropdownListPhone.style.display === "block") {
            dropdownListPhone.style.display = "none";
        } else {
            dropdownListPhone.style.display = "block";
        }
    });

    window.addEventListener('click', function (event) {
        if (!event.target.matches('.phone-nav-list-btn')) {
            dropdownListPhone.style.display = "none";
        }
    });
});
const logo = document.getElementById('logo');

// Add a click event listener to the logo element
logo.addEventListener('click', function() {
  // Redirect to index
  window.location.href = '/home';
});

document.addEventListener('DOMContentLoaded', function () {
    // Select the user settings button
    var userSettingsButton = document.querySelector('a[href="/user-page-bookmarks"]');

    // Add event listener to the user settings button
    userSettingsButton.addEventListener('click', function (event) {
        // Prevent the default action of the link
        event.preventDefault();

        // Check if the user is logged in (you can adjust this condition as per your session management)
        var isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;

        // If the user is not logged in, open the login modal
        if (!isLoggedIn) {
            var modalLogin = document.querySelector('.modal-login');
            modalLogin.style.display = 'flex';
        } else {
            // If the user is logged in, proceed to the user settings page
            window.location.href = userSettingsButton.getAttribute('href');
        }
    });
});
</script>
</body>
</html>