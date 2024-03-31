<?php
include "php/db.php";

$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$title = basename($uri_path);
$chapter_id = urldecode($title); 

// Fetch comments from the database
$stmt = $pdo->prepare("SELECT * FROM comments WHERE chapter_id = ?");
$stmt->execute([$chapter_id]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);


$replies_display_id = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Comment Section</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>

    .notvisibile{
        display:none !important;
    }
        #view-more-replies{
            display:flex;
            align-items:center;
            color:#52aa6d;
        }


        #view-more-replies i{
            margin-left:5px;
        }
        .fa-chevron-up{
        margin-bottom:-3px !important;
      }


        .comment-section {
            width:73%;
            margin: 60px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
        }

        .comment {
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            position: relative;
        }

        .comment:last-child {
            margin-bottom: 0;
            border-bottom: none;
            padding-bottom: 0;
        }

        .author {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .timestamp {
            color: #888;
            font-size: 0.9em;
        }

        .content {
            margin-top: 5px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .comment-form {
            margin-top: 20px;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }

        .comment-form textarea {
            width:  97%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: vertical;
        }

        .comment-form button {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 17px;
            width: auto;
            height: 25px;
            border: none;
            background: linear-gradient(to right, #52aa6d 40%, #67A97B 60%);
            color: #fff;
            font-size: 0.9em;
            cursor: pointer;
            border-radius: 17px;
            margin-left: auto;
            margin-top: 10px;
            font-weight: 600;
        }

        .action-buttons {
            position: relative;
            /* Changed to relative */
            margin-top: 10px;
            /* Adjusted margin for spacing */
        }

        .action-buttons button {
            margin-right: 5px;
            border: none;
            background: none;
            cursor: pointer;
        }

        /* Responsive design */
        @media only screen and (max-width: 600px) {
            .comment-section {
                padding: 10px;
            }
        }

        .highlighted-btn {
            color: red;
        }

        .highlighted-btn-like {
            color: blue;
        }
        .reply{
            padding-left:5%;
            margin-top:20px;
            border-top: 1px solid #eee !important;
            border:0px;
            padding-top:25px !important;
        }
        .view-more-replies-container {
            margin-top:20px;
            margin-bottom:20px;
            width:100%;
            display: flex;
            align-items:center;
        } 
       .view-more-replies-container button {
        background-color:transparent;
        border:0px;
        font-size:17px;
        }
        .reply-buttons-container button{
            margin-right:10px;
    border: 0 !important;
    font-size: 15px !important;
    background-color: transparent !important;
    margin-top: 5px !important;
}
#reply-text{
    font-size: 15px;
    border: 0px;
    border-bottom: 1px solid black;
    padding:10px;
    width:50% !important;
}
.reply-section-container input{
    margin-top:20px;
    margin-left:20px;

}
.reply-buttons-container{
    margin-left:20px;
}
.reply-section-container{
    display:none;

}
.viewreplyoptions{
    display:block;
}
    </style>
</head>
<body>
<div class="comment-section">
    <form class="comment-form" method="POST" action="/php/submit-comment">
        <input type="hidden" name="chapter_id" value="<?php echo $chapter_id; ?>">
        <input type="hidden" name="user_id" value="<?php if (isset($_SESSION['user_id'])) { echo $_SESSION['user_id']; } else { header("Location: login.php"); exit(); } ?>">
        <textarea name="comment" placeholder="Write your comment here"></textarea>
        <button type="submit">Submit</button>
    </form>

    <?php foreach ($comments as $comment): ?>
        <?php 
         $stmt = $pdo->prepare("SELECT * FROM replies where comment_id = ?");
         $stmt->execute([$comment['id']]);
         $hasRepliesCheck = $stmt->fetchAll(PDO::FETCH_ASSOC);
         if ($hasRepliesCheck == null){
             $hasReplies = 0;
         }
         else{
            $hasReplies = 1;
         }

         $stmt = $pdo->prepare("SELECT * FROM liked_comments where user_id = ? and comment_id = ?");
         $stmt->execute([$_SESSION['user_id'], $comment['id']]);
         $liked_comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
         if ($liked_comments == null){
             $comment_is_liked = 0;
         }
         else{
             $comment_is_liked = 1;
         }
         
         $stmt = $pdo->prepare("SELECT * FROM disliked_comments where user_id = ? and comment_id = ?");
         $stmt->execute([$_SESSION['user_id'], $comment['id']]);
         $disliked_comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
         if ($disliked_comments == null){
             $comment_is_disliked = 0;
         }
         else{
             $comment_is_disliked = 1;
         }
         $stmt = $pdo->prepare("SELECT username , profile_image FROM users WHERE id = ?");
         $stmt->execute([$comment['user_id']]);
         $commenter_info = $stmt->fetchAll(PDO::FETCH_ASSOC);
         $commentername = $commenter_info[0]['username'];
         $commenterImg = $commenter_info[0]['profile_image'];

         
        ?>
        <div class="comment">
            <img src="<?php echo $commenterImg ?>" alt="User Avatar" class="avatar">
            <div class="author"><?php echo  $commentername;?></div>
            <div class="timestamp"><?php echo $comment['time_created']; ?></div>
            <div class="content"><?php echo $comment['comment_text']; ?></div>
            <div class="action-buttons">
                <button comment-id="<?php echo $comment['id']; ?>" class="like-btn <?php if(isset( $comment_is_liked) && $comment_is_liked === 1) { echo "highlighted-btn-like"; } ?>"><i class="far fa-thumbs-up"></i> <span class="like-count"><?php echo $comment['likes']; ?></span></button>
                <button comment-id="<?php echo $comment['id']; ?>" class="dislike-btn <?php if(isset($comment_is_disliked) && $comment_is_disliked === 1) { echo "highlighted-btn"; } ?>"><i class="far fa-thumbs-down"></i> <span class="dislike-count"><?php echo $comment['dislikes']; ?></span></button>
                <button class="reply-button">Reply</button>
            </div>          

            <div class="reply-section-container">
    <input type="text" id="reply-text" placeholder="Add a reply...">
    <div class="reply-buttons-container" >
        <button class="submit-reply-btn" comment-id="<?php echo $comment['id']; ?>">Reply</button>
    </div><input type="hidden" class="comment_id_for_reply" comment_id = "<?php $comment_id = $comment['id']; ?>">
    </div>
  <div class="replies-container" id="replies-container-<?php echo $comment['id']; ?>">
    <!-- Replies will be dynamically loaded here -->
</div>

  <?php 

include "replies.php";  
    ?>
        <div class="view-replies-btn view-more-replies-container <?php if ($hasReplies == 0) {echo 'notvisibile';} ?>" data-comment-id="<?php echo $comment['id']; ?>"  id="replies-container" >
    <button id="view-more-replies" comment-id="<?php echo $comment['id']; ?>" class="">
    view more replies <i class="fa-solid fa-chevron-down"></i>
    </button>
</div></div>
    <?php endforeach; ?>

    <!-- More comments go here -->

</div>
<script>
 $(document).ready(function() {
    // Function to handle like button click
    $('.like-btn').click(function() {
        var likeButton = $(this);
        var dislikeButton = $(this).siblings('.dislike-btn');
        var likeCount = parseInt(likeButton.find('.like-count').text());
        var dislikeCount = parseInt(dislikeButton.find('.dislike-count').text());

        if (likeButton.hasClass('highlighted-btn-like')) {
            // User already liked the comment, so remove the like
            likeCount--;
            likeButton.removeClass('highlighted-btn-like');
        } else {
            // User did not like the comment, so add the like
            likeCount++;
            // Check if user previously disliked the comment, if yes, remove the dislike
            if (dislikeButton.hasClass('highlighted-btn')) {
                dislikeButton.removeClass('highlighted-btn');
                dislikeCount--;
                dislikeButton.find('.dislike-count').text(dislikeCount);
            }
            likeButton.addClass('highlighted-btn-like');
        }

        likeButton.find('.like-count').text(likeCount);

        var commentId = likeButton.attr('comment-id');

        $.ajax({
            url: '/php/likes',
            type: 'POST',
            data: { action: 'like', count: likeCount, comment_id: commentId },
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    // Function to handle dislike button click
    $('.dislike-btn').click(function() {
        var dislikeButton = $(this);
        var likeButton = $(this).siblings('.like-btn');
        var dislikeCount = parseInt(dislikeButton.find('.dislike-count').text());
        var likeCount = parseInt(likeButton.find('.like-count').text());

        if (dislikeButton.hasClass('highlighted-btn')) {
            dislikeCount--;
            dislikeButton.removeClass('highlighted-btn');
        } else {
            dislikeCount++;
            if (likeButton.hasClass('highlighted-btn-like')) {
                likeButton.removeClass('highlighted-btn-like');
                likeCount--;
                likeButton.find('.like-count').text(likeCount);
            }
            dislikeButton.addClass('highlighted-btn');
        }

        dislikeButton.find('.dislike-count').text(dislikeCount);

        var commentId = dislikeButton.attr('comment-id');

        $.ajax({
            url: '/php/dislikes',
            type: 'POST',
            data: { action: 'dislike', count: dislikeCount, comment_id: commentId },
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});

$(document).ready(function() {
    $(document).on('click', '.submit-reply-btn', function() {
        var commentId = $(this).attr('comment-id'); 
        var replyText = $(this).closest('.reply-section-container').find('#reply-text').val();

        console.log("Comment ID:", commentId);
        console.log("Reply Text:", replyText);

        $.ajax({
            type: 'POST',
            url: '/php/add_reply', 
            data: {
                comment_id: commentId,
                reply_text: replyText
            },
            success: function(response) {
                console.log("Response:", response);
                $('#replies-container').append(response);
                $('#reply-text').val(''); 
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    $(document).on('click', '.cancel-reply-btn', function() {
        $(this).closest('.reply-section-container').find('#reply-text').val('');
    });
});


$(document).ready(function() {
    $('.view-replies-btn').click(function() {
        var commentId = $(this).data('comment-id');
        var repliesContainer = $('#replies-container-' + commentId);
        var viewButton = $(this);

        $.ajax({
            url: '/replies',
            type: 'POST',
            data: { comment_id: commentId },
            success: function(response) {
                if (response.trim() !== '' && !repliesContainer.hasClass('showed')) {
                    repliesContainer.addClass('showed');
                    repliesContainer.html(response);
                    viewButton.find('.button-text').text('View Less Replies');
                    viewButton.find('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
                } else {
                    repliesContainer.empty();
                    repliesContainer.removeClass('showed');
                    viewButton.find('.button-text').text('View More Replies');
                    viewButton.find('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching replies:', error);
            }
        });
    });
});


document.addEventListener("DOMContentLoaded", function(){
     var replyButtons = document.querySelectorAll(".reply-button");
    var cancelReplyBtns = document.querySelectorAll(".cancel-reply-btn");
    // Select all elements with the class ".reply-section-container"
    var replyButtonContainers = document.querySelectorAll(".reply-section-container");

    // Attach click event listeners to all reply buttons
    replyButtons.forEach(function(replyButton, index) {
        replyButton.addEventListener("click", function(){
            // Toggle the class on the corresponding reply button container
            replyButtonContainers[index].classList.toggle("viewreplyoptions");
            
        });
    });

    // Attach click event listeners to all cancel reply buttons
    cancelReplyBtns.forEach(function(cancelReplyBtn, index) {
        cancelReplyBtn.addEventListener("click", function(){
            console.log('as');
            replyButtonContainers[index].classList.remove("viewreplyoptions");
        });
    });
});


</script>

 
</body>
</html>