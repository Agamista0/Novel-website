<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/includes/backtop.css">
    <title>Document</title>
</head>
<body>
    <div class="backtotop" id="backToTopBtn"  onclick="backToTop()">
    <i class="fa-solid fa-arrow-up"></i>
    </div>
</body>
<script>
 function backToTop() {
  document.body.scrollTop = 0; 
  document.documentElement.scrollTop = 0;  
}

 window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.documentElement.scrollTop > 20) {
    document.getElementById("backToTopBtn").style.display = "flex";
  } else {
    document.getElementById("backToTopBtn").style.display = "none";
  }
}

</script>
</html>