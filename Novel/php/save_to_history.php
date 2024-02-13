<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  } 
  include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $chapterId = $_POST['chapterId'];
    $userId = $_SESSION['user_id'];

     $sql = "INSERT INTO history (chapter_id, user_id) VALUES (:chapterId, :userId)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':chapterId' => $chapterId, ':userId' => $userId));

    if ($stmt->rowCount() > 0) {
        echo "Data saved to history successfully.";
    } else {
        echo "Failed to save data to history.";
    }
} else {
    echo "Invalid request method.";
}
?>
