<?php

include "php/db.php";

// Pagination variables
$limit = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Sorting options
$sortOptions = [
    'relevance' => 'title', // Default sort by title
    'latest' => 'release_date',
    'a-z' => 'title',
    'rating' => 'sum_ratings',
    'trending' => 'trending_column', // Replace 'trending_column' with actual column name
    'most-views' => 'views', // Replace 'views_column' with actual column name
    'new' => 'release_date'
];

$sort = isset($_GET['sort']) && isset($sortOptions[$_GET['sort']]) ? $_GET['sort'] : 'relevance'; // Default to relevance
$order = isset($_GET['order']) && $_GET['order'] === 'asc' ? 'asc' : 'desc'; // Default to descending order

// Search keyword
$search_keywords = isset($_GET['search_keywords']) ? htmlspecialchars($_GET['search_keywords']) : '';

// Advanced search options

$genres = isset($_GET['genres']) ? $_GET['genres'] : '';
$author = isset($_GET['author']) ? $_GET['author'] : '';
$year_of_release = isset($_GET['year_of_release']) ? $_GET['year_of_release'] : '';
$adult_content = isset($_GET['adult_content']) ? $_GET['adult_content'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$author = isset($_GET['author']) ? $_GET['author'] : '';
$tags = isset($_GET['tags']) ? $_GET['tags'] : '';



// Construct the WHERE clause for advanced search options
$where_clause = "WHERE title LIKE ?";
$params = ["%$search_keywords%"];

if (!empty($genres)) {
    $genre_conditions = [];
    foreach ($genres as $genre) {
        $genre_conditions[] = "FIND_IN_SET(?, genres)";
        $params[] = $genre;
    }
    $where_clause .= " AND (" . implode(" OR ", $genre_conditions) . ")";
} 

if (!empty($tags)) {
    $where_clause .= " AND tags = ?";
    $params[] = $tags ;
}

if (!empty($author)) {
    $where_clause .= " AND author = ?";
    $params[] = $author;
}

if (!empty($year_of_release)) {
    $where_clause .= " AND YEAR(release_date) = ?";
    $params[] = $year_of_release;
}

if (!empty($adult_content)) {
    $where_clause .= " AND adult_content = ?";
    $params[] = $adult_content;
}

if (!empty($status)) {
    $where_clause .= " AND status = ?";
    $params[] = $status;
}

$query = "SELECT title, img, tags, author, id, genres, status, release_date, sum_ratings
          FROM books 
          $where_clause
          ORDER BY {$sortOptions[$sort]} $order 
          LIMIT $limit OFFSET $offset";

$stmt = $pdo->prepare($query);
$stmt->execute($params); // Pass $params array to execute method
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Count total number of books for pagination
$total_books_query = "SELECT COUNT(*) as total FROM books $where_clause";
$total_stmt = $pdo->prepare($total_books_query);
$total_stmt->execute($params);
$total_books = $total_stmt->fetch(PDO::FETCH_ASSOC)['total'];
$total_pages = ceil($total_books / $limit);


$total_books_query = "SELECT COUNT(*) as total_books FROM books $where_clause";
$total_stmt = $pdo->prepare($total_books_query);
$total_stmt->execute($params);
$total_books = $total_stmt->fetch(PDO::FETCH_ASSOC)['total_books'];


?>