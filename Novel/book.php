<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
} 
if (isset($_SESSION['siteSchema']) && $_SESSION['siteSchema'] === "Dark"){
    echo'<link rel="stylesheet" href="/assets/css/includes/darkmode.css">';
} 
$userId=null ;
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
}
$bookId = $_GET['book_id'];

include "php/db.php" ;

$query_book = "SELECT * FROM (SELECT * ,ROW_NUMBER() OVER (ORDER BY views DESC) AS book_rank FROM books)AS ranked_books WHERE id =:book_id";
$stmt_book = $pdo->prepare($query_book);
$stmt_book->bindParam(':book_id', $_GET['book_id']);
$stmt_book->execute();
$book = $stmt_book->fetch(PDO::FETCH_ASSOC);


$query_chapters = "SELECT * FROM chapters WHERE book_id = :book_id ORDER BY time_created DESC";
$stmt_chapters = $pdo->prepare($query_chapters);
$stmt_chapters->bindParam(':book_id', $_GET['book_id']);
$stmt_chapters->execute();
$chapters = $stmt_chapters->fetchAll(PDO::FETCH_ASSOC);

$query_count_chapters = "SELECT COUNT(*) AS num_chapters FROM chapters WHERE book_id = :book_id";
$stmt_count_chapters = $pdo->prepare($query_count_chapters);
$stmt_count_chapters->bindParam(':book_id', $_GET['book_id']);
$stmt_count_chapters->execute();
$count_result = $stmt_count_chapters->fetch(PDO::FETCH_ASSOC);
$num_chapters = $count_result['num_chapters'];


$stmt = $pdo->prepare("SELECT book_id FROM bookmarks WHERE user_id = ? AND book_id = ?");
$stmt->execute([$userId, $bookId]);
$existingBookmark = $stmt->fetch();

