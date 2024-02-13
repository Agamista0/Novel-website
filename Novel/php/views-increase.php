<?php
include "db.php";

// Check if the PDO connection exists
if (!$pdo) {
    die("Connection failed: PDO connection is not established.");
}

// Function to increment views for a book
function incrementBookViews($book_id, $pdo) {
    try {
        $sql = "UPDATE books SET views = views + 1 WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$book_id]);
        return true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

// Get book ID from URL parameter
$book_id = $_GET['book_id'];

// Ensure book ID is set
if (isset($book_id)) {
    incrementBookViews($book_id, $pdo);
}

// Close the PDO connection
$pdo = null;
?>
