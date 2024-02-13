<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
  } 
if (isset($_SESSION['siteSchema']) && $_SESSION['siteSchema'] === "Dark"){
    echo'<link rel="stylesheet" href="assets/css/includes/darkmode.css">';
 }

$userID = $_SESSION['user_id'];


// Query to fetch data from the history table
$query = "SELECT b.img,b.id as bookID , b.title AS book_title, c.chapter_title AS chapter_title, h.accessed_at AS accessed_at FROM  history h LEFT JOIN users u ON h.user_id = u.id
            LEFT JOIN chapters c ON h.chapter_id = c.id LEFT JOIN  books b ON c.book_id = b.id WHERE  h.user_id = :user_id
            ORDER BY h.accessed_at DESC;";

// Prepare and execute the query
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
$stmt->execute();
// Fetch the results
$history_entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output the results
foreach ($history_entries as $entry) {

    $current_time = time();

    // Get the timestamp of the chapter creation time
    $history_time = strtotime($entry['accessed_at']);

    // Calculate the difference in seconds
    $time_difference = $current_time - $history_time;

    // Calculate the difference in minutes, hours, or days
    if ($time_difference < 60) {
      $accessed_at = $time_difference . ' seconds ago';
    } elseif ($time_difference < 3600) {
      $accessed_at = floor($time_difference / 60) . ' minutes ago';
    } elseif ($time_difference < 86400) {
      $accessed_at = floor($time_difference / 3600) . ' hours ago';
    }  elseif ($time_difference < 2073600) {
      $accessed_at = floor($time_difference / 86400) . ' days ago'; 
    }  else {
      $accessed_at = date('F j, Y', strtotime($row['accessed_at'])) ;
    }


    $chapter_title = $entry['chapter_title'];
    $words = explode(' ', $chapter_title);
    $chapter_title = implode(' ', array_slice($words, 0, 2));

    echo '
         <div class="novel-card">
            <img src="' . $entry['img'] . '" alt="" srcset="">
            <div class="info">
                <p class="title-history"> <a href="book.php?book_id=' . $entry['bookID'] . '">
                    ' .$entry['book_title']. '
                </a></p>
                <div class="chapters">
                    <a href="chapter-page.php?title=' . $entry['chapter_title'] . '" class="chapter-number">
                    '.$chapter_title.'
                    </a>
                    <p class="time">
                    ' .$accessed_at. '
                    </p> 
                    </div>
                    </div>
                </div>
                ';
    
}   
?>
 