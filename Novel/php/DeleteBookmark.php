<?php
session_start();
include 'db.php';

// Check if the form is submitted
if (isset($_POST['delete_bookmark'])) {
    // Check if any bookmarks were selected for deletion
    if (isset($_POST['selected_bookmarks']) && is_array($_POST['selected_bookmarks']) && !empty($_POST['selected_bookmarks'])) {
        
        // Prepare a SQL statement to delete the selected bookmarks
        $query = "DELETE FROM bookmarks WHERE user_id = :user_id AND book_id = :book_id";

        // Prepare and execute the query for each selected bookmark
        foreach ($_POST['selected_bookmarks'] as $bookmarkId) {
            try {
                $stmt = $pdo->prepare($query);
                // Bind parameters and execute the query
                $stmt->execute(['user_id' => $_SESSION['user_id'], 'book_id' => $bookmarkId]);
                $_SESSION['success'] = "Selected books have been successfully deleted";
            } catch (PDOException $e) {
                // Handle any database errors here
                $_SESSION['err'] = "Error deleting bookmark: " . $e->getMessage();
                // You might also log the error for debugging purposes
            }
        }

        header("Location: /user-page-bookmarks");
        exit();
    } else {
        // No bookmarks selected for deletion
        $_SESSION['err']= "No bookmarks selected for deletion.";
        header("Location: /user-page-bookmarks");
        exit();
    }
}
?>
