<?php
session_start();
include "db.php";


if (!isset($_POST['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_POST['user_id'];

if (!isset($_POST['chapter_id'])) {
    echo "Chapter ID is missing.";
    exit();
}

$chapter_id = $_POST['chapter_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $comment = htmlspecialchars($_POST['comment']);

    try {
        $stmt = $pdo->prepare("INSERT INTO comments (chapter_id, user_id, comment_text) VALUES (?, ?, ?)");

        $stmt->bindParam(1, $chapter_id);
        $stmt->bindParam(2, $user_id);
        $stmt->bindParam(3, $comment);

        $stmt->execute();

        header("Location: chapter.php?chapter_id=$chapter_id");
        exit();
    } catch (PDOException $e) {
        header("Location: chapterchapter_id=$chapter_id&error=" . urlencode($e->getMessage()));
        exit();
    }
}
?>
