<?php 
 if (isset($_SESSION['siteSchema']) && $_SESSION['siteSchema'] === "Dark"){
    echo'<link rel="stylesheet" href="assets/css/includes/darkmode.css">';
}  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/popular-sections.module.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Document</title>
</head>
<?php include "php/db.php"?>

<body>
    <div class="content-right">

        <div class="content-header-right">
            <div class="left-side-header-right"> 
                <div class="sqr-right">POPULAR NOVELS</div>
        </div>
            
        </div>
        <div class="novels-right">
      
<?php

$query = " SELECT b.title, b.img, b.tags, b.author, b.id, b.genres, b.status, b.release_date, b.sum_ratings, b.views ,
              MAX(CASE WHEN rn = 1 THEN c.chapter_title END) AS last_chapter_title,
              MAX(CASE WHEN rn = 1 THEN c.time_created END) AS last_chapter_time,
              MAX(CASE WHEN rn = 2 THEN c.chapter_title END) AS penultimate_chapter_title,
              MAX(CASE WHEN rn = 2 THEN c.time_created END) AS penultimate_chapter_time
              FROM books b
              LEFT JOIN ( SELECT book_id, chapter_title, time_created, ROW_NUMBER() OVER (PARTITION BY book_id ORDER BY time_created DESC) AS rn
              FROM chapters ) c ON b.id = c.book_id GROUP BY b.title, b.img, b.tags, b.author, b.id, b.genres, b.status, b.release_date, b.sum_ratings
              ORDER BY b.views DESC LIMIT 8 ; " ;
          

try {
// Using prepared statement to prevent SQL injection
$stmt = $pdo->prepare($query);
$stmt->execute();

// Fetch all records as an associative array
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output the results inside your HTML structure
foreach ($result as $row) {
?>
            <div class="novel-card-right">
                <div class="novel-img" data-id="<?php echo $row['id']; ?>">
                    <img src="<?php echo $row['img']; ?>" alt="<?php echo $row['title']; ?>" alt="">
                </div>
                <div class="novel-info-right">
                    <p class="title-right truncate-text">
                    <a href="book.php?book_id=<?php echo $row['id'] ?>" class="title-right-link"><?php echo $row['title']; ?></a>
                    </p>
    <?php if ($row['last_chapter_title'] && $row['penultimate_chapter_title'] ) { 
        // Retrieve the first two syllables of the author's name
        $last_chapter_title = $row['last_chapter_title'];
        $words = explode(' ', $last_chapter_title);
        $last_chapter_title = implode(' ', array_slice($words, 0, 2));

        $penultimate_chapter_title = $row['penultimate_chapter_title'];
        $words = explode(' ', $penultimate_chapter_title);
        $penultimate_chapter_title = implode(' ', array_slice($words, 0, 2));
        // Get the current timestamp
        $current_time = time();

        // Get the timestamp of the chapter creation time
        $chapter_time = strtotime($row['penultimate_chapter_time']);

        // Calculate the difference in seconds
        $time_difference = $current_time - $chapter_time;

        // Calculate the difference in minutes, hours, or days
        if ($time_difference < 60) {
        $time_display = $time_difference . ' seconds ago';
        } elseif ($time_difference < 3600) {
        $time_display = floor($time_difference / 60) . ' minutes ago';
        } elseif ($time_difference < 86400) {
        $time_display = floor($time_difference / 3600) . ' hours ago';
        }  elseif ($time_difference < 2073600) {
        $time_display = floor($time_difference / 86400) . ' days ago'; 
        }  else {
        $time_display = date('F j, Y', strtotime($row['penultimate_chapter_time'])) ;
        }
        
        $last_chapter_time = strtotime($row['last_chapter_time']);

        // Calculate the difference in seconds
        $time_difference_last = $current_time - $last_chapter_time;
    
        // Calculate the difference in minutes, hours, or days
        if ($time_difference_last < 60) {
          $last_chapter_time = $time_difference . ' seconds ago';
        } elseif ($time_difference_last < 3600) {
          $last_chapter_time = floor($time_difference / 60) . ' minutes ago';
        } elseif ($time_difference_last < 86400) {
          $last_chapter_time = floor($time_difference / 3600) . ' hours ago';
        }  elseif ($time_difference_last < 2073600) {
          $last_chapter_time = floor($time_difference / 86400) . ' days ago'; 
        }  else {
          $last_chapter_time = date('F j, Y', strtotime($row['last_chapter_time'])) ;
        }


        echo '
        <div class="chapter-container-right">
            <a href="chapter-page.php?title='.$row['last_chapter_title'].'" class="chapter-right">
            '.$last_chapter_title.'
            </a>
            <p class="time-right">
                '.$last_chapter_time.'
            </p>
        </div>
        <div class="chapter-container-right">
            <a href="chapter-page.php?title='.$row['penultimate_chapter_title'].'" class="chapter-right">
            '.$penultimate_chapter_title.'
            </a>
            <p class="time-right">
            '.$time_display.'
            </p>
        </div>';

} ?>
                </div>
            </div>
            <?php
    }
} catch (PDOException $e) {
    echo 'Query failed: ' . $e->getMessage();
}
?>
         
        <a href="/advanced.php?sort=most-views&order=dasc" class="more-novels-btn">
            Here for more Popular Novel
        </a>
    </div>
 
</div>
</div>
<script>
     const novelCardsPopular = document.querySelectorAll('.novel-img');

     novelCardsPopular.forEach(card => {
        card.addEventListener('click', () => {
             const id = card.getAttribute('data-id');
             const url = `book.php?book_id=${id}`;
             window.location.href = url;
        });
    });
    document.addEventListener('DOMContentLoaded', () => {
            const novelCardsPopular = document.querySelectorAll('.novel-card-right');

            novelCardsPopular.forEach(card => {
                card.addEventListener('click', () => {
                    const id = card.getAttribute('data-id');
                    const url = `php/views-increase.php?book_id=${id}`;
                    fetch(url)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                         })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
</script>
</body>
</html>