<?php
// Connect to MySQL
require_once('../php/db.php');

// Handle email verification
if (isset($_GET["code"])) {
    $verificationCode = $_GET["code"];

    $stmt = $pdo->prepare("UPDATE users SET is_verified = 1 WHERE verification_code = ?");
    $stmt->execute([$verificationCode]); // Assuming $verificationCode is already defined
    $rowCount = $stmt->rowCount(); // Get the number of affected rows
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to Our Website</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 600px;
      margin: 50px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    h1 {
      color: #333;
    }

    p {
      color: #666;
    }

    button {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 10px 20px;
      font-size: 18px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color: #0056b3;
    }

    #content {
      display: none;
      margin-top: 20px;
      border-top: 1px solid #ddd;
      padding-top: 20px;
    }

    #content h2 {
      color: #333;
    }

    #content p {
      color: #666;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1 >Welcome to Our Website</h1>
    <?php  if ($rowCount > 0) {
        echo '
        <p>Your account has been verified!</p>
        <button id="showContent">Continue to Work</button>' ;
    }else {
        echo "Invalid verification code.";
    }
    ?>

    </div>
</div>
<script>
  document.getElementById('showContent').addEventListener('click', function() {
    // Redirect to the desired page after account verification
    window.location.href = '/'; // Replace with your actual URL
  });
</script>



</body>
</html>

