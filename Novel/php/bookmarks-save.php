<?php
session_start();
include 'db.php';

try {
    if(isset($_POST['book_id']) && !empty($_POST['book_id'])) {
        $bookId = $_POST['book_id'];
        $userId = $_SESSION['user_id'];

        // Check if the book is already bookmarked by the user
        $stmt = $pdo->prepare("SELECT * FROM bookmarks WHERE user_id = ? AND book_id = ?");
        $stmt->execute([$userId, $bookId]);
        $existingBookmark = $stmt->fetch();

        if ($existingBookmark) {
            // If bookmark exists, remove it
            $stmt = $pdo->prepare("DELETE FROM bookmarks WHERE user_id = ? AND book_id = ?");
            $stmt->execute([$userId, $bookId]);
            echo "deleted"; // Return "deleted" if bookmark was successfully deleted
        } else {
            // If bookmark does not exist, insert it
            $stmt = $pdo->prepare("INSERT INTO bookmarks (user_id, book_id) VALUES (?, ?)");
            if ($stmt->execute([$userId, $bookId])) {
                echo "added"; // Return "added" if bookmark was successfully added
            } else {
                echo "Error inserting bookmark";
            }
        }
    } else {
        echo "Error: book_id not provided";
    }
} catch (PDOException $e) {
    // Echo out any errors that occur during the connection or execution of SQL queries
    echo 'Connection failed: ' . $e->getMessage();
}
?>
