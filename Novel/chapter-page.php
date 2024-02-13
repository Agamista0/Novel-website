<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  } 
  if (isset($_SESSION['siteSchema']) && $_SESSION['siteSchema'] === "Dark"){
    echo'<link rel="stylesheet" href="assets/css/includes/darkmode.css">';
} 
  
include 'php/db.php';

$title = isset($_GET['title']) ? $_GET['title'] : '';

$query = "SELECT book_id , chapter_title , chapter_text FROM chapters WHERE chapter_title = :title";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':title', $title, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$book_id = $result['book_id'];

// If you want to fetch all chapters for the dropdown menu
$query = "SELECT * FROM chapters WHERE book_id = :book_id ORDER BY id ASC";
$stmtAllCp = $pdo->prepare($query);
$stmtAllCp->bindParam(':book_id', $book_id, PDO::PARAM_STR);
$stmtAllCp->execute();
$chapters = $stmtAllCp->fetchAll(PDO::FETCH_ASSOC);

$currentIndex = array_search($title, array_column($chapters, 'chapter_title'));
$previousChapter = ($currentIndex > 0) ? $chapters[$currentIndex - 1] : null;
$nextChapter = ($currentIndex < count($chapters) - 1) ? $chapters[$currentIndex + 1] : null;

$options = '';
foreach ($chapters as $chapter) {
    $selected = ($chapter['chapter_title'] == $title) ? 'selected' : ''; // Check if current chapter is selected
    $options .= '<option value="' . $chapter['chapter_title'] . '" ' . $selected . '>' . $chapter['chapter_title'] . '</option>';
}

$query_tags = "SELECT tags,title FROM books WHERE id = :book_id";
$stmt_tags = $pdo->prepare($query_tags);
$stmt_tags->bindParam(':book_id', $chapter['book_id'], PDO::PARAM_INT);
$stmt_tags->execute();
$tags_result = $stmt_tags->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/chapter-page.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Chapter Page</title>
</head>
<body>
  <?php include "backtop.php"?>

  <?php include "navbar.php"?>
    <div class="novel-container">
        <div class="section">
            <div class="category-link-div">
                <a href="" class="category-link">Home/</a>
                <a href="" class="category-link"><?php echo $tags_result['title'] ?>/</a>
                <a href="" class="category-link"><?php echo $result['chapter_title'] ?></a>
            </div>
            <button class="bookmarks-btn">
                <i class="fa-solid fa-bookmark"></i>
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
                    <a href="chapter-page.php?title=<?php echo $previousChapter['chapter_title']; ?>" class="prev-btn">Prev</a>
                <?php endif; ?>
                <?php if ($nextChapter): ?>
                    <a href="chapter-page.php?title=<?php echo $nextChapter['chapter_title']; ?>" class="next-btn">Next</a>
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
                if ($tags_result) {
                    $tags = explode(',', $tags_result['tags']);
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
                    <a href="chapter-page.php?title=<?php echo $previousChapter['chapter_title']; ?>" class="prev-btn">Prev</a>
                <?php endif; ?>
                <?php if ($nextChapter): ?>
                    <a href="chapter-page.php?title=<?php echo $nextChapter['chapter_title']; ?>" class="next-btn">Next</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php include "footer.php"?>
    <script>
        document.getElementById('chapterSelect').addEventListener('change', function() {
            var selectedChapter = this.value;
            var url = 'chapter-page.php?title=' + selectedChapter;
            window.location.href = url;
        });

        document.getElementById('chapterSelect2').addEventListener('change', function() {
            var selectedChapter = this.value;
            var url = 'chapter-page.php?title=' + selectedChapter;
            window.location.href = url;
        });
    </script>
</body>
</html>
