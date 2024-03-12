<?php
session_start();
include "db.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo "User not logged in";
        exit();
    }

    $user_id = $_SESSION['user_id'];

    if (!isset($_POST['action']) || !isset($_POST['comment_id'])) {
        http_response_code(400);
        echo "Action or comment ID is missing";
        exit();
    }

    $action = $_POST['action'];
    $id = $_POST['comment_id']; 

    if ($action !== 'dislike') {
        http_response_code(400);
        echo "Invalid action";
        exit();
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM disliked_comments WHERE user_id = ? AND comment_id = ?");
        $stmt->execute([$user_id, $id]);
        $dislikeresult = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dislikeresult == null) {
            $stmt = $pdo->prepare("UPDATE comments SET dislikes = dislikes + 1 WHERE id = ?");
            $stmt->execute([$id]);

            $stmt = $pdo->prepare("INSERT INTO disliked_comments (user_id, comment_id) VALUES (?, ?)");
            $stmt->execute([$user_id, $id]);


            $stmt = $pdo->prepare("SELECT * FROM liked_comments WHERE user_id = ? AND comment_id = ?");
            $stmt->execute([$user_id, $id]);
            $likeresult = $stmt->fetch(PDO::FETCH_ASSOC);
            if($likeresult != null){
                $stmt = $pdo->prepare("UPDATE comments SET likes = likes - 1 WHERE id = ?");
                $stmt->execute([$id]);
    
                $stmt = $pdo->prepare("DELETE FROM liked_comments WHERE user_id = ? AND comment_id = ?");
                $stmt->execute([$user_id, $id]);
            }
        


            http_response_code(200);
            exit();
        } else {
            $stmt = $pdo->prepare("UPDATE comments SET dislikes = dislikes - 1 WHERE id = ?");
            $stmt->execute([$id]);

            $stmt = $pdo->prepare("DELETE FROM disliked_comments WHERE user_id = ? AND comment_id = ?");
            $stmt->execute([$user_id, $id]);

            http_response_code(200);
            exit();
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo "Database error: " . $e->getMessage();
        exit();
    }
} else {
    http_response_code(405);
    echo "Method not allowed";
    exit();
}
?>
