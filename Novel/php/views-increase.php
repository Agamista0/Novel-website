<?php
// Include database connection
include "db.php";

// Check if the PDO connection exists
if (!$pdo) {
    die("Connection failed: PDO connection is not established.");
}

// Function to increment views for a book
function incrementBookViews($book_id, $pdo) {
    try {
        // Prepare SQL statement with a placeholder for book_id
        $sql = "UPDATE books SET views = views + 0.5 WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        
        // Execute the statement with book_id as a parameter
        $stmt->execute([$book_id]);
        
        return true; // Success
    } catch (PDOException $e) {
        // Handle errors, you might want to log instead of echoing directly
        echo "Error: " . $e->getMessage();
        return false; // Failure
    }
}

// Get book ID from URL parameter (assuming it's an integer)
$book_id = isset($_GET['book_id']) ? intval($_GET['book_id']) : null;

// Ensure book ID is set and is a valid integer
if ($book_id !== null && $book_id > 0) {
    // Call the function to increment views
    incrementBookViews($book_id, $pdo);
} else {
    echo "Invalid book ID."; // Provide feedback if book ID is missing or invalid
}

// Close the PDO connection
$pdo = null;
?>
