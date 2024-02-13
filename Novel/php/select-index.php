<?php
$query = "SELECT * FROM books ORDER BY created_at DESC LIMIT 21"; 

try {
    // Using prepared statement to prevent SQL injection
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Fetch all records as an associative array
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the results (for demonstration purposes)
    foreach ($result as $row) {
        echo "ID: " . $row['id'] . ", Title: " . $row['title'] . ", Author: " . $row['author'] . ", Release Date: " . $row['release_date'] . "<br>";
        // Add other columns as needed
    }

} catch (PDOException $e) {
    echo 'Query failed: ' . $e->getMessage();
}
?> 