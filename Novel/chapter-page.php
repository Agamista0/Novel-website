<?php
include 'php/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
}

if (isset($_SESSION['siteSchema']) && $_SESSION['siteSchema'] === "Dark") {
    echo '<link rel="stylesheet" href="/assets/css/includes/darkmode.css">';
}

$book_id = $_GET['book_id'];

$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$title = basename($uri_path);
$title = urldecode($title);

$query = "SELECT c.book_id, c.chapter_title, c.chapter_text, b.tags, b.title
          FROM chapters c
          JOIN books b ON b.id = $book_id
          WHERE c.chapter_title = :title";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':title', $title, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$tags = explode(',', $result['tags']);

$query = "SELECT id, chapter_title FROM chapters WHERE book_id = :book_id ORDER BY id ASC";
$stmtAllCp = $pdo->prepare($query);
$stmtAllCp->bindParam(':book_id', $book_id, PDO::PARAM_INT);
$stmtAllCp->execute();
$chapters = $stmtAllCp->fetchAll(PDO::FETCH_ASSOC);

$currentIndex = array_search($title, array_column($chapters, 'chapter_title'));
$previousChapter = ($currentIndex > 0) ? $chapters[$currentIndex - 1] : null;
$nextChapter = ($currentIndex < count($chapters) - 1) ? $chapters[$currentIndex + 1] : null;


$options = '';
foreach ($chapters as $chapter) {
    $selected = ($chapter['chapter_title'] == $title) ? 'selected' : '';
    $options .= '<option value="' . urlencode($chapter['chapter_title']) . '" ' . $selected . '>' . $chapter['chapter_title'] . '</option>';
}

$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'Null';

$stmt = $pdo->prepare("SELECT COUNT(*) FROM bookmarks WHERE user_id = ? AND book_id = ?");
$stmt->execute([$userId, $book_id]);
$existingBookmark = $stmt->fetchColumn();
$bookmarked_or_not = ($existingBookmark > 0) ? 0 : 1;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/chapter-page.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Chapter Page</title>
</head>
<body>
    <?php include "backtop.php"?>
    <?php include "navbar.php"?>
    <div class="novel-container">
        <div class="section">
            <div class="category-link-div">
                <a href="/home" class="category-link">Home/</a>
                <a href="/Novel/<?php echo $book_id ?>" class="category-link"><?php echo $result['title'] ?>/</a>
                <a href="" class="category-link"><?php echo $result['chapter_title'] ?></a>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            </div>
            <button class="bookmarks-btn bookmarks-btn-normal" data-id="<?php echo $book_id; ?>">
            <?php if ($bookmarked_or_not === 1) {
                    echo "<i class='fa-solid fa-bookmark check-bookmarks-normal'></i><p>Bookmark</p>";
                } else {
                    echo "<i class='fa-solid fa-check'></i><p>Bookmarked</p>";
                }?>
            </button>
        </div>
        <div class="button-bookmarks-phone">
            <button class="bookmarks-btn bookmarks-btn-phone" data-id="<?php echo $book_id; ?>">
            <?php if ($bookmarked_or_not === 1) {
                    echo "<i class='fa-solid fa-bookmark'></i><p class='Bookmarked-p'>Bookmark</p>";
                } else {
                    echo "<i class='fa-solid fa-check check-bookmarks-phone'></i><p class='Bookmarked-p'>Bookmarked</p>";
                }?>
            </button>
        </div>
        <div class="section section-select">
            <div class="custom-select">
                <select id="chapterSelect">
                    <?php echo $options; ?>
                </select>
            </div>
            <div class="btns-chatper-page">
                <?php if ($previousChapter): ?>
                    <a href="<?php echo '/Novel/'.$book_id.'/'. urlencode($previousChapter['chapter_title']); ?>" class="prev-btn">Prev</a>
                <?php endif; ?>
                <?php if ($nextChapter): ?>
                    <a href="<?php echo '/Novel/'.$book_id.'/'.urlencode($nextChapter['chapter_title']); ?>" class="next-btn">Next</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="chapter-body">
            <?php echo $result['chapter_text']; ?>
        </div>
        <div class="section">
            <div class="tags-div">
                <p class="tags">Tags:</p>
                <?php 
                if ($tags) {
                    foreach ($tags as $tag) {
                        echo '<a class="tag-link">' . trim($tag) . '</a>';
                    }
                }
                ?>
            </div>
        </div>
        <div class="section section-select">
            <div class="custom-select ">
                <select id="chapterSelect2">
                    <?php echo $options; ?>
                </select>
            </div>
            <div class="btns-chatper-page">
                <?php if ($previousChapter): ?>
                    <a href="<?php echo '/Novel/'.$book_id.'/'. urlencode($previousChapter['chapter_title']); ?>" class="prev-btn">Prev</a>
                <?php endif; ?>
                <?php if ($nextChapter): ?>
                    <a href="<?php echo '/Novel/'.$book_id.'/'. urlencode($previousChapter['chapter_title']); ?>" class="next-btn">Next</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php
        include "comments.php" ;
        include "footer.php";
    ?>
    <script>
        document.getElementById('chapterSelect').addEventListener('change', function() {
            var selectedChapter = this.value;
            var url = '/Novel/' + <?php echo $book_id ?> +'/' + selectedChapter;
            window.location.href = url;
        });

        document.getElementById('chapterSelect2').addEventListener('change', function() {
            var selectedChapter = this.value;
            var url = '/Novel/' + <?php echo $book_id ?> +'/' + selectedChapter;
            window.location.href = url;
        });

        $(document).ready(function(){
            $('.novel-container').on('click', '.bookmarks-btn-normal, .bookmarks-btn-phone', function(){
                var button = $(this);
                var bookId = button.data('id');
                var isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;

                if (!isLoggedIn) {
                    var modalLogin = document.querySelector('.modal-login');
                    modalLogin.style.display = 'flex';
                } else {
                    $.ajax({
                        type: "POST",
                        url: "/php/bookmarks-save",
                        data: { book_id: bookId },
                        success: function(response){
                            console.log("Data sent successfully");
                            console.log("Response from server:", response); 
                            var isBookmarked = response.trim() === 'added'; 
                            updateButtonUI(button, isBookmarked); 
                            var otherButton = button.hasClass('bookmarks-btn-normal') ? $(".bookmarks-btn-phone") : $(".bookmarks-btn-normal");
                            updateButtonUI(otherButton, isBookmarked);
                        },
                        error: function(){
                            console.error("Error sending data");
                        }
                    });
                }
            });

            function updateButtonUI(button, isBookmarked) {
                if (isBookmarked) {
                    button.html('<i class="fa-solid fa-check"></i><p>Bookmarked</p>');
                } else {
                    button.html('<i class="fa-solid fa-bookmark"></i><p>Bookmark</p>');
                }
            }
        });
    </script>
</body>
</html>

