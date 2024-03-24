<?php
session_start();
include "db.php"; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "User is not logged in.";
        exit();
    }

    // Sanitize and validate input data
    $commentId = isset($_POST['comment_id']) ? $_POST['comment_id'] : null;
    $replyText = isset($_POST['reply_text']) ? $_POST['reply_text'] : null;

    // Validate comment ID and reply text
    if (!$commentId || !$replyText) {
        echo "Invalid input data.";
        exit();
    }

    // Insert the reply into the database
    $userId = $_SESSION['user_id'];
    $stmt = $pdo->prepare("INSERT INTO replies (comment_id, user_id, reply_text) VALUES (?, ?, ?)");
    $stmt->execute([$commentId, $userId, $replyText]);

    if ($stmt->rowCount() > 0) {
        // Reply inserted successfully
        $replyId = $pdo->lastInsertId(); // Get the ID of the inserted reply
        $replyTime = date('Y-m-d H:i:s'); // Current timestamp

        // Return the newly added reply as a JSON response
        $newReply = [
            'reply_id' => $replyId,
            'user_id' => $userId,
            'reply_text' => $replyText,
            'time_created' => $replyTime
        ];
        json_encode($newReply);
    } else {
        // Failed to insert the reply
        echo "Failed to add the reply to the database.";
    }
} else {
    // Handle non-POST requests
    echo "Invalid request.";
}
?>
