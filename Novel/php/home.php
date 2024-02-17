<?php
include 'php/db.php' ;
$limit = 20;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;


$query = "SELECT b.title, b.img, b.tags, b.author, b.id, b.genres, b.status, b.release_date, b.sum_ratings,
              MAX(CASE WHEN rn = 1 THEN c.chapter_title END) AS last_chapter_title,
              MAX(CASE WHEN rn = 1 THEN c.time_created END) AS last_chapter_time,
              MAX(CASE WHEN rn = 2 THEN c.chapter_title END) AS penultimate_chapter_title,
              MAX(CASE WHEN rn = 2 THEN c.time_created END) AS penultimate_chapter_time
              FROM books b
              LEFT JOIN ( SELECT book_id, chapter_title, time_created, ROW_NUMBER() OVER (PARTITION BY book_id ORDER BY time_created DESC) AS rn
              FROM chapters ) c ON b.id = c.book_id GROUP BY b.title, b.img, b.tags, b.author, b.id, b.genres, b.status, b.release_date, b.sum_ratings
              ORDER BY b.id LIMIT $limit OFFSET $offset ;";  
          


// Using prepared statement to prevent SQL injection
$stmt = $pdo->prepare($query);
$stmt->execute();

// Fetch all records as an associative array
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
            
            img.addEventListener('click', () => {
                const id = card.getAttribute('data-id');
            //     const url = `php/views-increase?book_id=${id}`;
            //     fetch(url)
            //         .then(response => {
            //             if (!response.ok) {
            //                 throw new Error('Network response was not ok');
            //             }else{
            //               window.location.href = `/Novel/${id}`;

            //             }
            //         })
            //         .catch(error => console.error('Error:', error));
            // 
          });

            title.addEventListener('click', () => {
                const id = card.getAttribute('data-id');
                const url = `php/views-increase?book_id=${id}`;
                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    });
</script>