if ($existingBookmark) {
     $bookmarked_or_not = 0;
} else {
     $bookmarked_or_not = 1;
}
$genreList = explode(',', $book['genres']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/book.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title><?php echo $book['title']; ?></title>
</head>
<?php include "search-bar.php"?>
  <?php include "backtop.php"?>

  <?php include "navbar.php"?>
<body>
    <div class="novel-container-books">


        <div class="category-link-div">
            <a href="/" class="category-link">Home/</a>
            <a href="/advanced?genres%5B%5D=<?php echo urlencode(trim($genreList[0])); ?>">
                         Category - <?php echo $genreList[0]; ?> 
                           </a>
            <a href="" class="category-link">/<?php echo $book['title']; ?></a>
        </div>
             <div class="novel-info-div">
                <div class="image-container">
                    <img src="<?php echo $book['img']; ?>" alt="">
                    <div class="info-for-phone">
                        <div class="category-link-div-for-phone">
                    <div class="options-phone">

                    <a href="/advanced?genres%5B%5D=<?php echo urlencode(trim($genreList[0])); ?>">
                         Category - <?php echo $genreList[0]; ?> 
                           </a>
                           <button class="bookmarks-btn bookmarks-btn-phone" id="bookmarks" data-id="<?php echo $_GET['book_id']?>">
                           <?php if ($bookmarked_or_not === 1){
                    echo "<i class='fa-solid fa-bookmark' ></i><p class='Bookmarked-p'>Bookmarked</p>
                    ";
                }
                else {echo"<i class='fa-solid fa-check check-bookmarks-phone'></i><p class='Bookmarked-p'>Bookmarked</p>";}?>
            </button>
</div>
                           <p class="title-for-phone">Alchemy Emperor of the Divine Dao</p>
                        <div class="info-links-phone">
                            <p class="">Completed . <?php echo $book['views'] ?> Views</p>
                            <p>Ranked <?php echo $book['book_rank'] ?>th</p>
                            <p class=""><?php echo $num_chapters ?> chapters </p>
                        </div>
                        </div>
                    </div>
                </div>
    
                <div class="novel-info">
                <div class="rating" id="rating">
                    <span class="star" data-value="1">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="5">&#9733;</span>
                </div>

                <div class="novel-header">
                <p class="book-title"><?php echo $book['title']; ?></p><button class="bookmarks-btn bookmarks-btn-normal" data-id="<?php echo $_GET['book_id']?>">
                <div class="bookmarked-div">
                <?php if ($bookmarked_or_not === 1){
                    echo "<i class='fa-solid fa-bookmark check-bookmarks-normal'></i>
                    <p>Bookmark</p>";
                }
                else {echo"<i class='fa-solid fa-check'></i><p>Bookmarked</p>";}?>
            </button>
</div>    
    
                    <div class="novel-info-p-div">
                       
                        <div class="info-links">
                            <div><p><i class="fa-solid fa-pen"></i> <?php echo $book['status']; ?></p></div>
                            <div><p><i class="fa-solid fa-book"></i> <?php echo $num_chapters; ?> Chapters</p></div>
                            <div><p><i class="fa-solid fa-ranking-star"></i> Ranked 
                                <?php
                                    // Determine the ordinal suffix based on the book rank
                                    
                                    switch ($book['book_rank']) {
                                        case 1:
                                            echo $suffix = "1st";
                                            break;
                                        case 2:
                                            echo "2nd";
                                            break;
                                        case 3:
                                            echo "3rd";
                                            break;
                                        default:
                                            echo $book['book_rank'] . "th";
                                            break;
                                    }
                                    ?>  
                             </p></div>
                            <div><p><i class="fa-solid fa-eye"></i><?php echo $book['views']?> Views</p></div>
                        </div>
                    </div>
    
    
                    <div class="novel-info-p-div">
                        <p class="novel-info-p">Author(s)</p>
                        <a href="/advanced?author=<?php echo $book['author'];?>" class="tag-link"><?php echo $book['author'];?></a>
                    </div>
    
    
                    <div class="novel-info-p-div">
                        <p class="novel-info-p">Genre(s)</p>
                        <div>  
                            <?php
                                   foreach ($genreList as $genre) {
                                        echo '<a href="/advanced?genres%5B%5D='.trim($genre).'" class="tag-link"> ' .trim($genre). ' </a>';
                                    } ?>                         
                        </div>
                    </div>
    
    
                    <div class="novel-info-p-div">
                        <p class="novel-info-p">Type</p>
                        <a href="/advanced?tags=<?php echo $book['tags'];?>" class="tag-link"><?php echo $book['tags'];?></a>
                    </div>
    
    
                    <div class="btns">
                        <button id="readFirstBtn">Read First</button>
                        <button id="readLastBtn">Read Last</button>
                    </div>
                        
    
                </div>
            </div>   
    </div>
    <div class="summary">
        <div class="content-header">
            <div class="left-side-header"> 
                <div class="sqr"><i class="fa-solid fa-star"></i></div>
            <p>SUMMARY</p>
        </div>
          
        </div>
        <div class="desc-div">
            <h3>Description</h3>
            <div class="desc">
              <p> <?php echo $book['Synopsis'];?>
              </p>
            </div>
        </div>
        </div>
    </div>
    <div class="summary">
    <div class="content-header">
        <div class="left-side-header">
            <div class="sqr"><i class="fa-solid fa-star"></i></div>
            <p>LATEST CHAPTERS</p>
            <i class="fa-solid fa-arrow-up-wide-short"></i>
        </div>
    </div>
    <div class="chapters">
        <?php 
         foreach ($chapters as $index => $chapter):  
            $current_time = time();
            $chapter_time = strtotime($chapter['time_created']);
            $time_difference = $current_time - $chapter_time;

             if ($time_difference < 60) {
                $time_display = $time_difference . ' seconds ago';
            } elseif ($time_difference < 3600) {
                $time_display = floor($time_difference / 60) . ' minutes ago';
            } elseif ($time_difference < 86400) {
                $time_display = floor($time_difference / 3600) . ' hours ago';
            } elseif ($time_difference < 2073600) {
                $time_display = floor($time_difference / 86400) . ' days ago'; 
            } else {
                $time_display = date('F j, Y', $chapter_time);
            }  ?>
            <div class="chapter-row" data-title="<?php echo urlencode($chapter['chapter_title']);?>"  data-id="<?php echo $chapter['id'];?>" data-time="<?php echo $chapter['time_created']; ?>">
                <a><?php echo $chapter['chapter_title']; ?></a>
                <p class="time"><?php echo $time_display; ?></p>
            </div>
        <?php endforeach; ?>
       
    </div>        
 
</div>
<div class="Show-More-Div">
            <a class="Show-More-Btn" id="showMoreBtn">
                Show more <i class="fa-solid fa-chevron-down"></i>
            </a>
        </div>
<div class="popular-included" style="width:25%; margin-left:12%;">
<?php include "popular-sections.php"?>

</div>
<?php include "footer.php"?>
<script src="/scripts/sort.js"></script>
<script>
       const novelCardsbook = document.querySelectorAll('.chapter-row');

       novelCardsbook.forEach(card => {
        card.addEventListener('click', () => {
                const title = card.getAttribute('data-title');
                const url = `/chapter/${title}`;
                window.location.href = url;
        });
        });
      


    $(document).ready(function(){
     function updateButtonUI(button, isBookmarked) {
        if (isBookmarked) {
            button.html('<i class="fa-solid fa-check"></i><p>Bookmarked</p>');
        } else {
            button.html('<i class="fa-solid fa-bookmark"></i><p>Bookmark</p>');
        }
    }

     $('.novel-container-books').on('click', '.bookmarks-btn-normal, .bookmarks-btn-phone', function(){
        var button = $(this);
        var bookId = button.data('id');
        // Check if the user is logged in (you can adjust this condition as per your session management)
        var isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;

        // If the user is not logged in, open the login modal
        if (!isLoggedIn) {
            var modalLogin = document.querySelector('.modal-login');
            modalLogin.style.display = 'flex';
        } else {
            // If the user is logged in, proceed to the user settings page
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
        }});
});
 



$(document).ready(function() {
    $('.chapter-row').click(function() {
        var chapterId = $(this).data('id');

        $.ajax({
            url: '/php/save_to_history',
            type: 'POST',
            data: {
                chapterId: chapterId,
            },
            success: function(response) {
                 console.log(response);
            },
            error: function(xhr, status, error) {
                 console.error(xhr.responseText);
            }
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
  const stars = document.querySelectorAll('.star');
  
  stars.forEach(function(star) {
    star.addEventListener('click', function() {
      const value = parseInt(star.getAttribute('data-value'));
      resetStars();
      for (let i = 0; i < value; i++) {
        stars[i].classList.add('active');
      }
      sendRating(value);
    });
  });
  
  function resetStars() {
    stars.forEach(function(star) {
      star.classList.remove('active');
    });
  }

  function sendRating(value) {
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          console.log(xhr.responseText);
        } else {
          console.error('Error:', xhr.status);
        }
      }
    };
    xhr.open('POST', 'save_rating', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('rating=' + encodeURIComponent(value));
  }
});

document.addEventListener('DOMContentLoaded', function() {
    // Function to handle "Read First" button click
    document.querySelector('#readLastBtn').addEventListener('click', function() {
        const firstChapter = document.querySelector('.chapter-row');
        if (firstChapter) {
            const chapterTitle = firstChapter.getAttribute('data-title');
            window.location.href = `/chapter/${chapterTitle}`;
        } else {
            alert('No chapters available.');
        }
    });

    // Function to handle "Read Last" button click
    document.querySelector('#readFirstBtn').addEventListener('click', function() {
        const chapters = document.querySelectorAll('.chapter-row');
        if (chapters.length > 0) {
            const lastChapter = chapters[chapters.length - 1];
            const chapterTitle = lastChapter.getAttribute('data-title');
            window.location.href = `/chapter/${chapterTitle}`;
        } else {
            alert('No chapters available.');
        }
    });
});





</script>


</body>

</html>