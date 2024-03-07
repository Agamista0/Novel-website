<?php
include 'db.php';

// Connect to Redis

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$limit = 20;

$total_books_query = "SELECT COUNT(*) as total FROM books ";
$total_stmt = $pdo->prepare($total_books_query);
$total_stmt->execute();
$total_books = $total_stmt->fetch(PDO::FETCH_ASSOC)['total'];
$total_pages = ceil($total_books / $limit);


for ($page = 1; $page <= $total_pages; $page++) {
    $offset = ($page - 1) * $limit;
    $cacheKey = "books_page_$page";

    // Check if data is cached in Redis
 	$redis->del($cacheKey);

        // Fetch data from the database if not cached
        $query = "SELECT b.title, b.img, b.tags, b.author, b.id, b.genres, b.status, b.release_date, b.sum_ratings, b.views,
        MAX(CASE WHEN c.rn = 1 THEN c.chapter_title END) AS last_chapter_title,
        MAX(CASE WHEN c.rn = 1 THEN c.time_created END) AS last_chapter_time,
        MAX(CASE WHEN c.rn = 2 THEN c.chapter_title END) AS penultimate_chapter_title,
        MAX(CASE WHEN c.rn = 2 THEN c.time_created END) AS penultimate_chapter_time
        FROM 
        books b
        LEFT JOIN (
        SELECT book_id, chapter_title, time_created, ROW_NUMBER() OVER (PARTITION BY book_id 
        ORDER BY time_created DESC) AS rn
        FROM chapters ) c ON b.id = c.book_id
        WHERE c.rn <= 2 OR c.rn IS NULL
        GROUP BY b.title, b.img, b.tags, b.author, b.id, b.genres, b.status, b.release_date, b.sum_ratings, b.views 
        ORDER BY b.id LIMIT $limit OFFSET $offset ;";  
        
        
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cache the data in Redis
        $redis->set($cacheKey, serialize($result));
        // Set expiration time for the cache (e.g., 1 hour)
        $redis->expire($cacheKey, 86400);
    
}


