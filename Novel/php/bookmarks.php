<?php
$userID = $_SESSION['user_id'];

$query = "SELECT b.title, b.img, b.id,
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
        ORDER BY bm.bookmarked_at DESC";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
$stmt->execute();
$bookmarks = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($bookmarks as $bookmark):
    // Calculate time differences for last and penultimate chapters
    $last_chapter_time = calculateTimeDifference($bookmark['last_chapter_time']);
    $penultimate_chapter_time = calculateTimeDifference($bookmark['penultimate_chapter_time']);
?>
<div class="user-settings-right-side-content">
    <div class="novels">
        <div class="novels-img">
            <img src="<?php echo $bookmark['img']; ?>" alt="">
        </div>
        <div class="novels-info">
            <p class="manga-name-header">
                Manga Name
            </p>
            <a href="/Novel/<?php echo $bookmark['id'] ?>" class="manga-name">
                <?php echo $bookmark['title']; ?>
            </a>
            <div class="chapters">
                <div class="chapter-bookmarks">
                    <a href="/chapter/<?php echo $bookmark['last_chapter_title'] ?>" class="chapter-button">
                        <?php echo truncateChapterTitle($bookmark['last_chapter_title']); ?>
                    </a>
                    <p class="time">
                        <?php echo $last_chapter_time; ?>
                    </p>
                </div>
                <div class="chapter-bookmarks">
                    <a href="/chapter/<?php echo $bookmark['penultimate_chapter_title'] ?>" class="chapter-button">
                        <?php echo truncateChapterTitle($bookmark['penultimate_chapter_title']); ?>
                    </a>
                    <p class="time">
                        <?php echo $penultimate_chapter_time; ?>
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
        </div>
        <input type="checkbox" name="selected_bookmarks[]" class="hhh" value="<?php echo $bookmark['id']; ?>">
    </div>
</div>
<?php endforeach; ?>

<?php
// Function to calculate time difference
function calculateTimeDifference($timestamp)
{
    $current_time = time();
    $chapter_time = strtotime($timestamp);
    $time_difference = $current_time - $chapter_time;
    if ($time_difference < 60) {
        return $time_difference . ' seconds ago';
    } elseif ($time_difference < 3600) {
        return floor($time_difference / 60) . ' minutes ago';
    } elseif ($time_difference < 86400) {
        return floor($time_difference / 3600) . ' hours ago';
    } elseif ($time_difference < 2073600) {
        return floor($time_difference / 86400) . ' days ago';
    } else {
        return date('F j, Y', strtotime($timestamp));
    }
}

// Function to truncate chapter title
function truncateChapterTitle($title)
{
    $words = explode(' ', $title);
    return implode(' ', array_slice($words, 0, 2));
}
?>
