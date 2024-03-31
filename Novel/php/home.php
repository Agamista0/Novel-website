<?php
include 'php/db.php' ;

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

$start_time = microtime(true);

$limit = 20;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$cacheKey = "books_page_$page";

// Check if data is cached in Redis
 $cachedData = $redis->get($cacheKey);

if (!$cachedData) {

    $query = "SELECT title, img, tags, author, id, genres, status, release_date, sum_ratings, views
        FROM books ORDER BY id LIMIT $limit OFFSET $offset";


    // Using prepared statement to prevent SQL injection
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Fetch all records as an associative array
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $redis->set($cacheKey, serialize($result));
    // Set expiration time for the cache (e.g., 1 hour)
$redis->expire($cacheKey, 86400);
} else {
    // Data found in cache, unserialize cached data
    $result = unserialize($cachedData);
}

    $total_books_query = "SELECT COUNT(*) as total FROM books ";
    $total_stmt = $pdo->prepare($total_books_query);
    $total_stmt->execute();
    $total_books = $total_stmt->fetch(PDO::FETCH_ASSOC)['total'];
    $total_pages = ceil($total_books / $limit);

?>

<script>
  
  document.addEventListener('DOMContentLoaded', () => {
    const novelCards = document.querySelectorAll('.novel-card-index');

    novelCards.forEach(card => {
        const img = card.querySelector('.novel-img img');
        const title = card.querySelector('.novel-info .title');

        // Event listener for clicking on the image
        img.addEventListener('click', (event) => {
            event.stopPropagation(); // Stop event propagation here
            const id = card.getAttribute('data-id');
            const url = `/php/views-increase?book_id=${id}`;
            incrementViews(url);
            navigateToNovelPage(id);
        });

        // Event listener for clicking on the title
        title.addEventListener('click', (event) => {
            event.stopPropagation(); // Stop event propagation here
            const id = card.getAttribute('data-id');
            const url = `/php/views-increase?book_id=${id}`;
            incrementViews(url);
        });
    });

    // Function to increment views via AJAX
    function incrementViews(url) {
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Function to navigate to novel page
    function navigateToNovelPage(id) {
        window.location.href = `/Novel/${id}`;
    }
});

</script>
