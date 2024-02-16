<?php 
 if (isset($_SESSION['siteSchema']) && $_SESSION['siteSchema'] === "Dark"){
    echo'<link rel="stylesheet" href="assets/css/includes/darkmode.css">';
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/includes/search.css">
    <title>Document</title>
</head>
<body>
    <div class="search-bar-container">
        <div class="testetests">
            <div class="search-bar-div">
                <input type="text" class="search-bar" id="searchInput" placeholder="Search...">
                <button class="search-btn" id="searchButton">
                    Search
                </button>
            </div>
        </div>
    </div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchButton = document.querySelector('.custom-search-button-nav');
        const searchBarContainer = document.querySelector('.search-bar-container');
        const testetests = document.querySelector('.testetests');

        searchButton.addEventListener('click', function() {
            testetests.classList.toggle('show-search');
            searchBarContainer.classList.toggle('show-search-bar');
        });
    });
        document.addEventListener('DOMContentLoaded', function() {
            const searchButton = document.getElementById('searchButton');
            const searchInput = document.getElementById('searchInput');

            searchButton.addEventListener('click', function() {
                const keyword = searchInput.value.trim();
                window.location.href = '/advanced?search_keywords=' + encodeURIComponent(keyword);
            });
        });

</script>
</body>
</html>











