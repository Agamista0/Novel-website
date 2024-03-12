<?php 
if (session_status() === PHP_SESSION_NONE) {
  session_start();
  $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
} 
if (isset($_SESSION['siteSchema']) && $_SESSION['siteSchema'] === "Dark"){
  echo'<link rel="stylesheet" href="/assets/css/includes/darkmode.css">';
} 
include 'php/advanced.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/advanced.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Advanced</title>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4758581028009642"
     crossorigin="anonymous"></script>
  </head>
  <body>
   <?php include "backtop.php"?>

  <?php include "navbar.php"?>
  
 <form class="form-div" style="position:absloute;" action="advanced" method="GET">
    <div class="search-bar-container">
      <div class="testetests">
        <div class="search-bar-div">
        <input type="text" class="search-bar" name="search_keywords" placeholder="Search..." value="<?php echo isset($_GET['search_keywords']) ? htmlspecialchars($_GET['search_keywords']) : ''; ?>">
          <button type="submit" class="search-btn">
            <i class="fas fa-search"></i>
          </button>
        </div>
        <div href="" class="adcanced-button">Advanced</div>
</div>
      <div class="checkbox-container">
        <div class="checkbox-column">
          <label>
            <input type="checkbox" name="genres[]" value="Action" <?php echo (isset($_GET['genres']) && in_array('Action', $_GET['genres'])) ? 'checked' : ''; ?>> Action </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Adventure"<?php echo (isset($_GET['genres']) && in_array('Adventure', $_GET['genres'])) ? 'checked' : ''; ?>> Adventure </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Comedy" <?php echo (isset($_GET['genres']) && in_array('Comedy', $_GET['genres'])) ? 'checked' : ''; ?>> Comedy </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Drama" <?php echo (isset($_GET['genres']) && in_array('Drama', $_GET['genres'])) ? 'checked' : ''; ?>> Drama </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Eastern" <?php echo (isset($_GET['genres']) && in_array('Eastern', $_GET['genres'])) ? 'checked' : ''; ?>> Eastern </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Ecchi" <?php echo (isset($_GET['genres']) && in_array('Ecchi', $_GET['genres'])) ? 'checked' : ''; ?>> Ecchi </label>
          <br>
        </div>
        <div class="checkbox-column">
          <label>
            <input type="checkbox" name="genres[]" value="Fantasy" <?php echo (isset($_GET['genres']) && in_array('Fantasy', $_GET['genres'])) ? 'checked' : ''; ?>> Fantasy </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Gender Bender" <?php echo (isset($_GET['genres']) && in_array('Gender Bender', $_GET['genres'])) ? 'checked' : ''; ?>> Gender Bender </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Harem" <?php echo (isset($_GET['genres']) && in_array('Harem', $_GET['genres'])) ? 'checked' : ''; ?>> Harem </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Historical" <?php echo (isset($_GET['genres']) && in_array('Historical', $_GET['genres'])) ? 'checked' : ''; ?>> Historical </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Horror" <?php echo (isset($_GET['genres']) && in_array('Horror', $_GET['genres'])) ? 'checked' : ''; ?>> Horror </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Josei" <?php echo (isset($_GET['genres']) && in_array('Josei', $_GET['genres'])) ? 'checked' : ''; ?>> Josei </label>
          <br>
        </div>
        <div class="checkbox-column">
          <label>
            <input type="checkbox" name="genres[]" value="Martial Arts" <?php echo (isset($_GET['genres']) && in_array('Martial Arts', $_GET['genres'])) ? 'checked' : ''; ?>> Martial Arts </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Mature"<?php echo (isset($_GET['genres']) && in_array('Mature', $_GET['genres'])) ? 'checked' : ''; ?>> Mature </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Mecha"<?php echo (isset($_GET['genres']) && in_array('Mecha', $_GET['genres'])) ? 'checked' : ''; ?>> Mecha </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Mystery"<?php echo (isset($_GET['genres']) && in_array('Mystery', $_GET['genres'])) ? 'checked' : ''; ?>> Mystery </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Psychological"<?php echo (isset($_GET['genres']) && in_array('Psychological', $_GET['genres'])) ? 'checked' : ''; ?>> Psychological </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Romance"<?php echo (isset($_GET['genres']) && in_array('Romance', $_GET['genres'])) ? 'checked' : ''; ?>> Romance </label>
          <br>
        </div>
        <div class="checkbox-column">
          <label>
            <input type="checkbox" name="genres[]" value="School Life"<?php echo (isset($_GET['genres']) && in_array('School Life', $_GET['genres'])) ? 'checked' : ''; ?>> School Life </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Sci-fi"<?php echo (isset($_GET['genres']) && in_array('Sci-fi', $_GET['genres'])) ? 'checked' : ''; ?>> Sci-fi </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Seinen"<?php echo (isset($_GET['genres']) && in_array('Seinen', $_GET['genres'])) ? 'checked' : ''; ?>> Seinen </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Shoujo"<?php echo (isset($_GET['genres']) && in_array('Shoujo', $_GET['genres'])) ? 'checked' : ''; ?>> Shoujo </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Shounen"<?php echo (isset($_GET['genres']) && in_array('Shounen', $_GET['genres'])) ? 'checked' : ''; ?>> Shounen </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Slice of Life"<?php echo (isset($_GET['genres']) && in_array('Slice of Life', $_GET['genres'])) ? 'checked' : ''; ?>> Slice of Life </label>
          <br>
        </div>
        <div class="checkbox-column">
          <label>
            <input type="checkbox" name="genres[]" value="Smut"<?php echo (isset($_GET['genres']) && in_array('Smut', $_GET['genres'])) ? 'checked' : ''; ?>> Smut </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Sports"<?php echo (isset($_GET['genres']) && in_array('Sports', $_GET['genres'])) ? 'checked' : ''; ?>> Sports </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Supernatural"<?php echo (isset($_GET['genres']) && in_array('Supernatural', $_GET['genres'])) ? 'checked' : ''; ?>> Supernatural </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Tragedy"<?php echo (isset($_GET['genres']) && in_array('Tragedy', $_GET['genres'])) ? 'checked' : ''; ?>> Tragedy </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Wuxia"<?php echo (isset($_GET['genres']) && in_array('Wuxia', $_GET['genres'])) ? 'checked' : ''; ?>> Wuxia </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Yaoi"<?php echo (isset($_GET['genres']) && in_array('Yaoi', $_GET['genres'])) ? 'checked' : ''; ?>> Yaoi </label>
          <br>
        </div>
        <div class="checkbox-column">
          <label>
            <input type="checkbox" name="genres[]" value="Xianxia"<?php echo (isset($_GET['genres']) && in_array('Xianxia', $_GET['genres'])) ? 'checked' : ''; ?>> Xianxia </label>
          <br>
          <label>
            <input type="checkbox" name="genres[]" value="Xuanhuan"<?php echo (isset($_GET['genres']) && in_array('Xuanhuan', $_GET['genres'])) ? 'checked' : ''; ?>> Xuanhuan </label>
          <br>
        </div>
      </div>
      <div class="more-search-options">
        <div>
          <label for="">Genres condition</label>
          <input type="text" placeholder="All">
        </div>
        <div>
          <label for="">Author</label>
          <input type="text" id="author" name="author" placeholder="Author"  placeholder="Search..." value="<?php echo isset($_GET['author']) ? htmlspecialchars($_GET['author']) : ''; ?>">
        </div>
        <div>
          <label for="year_of_release">Year of Release</label>
          <input type="text" id="year_of_release" name="year_of_release" placeholder="Year"  placeholder="Search..." value="<?php echo isset($_GET['year_of_release']) ? htmlspecialchars($_GET['year_of_release']) : ''; ?>" >
        </div>
        <div>
          <label for="">Adult content</label>
          <input type="text" placeholder="All">
        </div>
        <div >
          <label> Status </label>
          <div class="status-container">
          <div class="checkbox-div">
            <input type="checkbox" name="status" value="Completed" <?php echo (isset($_GET['status']) && $_GET['status'] === 'Completed') ? 'checked' : ''; ?> > <label>Completed </label>
          </div>
          <div  class="checkbox-div">
            <input type="checkbox" name="status" value="Ongoing" <?php echo (isset($_GET['status']) && $_GET['status'] === 'Ongoing') ? 'checked' : ''; ?>> <label>Ongoing </label>
          </div>
        </div>
      </div>
      </div>
      <div class="search-btns">
        <button class="list-search ">Search</button>

        <button class="list-reset" id="reset-button ">Reset</button>
      </div>
    </div>

    </form>
    </div>
    <div class="content">
      <div class="content-header">
        <div class="left-side-header">
          <div class="sqr">
            <i class="fa-solid fa-star"></i>
          </div>
          <p> <?php echo $total_books ?> RESULTS FOR ""</p>
        </div>

        <div class="sort-links-container">
        <ul class="">

        
          <li class="order">Order by </li>
          <li><a href="?sort=relevance&order=desc" class="<?php if(!isset($_GET['sort']) || (isset($_GET['sort']) && $_GET['sort'] == "relevance")) { echo 'highlighted'; } ?>">Relevance</a></li>
          <li><a href="?sort=latest&order=ASC" class="<?php if(isset($_GET['sort']) && $_GET['sort'] == "latest"){echo'highlighted';} ?>">Latest</a></li>
          <li><a href="?sort=a-z&order=asc" class="<?php if(isset($_GET['sort']) && $_GET['sort'] == "a-z" ) {echo'highlighted';} ?>">A-Z</a></li>
          <li><a href="?sort=rating&order=desc" class="<?php if(isset($_GET['sort']) && $_GET['sort'] == "rating" ) {echo'highlighted';} ?>">Rating</a></li>
        </ul>
        <ul>
             <li><a href="?sort=most-views&order=dasc" class="<?php if(isset($_GET['sort'])  && $_GET['sort'] == "most-views" ) {echo'highlighted';} ?>">Most Views</a></li>
            <li><a href="?sort=new&order=dasc" class="<?php if(isset($_GET['sort'])  && $_GET['sort'] == "new" ) {echo'highlighted';} ?>">New</a></li>
        </ul>

        </div>
      </div>
    </div>

    <div>
    <div class="novels-container">
    
    <?php foreach ($books as $book): 

            // Output results
            $title = $book['title'];
            $img = $book['img'];
            $tags = $book['tags'];
            $author = $book['author'];
            $id = $book['id'];
            $genres = $book['genres'];
            $status = $book['status'];
            $release_date = $book['release_date'];
            $ratting =  $book['sum_ratings'];

            $query = "SELECT time_created, chapter_title FROM chapters WHERE book_id = ? ORDER BY time_created DESC LIMIT 1";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$book['id']]);
            $last_chapter = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $lastChTitle = $last_chapter['chapter_title'];
            $words = explode(' ', $lastChTitle);
            $lastChTitle = implode(' ', array_slice($words, 0, 2));

            echo '<div class="novel-card-advanced"  data-id="'.$book['id'].'">';
            echo '<div class="image-container" data-id="'.$book['id'].'">';
            echo '<div class="colorhoverimg"></div>';
            echo '<img class="advanced-img"  src="' . $img . '" alt="' . $title . '">';
            echo '</div>';
            echo '<div class="novel-info">';
            echo '<a class="title-advanced"  data-id="'.$book['id'].'">' . $title . '</a>';
            echo '<div class="more-info">';
            echo '<div class="more-info-div">';
            echo '<p class="ttt">Author</p>';
            echo '<ul class="hhh">';
            echo '<a>' . $author . '</a>';
            echo '</ul>';
            echo '</div>';
            echo '<div class="more-info-div">';
            echo '<p class="ttt">Genres</p>';
            echo '<ul class="hhh">';
            $genreList = explode(',', $book['genres']);
            foreach ($genreList as $genre) {
                echo '<a>'. trim($genre) . '</a>';
            }                       
            echo '</ul>';
            echo '</div>';
            echo '<div class="more-info-div">';
            echo '<p class="ttt">Status</p>';
            echo '<p class="hhh" >' . $status . '</a> </p>';
            echo '</div>';
            echo '</div>';
            echo '<div class="chapter-info">';
            echo '<div class="chapter-info-subdiv">';
            echo '<p class="lattest"> Latest chapter </p>';
            echo '<a  class="chapter-number" href="/chapter/'.$last_chapter['chapter_title'].'">'.$lastChTitle.' </a>';
            echo '<p class="time">'.$last_chapter['time_created'].'</p>';
            echo '</div>';
            echo '<div class="rating normal">';
            echo '<i class="fa-solid fa-star"></i>';
            echo '<i class="fa-solid fa-star"></i>';
            echo '<i class="fa-solid fa-star"></i>';
            echo '<i class="fa-solid fa-star"></i>';
            echo '<i class="fa-solid fa-star"></i>';
            echo '<p class="rating-number">'.$ratting.'</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '<div class="rating phone">';
            echo '<i class="fa-solid fa-star"></i>';
            echo '<i class="fa-solid fa-star"></i>';
            echo '<i class="fa-solid fa-star"></i>';
            echo '<i class="fa-solid fa-star"></i>';
            echo '<i class="fa-solid fa-star"></i>';
            echo '<p class="rating-number">'.$ratting.'</p>';
            echo '</div>';
            echo '</div>';
        
        endforeach; ?>
  </div>
