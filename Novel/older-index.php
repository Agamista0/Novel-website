<?php include 'php/advanced.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/includes/older-index.css">
    <title>Document</title>
</head>
<body>
    <div class="older-posts-container">

       <div class="older-posts-div">
        <?php if ($page < $total_pages): ?>

            <a  href="?page=<?php echo $page + 1; ?>&search_keywords=<?php echo $search_keywords;?>&author=<?php echo $author;?>&year_of_release=<?php echo $year_of_release; ?>&status=<?php echo $status; ?>&tags=<?php echo $tags; ?>&sort=<?php echo $sort; ?>&order=<?php echo $order; if (!empty($genres)) { foreach ($genres as $genre) {echo "&genres%5B%5D=" . urlencode($genre); } } ;?>" class="older-posts">
               <i class="fa-solid fa-arrow-left"></i>  Older Posts
            </a>
        <?php endif; ?>
       </div>

       <div class="older-posts-div">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1;?>&search_keywords=<?php echo $search_keywords;?>&author=<?php echo $author;?>&year_of_release=<?php echo $year_of_release; ?>&status=<?php echo $status; ?>&tags=<?php echo $tags; ?>&sort=<?php echo $sort; ?>&order=<?php echo $order; if (!empty($genres)) { foreach ($genres as $genre) {echo "&genres%5B%5D=" . urlencode($genre); } } ;?>" class="older-posts">
                 Newer Posts <i class="fa-solid fa-arrow-right"></i>
            </a>
        <?php endif; ?>
       </div>

    </div>
</body>
</html>
