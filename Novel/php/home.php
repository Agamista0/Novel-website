<?php

$query = " SELECT b.title, b.img, b.tags, b.author, b.id, b.genres, b.status, b.release_date, b.sum_ratings,
              MAX(CASE WHEN rn = 1 THEN c.chapter_title END) AS last_chapter_title,
              MAX(CASE WHEN rn = 1 THEN c.time_created END) AS last_chapter_time,
              MAX(CASE WHEN rn = 2 THEN c.chapter_title END) AS penultimate_chapter_title,
              MAX(CASE WHEN rn = 2 THEN c.time_created END) AS penultimate_chapter_time
              FROM books b
              LEFT JOIN ( SELECT book_id, chapter_title, time_created, ROW_NUMBER() OVER (PARTITION BY book_id ORDER BY time_created DESC) AS rn
              FROM chapters ) c ON b.id = c.book_id GROUP BY b.title, b.img, b.tags, b.author, b.id, b.genres, b.status, b.release_date, b.sum_ratings
              ORDER BY b.id LIMIT 20 ; " ;
          

try {
// Using prepared statement to prevent SQL injection
$stmt = $pdo->prepare($query);
$stmt->execute();

// Fetch all records as an associative array
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output the results inside your HTML structure
foreach ($result as $row) {
?>
  <div class="novel-card-index"  data-id="<?php echo $row['id']; ?>" > 
            <div class="novel-img"data-id="<?php echo $row['id']; ?>">
          <div class="colorhoverimg" ></div>
            <img src="<?php echo $row['img']; ?>" alt="<?php echo $row['title']; ?>">
          </div>
          <div class="novel-info">
            <a href="book.php?book_id=<?php echo $row['id'] ?>" class="title"><?php echo $row['title']; ?></a>
          <div class="rating">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
          <p class="rating-number"><?php echo $row['sum_ratings']; ?></p>
        </div>
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


// Output the formatted time

  echo '
  <div class="chapter-container">
  <a  href="chapter-page.php?title='.$row['last_chapter_title'].'" class="chapter">'.$last_chapter_title.'</a>
  <p class="time">'.$last_chapter_time.'</p>
  </div> 
  <div class="chapter-container">
  <a href="chapter-page.php?title='.$row['penultimate_chapter_title'].'" class="chapter"> '.$penultimate_chapter_title.'</a>
  <p class="time"> '.$time_display.'</p>
</div>' ;
} ?>
</div>
</div>
<?php
} }catch (PDOException $e) {
    echo 'Query failed: ' . $e->getMessage();
}
?>
<script>
  
  document.addEventListener('DOMContentLoaded', () => {
        const novelCards = document.querySelectorAll('.novel-card-index');

        novelCards.forEach(card => {
            const img = card.querySelector('.novel-img img');
            const title = card.querySelector('.novel-info .title');

            img.addEventListener('click', () => {
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

            title.addEventListener('click', () => {
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