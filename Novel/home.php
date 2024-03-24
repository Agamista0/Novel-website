<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
}

if (isset($_SESSION['siteSchema']) && $_SESSION['siteSchema'] === "Dark") {
    echo '<link rel="stylesheet" href="assets/css/includes/darkmode.css">';
}
include "php/home.php";
include "php/db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Home</title>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4758581028009642"
     crossorigin="anonymous"></script>
</head>
<body>

<?php
include "search-bar.php";
include "backtop.php";
include "navbar.php";
?>

<div class="content">
    <div class="left-side">
        <div class="content-header">
            <div class="sqr">
                <i class="fa-solid fa-star"></i>
            </div>
            <p> LATEST NOVEL UPDATES</p>
        </div>
        <div class="novels">
            
            <?php
            foreach ($result as $row) {
                $query = "SELECT time_created, chapter_title FROM chapters WHERE book_id = ? ORDER BY time_created DESC LIMIT 2";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$row['id']]);
                $chapters = $stmt->fetchAll(PDO::FETCH_ASSOC); 
                ?>
                <div class="novel-card-index" data-id="<?php echo $row['id']; ?>">
                    <!-- Novel Card Content -->
                    <div class="novel-img" data-id="<?php echo $row['id']; ?>">
                        <div class="colorhoverimg"></div>
                        <!-- Add a placeholder image and data-src attribute -->
                        <img src="placeholder.jpg" data-src="<?php echo $row['img']; ?>" href="/Novel/<?php echo $row['id']; ?>"
                             alt="<?php echo $row['title']; ?>">
                    </div>
                    <div class="novel-info">
                        <a href="/Novel/<?php echo $row['id'] ?>" class="title"><?php echo $row['title']; ?></a>
                        <div class="rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <p class="rating-number"><?php echo $row['sum_ratings']; ?></p>
                        </div>
                        <?php
                            // Retrieve the first two syllables of the author's name
                            $last_chapter_title = truncateChapterTitle($chapters[0]['chapter_title']);
                            $penultimate_chapter_title = truncateChapterTitle($chapters[1]['chapter_title']);
                            // Get the current timestam
                            $time_display = calculateTimeDifference($chapters[1]['time_created']);
                            $last_chapter_time = calculateTimeDifference($chapters[0]['time_created']);
                            // Output the formatted time
                            echo '
                                <div class="chapter-container">
                                    <a  href="/Novel/'.$row['id'].'/' . urlencode($chapters[0]['chapter_title']) . '" class="chapter">' . $last_chapter_title . '</a>
                                    <p class="time">' . $last_chapter_time . '</p>
                                </div> 
                                <div class="chapter-container">
                                    <a href="/Novel/'.$row['id'].'/' . urlencode($chapters[1]['chapter_title']) . '" class="chapter">' . $penultimate_chapter_title . '</a>
                                    <p class="time">' . $time_display . '</p>
                                </div>';
                        
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <?php include "older-index.php"; ?>
    </div>

    <div class="right-side">
        <div class="ads1">
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4758581028009642"
            crossorigin="anonymous"></script>
        <!-- ads1 -->
        <ins class="adsbygoogle"
            style="display:block"
            data-ad-client="ca-pub-4758581028009642"
            data-ad-slot="1987003461"
            data-ad-format="auto"
            data-full-width-responsive="true"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
        </div>
        <div class="history">
            <p>MY READING HISTORY</p>
        </div>
        <div class="history-not-found">
            <?php include 'php/Readhistory.php'; ?>
        </div>
        <?php include "popular-sections.php"; ?>
    </div>
    <div class="Ads2">
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4758581028009642"
        crossorigin="anonymous"></script>
    <!-- Ads2 -->
    <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-4758581028009642"
        data-ad-slot="8801971056"
        data-ad-format="auto"
        data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    </div>
</div>

<?php include "footer.php"; ?>

<script>
    // Function to lazy load images
    function lazyLoadImages() {
        const images = document.querySelectorAll('img[data-src]');
        
        images.forEach(img => {
            if (img.getBoundingClientRect().top < window.innerHeight) {
                // Load the image
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
            }
        });
    }

    // Call the lazyLoadImages function when the page is scrolled or resized
    window.addEventListener('scroll', lazyLoadImages);
    window.addEventListener('resize', lazyLoadImages);

    // Initial call to lazyLoadImages to load images when the page is loaded
    lazyLoadImages();
</script>

</body>
</html>

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
