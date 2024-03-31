<?php
session_start();
include "db.php";

// Check if redirect URL is set in session
$redirect_url = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : '../home.php';

// Check if user_id is set
if (!isset($_POST['user_id'])) {
    header("Location: ../home.php");
    exit();
}

$user_id = $_POST['user_id'];

// Check if chapter_id is set
if (!isset($_POST['chapter_id'])) {
    echo "Chapter ID is missing.";
    exit();
}

$chapter_id = $_POST['chapter_id'];

// Check if comment is set in the POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    // Sanitize comment
    $comment = htmlspecialchars($_POST['comment']);
    
    // Insert comment into the database
    $stmt = $pdo->prepare("INSERT INTO comments (chapter_id, user_id, comment_text) VALUES (?, ?, ?)");

    $stmt->bindParam(1, $chapter_id);
    $stmt->bindParam(2, $user_id);
    $stmt->bindParam(3, $comment);

    $stmt->execute();

    // Redirect after successful insertion
    header('Location: ' . $redirect_url);
    exit();
}
?>