</div>
   



  </div> 
    <?php include "older-posts.php"?>
    <?php include "footer.php"?>
  </body>
  <script>
    const novelCardsadvancedTitle = document.querySelectorAll('.title-advanced');
    const novelCardsadvancedImg = document.querySelectorAll('.image-container');

    
    novelCardsadvancedTitle.forEach(card => {
      card.addEventListener('click', () => {
        const id = card.getAttribute('data-id');
        const url = `/Novel/${id}`;
        window.location.href = url;
      });
    });
    novelCardsadvancedImg.forEach(card => {
      card.addEventListener('click', () => {
        const id = card.getAttribute('data-id');
        const url = `/Novel/${id}`;
        window.location.href = url;
      });
    });
    document.addEventListener('DOMContentLoaded', function () {
      const button = document.querySelector('.adcanced-button');
        const targetElement = document.querySelector('.search-bar-container');
        const targetElement2 = document.querySelector('.checkbox-container');
        const targetElement3 = document.querySelector('.more-search-options');
        const targetElement4 = document.querySelector('.search-btns');

        button.addEventListener('click', function () {
          targetElement.classList.toggle('show');
          targetElement2.classList.toggle('displays2');
          targetElement3.classList.toggle('displays');
          targetElement4.classList.toggle('displays');
        });
      });
      
      document.querySelector('.list-reset').addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false; // Uncheck checkboxes
        });
        
        var inputs = document.querySelectorAll('input[type="text"]');
        inputs.forEach(function(input) {
            input.value = ''; // Clear text inputs
        });
    });


</script>

  </script>
</html>