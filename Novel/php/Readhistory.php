<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} 

if (isset($_SESSION['siteSchema']) && $_SESSION['siteSchema'] === "Dark") {
    echo '<link rel="stylesheet" href="assets/css/includes/darkmode.css">';
}


if (isset($_SESSION['user_id'])) {
    $userID = $_SESSION['user_id'];

    // Query to fetch data from the history table without duplicate books
    $query = "SELECT b.id AS bookID, b.title AS book_title, MAX(h.accessed_at) AS accessed_at
    FROM history h
    LEFT JOIN users u ON h.user_id = u.id
    LEFT JOIN chapters c ON h.chapter_id = c.id
    LEFT JOIN books b ON c.book_id = b.id
    WHERE h.user_id = :user_id
    GROUP BY b.id, b.title
    ORDER BY MAX(h.accessed_at) DESC
    LIMIT 3;
    ";


    // Prepare and execute the query
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the results
    $history_entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if($history_entries){
    // Output the results
    foreach ($history_entries as $entry) {
        echo '<div class="info">
                <p class="title-history">
                    <a class="history-title" href="book?book_id=' . $entry['bookID'] . '">
                        ' . $entry['book_title'] . '
                    </a>
                </p>
            </div>';
    }

    }else {
        echo "You don't have anything in your history.";
    }
}else {
    echo "You don't have anything in your history.";
}
?>