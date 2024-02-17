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
                ?>
                <div class="novel-card-index" data-id="<?php echo $row['id']; ?>">
                    <!-- Novel Card Content -->
                    <div class="novel-img" data-id="<?php echo $row['id']; ?>">
                        <div class="colorhoverimg"></div>
                        <img src="<?php echo $row['img']; ?>" href="/Novel/<?php echo $row['id']; ?>"
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
                        if ($row['last_chapter_title'] && $row['penultimate_chapter_title']) {
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
                            } elseif ($time_difference < 2073600) {
                                $time_display = floor($time_difference / 86400) . ' days ago';
                            } else {
                                $time_display = date('F j, Y', strtotime($row['penultimate_chapter_time']));
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
                            } elseif ($time_difference_last < 2073600) {
                                $last_chapter_time = floor($time_difference / 86400) . ' days ago';
                            } else {
                                $last_chapter_time = date('F j, Y', strtotime($row['last_chapter_time']));
                            }

                            // Output the formatted time
                            echo '
                            <div class="chapter-container">
                                <a  href="/chapter/' . $row['last_chapter_title'] . '" class="chapter">' . $last_chapter_title . '</a>
                                <p class="time">' . $last_chapter_time . '</p>
                            </div> 
                            <div class="chapter-container">
                                <a href="/chapter/' . $row['penultimate_chapter_title'] . '" class="chapter">' . $penultimate_chapter_title . '</a>
                                <p class="time">' . $time_display . '</p>
                            </div>';
                        }
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
        <div class="history">
            <p>MY READING HISTORY</p>
        </div>
        <div class="history-not-found">
            <?php include 'php/Readhistory.php'; ?>
        </div>
        <?php include "popular-sections.php"; ?>
    </div>
</div>

<?php include "footer.php"; ?>

<script>
    const successMessage = document.querySelector('.success');
    // If the success message div exists, show it and then hide it after 5 seconds
    if (successMessage) {
        successMessage.style.display = 'block';
        setTimeout(function () {
            successMessage.style.display = 'none';
        }, 3000); // 5000 milliseconds = 5 seconds
    }

    // Get the error message div
    const errorMessage = document.querySelector('.err');

    // If the error message div exists, show it and then hide it after 5 seconds
    if (errorMessage) {
        errorMessage.style.display = 'block';
        setTimeout(function () {
            errorMessage.style.display = 'none';
        }, 3000); // 5000 milliseconds = 5 seconds
    }
</script>

</body>
</html>
