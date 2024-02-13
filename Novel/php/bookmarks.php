<?php

$userID = $_SESSION['user_id'];
$query = "SELECT b.title, b.img, b.id ,
    MAX(CASE WHEN rn = 1 THEN c.chapter_title END) AS last_chapter_title,
    MAX(CASE WHEN rn = 1 THEN c.time_created END) AS last_chapter_time,
    MAX(CASE WHEN rn = 2 THEN c.chapter_title END) AS penultimate_chapter_title,
    MAX(CASE WHEN rn = 2 THEN c.time_created END) AS penultimate_chapter_time,
        bm.bookmarked_at AS bookmark_timestamp
    FROM books b
    LEFT JOIN (
    SELECT book_id, chapter_title, time_created, ROW_NUMBER() OVER (PARTITION BY book_id ORDER BY time_created DESC) AS rn
    FROM chapters
    ) c ON b.id = c.book_id
    LEFT JOIN bookmarks bm ON b.id = bm.book_id
    WHERE bm.user_id = :user_id
    GROUP BY b.title, b.img, bm.bookmarked_at ,b.id
    ORDER BY bm.bookmarked_at DESC ;";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $bookmarks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($bookmarks as $bookmark):  
                   
        $last_chapter_title = $bookmark['last_chapter_title'];
         $words = explode(' ', $last_chapter_title);
         $last_chapter_title = implode(' ', array_slice($words, 0, 2));
     
         $penultimate_chapter_title = $bookmark['penultimate_chapter_title'];
         $words = explode(' ', $penultimate_chapter_title);
         $penultimate_chapter_title = implode(' ', array_slice($words, 0, 2));
         $current_time = time();

         // Get the timestamp of the chapter creation time
         $chapter_time = strtotime($bookmark['penultimate_chapter_time']);
     
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
           $time_display = date('F j, Y', strtotime($bookmark['penultimate_chapter_time'])) ;
         }
     
         $last_chapter_time = strtotime($bookmark['last_chapter_time']);
     
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
           $last_chapter_time = date('F j, Y', strtotime($bookmark['last_chapter_time'])) ;
         }
     
?>
            <div class="user-settings-right-side-content">
                    <div class="novels">
                        <div class="novels-img">
                            <img src="<?php echo $bookmark['img'];?>" alt="">
                        </div>
                        <div class="novels-info">
                            <p class="manga-name-header">
                                Manga Name
                            </p>
                            <a href="book.php?book_id=<?php echo $bookmark['id'] ?>" class="manga-name">
                            <?php echo $bookmark['title'];?>
                            </a>
                            <div class="chapters">
                                <div class="chapter">
                                    <a href="chapter-page.php?title=<?php echo $bookmark['last_chapter_title']?>" class="chapter-button">
                                    <?php echo $last_chapter_title;?>
                                    </a>
                                    <p class="time">
                                    <?php echo $last_chapter_time;?>
                                    </p>
                                </div>
                                <div class="chapter">
                                    <a href="chapter-page.php?title=<?php echo $bookmark['penultimate_chapter_title']?>" class="chapter-button">
                                    <?php echo $penultimate_chapter_title ;?>
                                    </a>
                                    <p class="time">
                                    <?php echo $time_display;?>
                                    </p>
                                </div>
                            </div>
                            
                        </div>  
                        
                    </div>
                    <div class="updates-contaier">
                        <p class="update-header">
                            Updated Time  
                             <?php echo date('F j, Y', strtotime($bookmark['last_chapter_time'])) ?>
                        </p>
                    </div>
                    <div class="edit-section">
                        <div class="edit-container">
                            <p>Edit</p>
                            <button class="delete delete-normal">
                                <i class="fa-solid fa-x"></i>
                            </button>
                        </div>
                        <input type="checkbox"class="hhh">
                        <button class="delete-phone delete">
                            <i class="fa-solid fa-x"></i>
                        </button>
                    </div>
                    </div>

<?php endforeach; ?>


