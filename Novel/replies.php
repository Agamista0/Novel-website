<?php 
include "php/db.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$comment_id = null;
if (isset($_POST['comment_id'])) {
    $comment_id = $_POST['comment_id']; 
} 

  
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle POST request to fetch initial replies
    $stmt = $pdo->prepare("SELECT * FROM replies WHERE comment_id = ? ORDER BY time_created ASC ");
    $stmt->bindValue(1, $comment_id, PDO::PARAM_INT);
    $stmt->execute();
    $replies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the replies
    foreach ($replies as $reply) {
        $stmt = $pdo->prepare("SELECT username , profile_image FROM users WHERE id = ?");
        $stmt->execute([$reply['user_id']]);
        $reply_info = $stmt->fetch(PDO::FETCH_ASSOC);
        $Rplyname = $reply_info['username'];
        $RplyImg = $reply_info['profile_image'];

        ?>
        <div class="comment reply">
            <img src="<?php echo $RplyImg ?>" alt="User Avatar" class="avatar">
            <div class="author"><?php echo $Rplyname; ?></div>
            <div class="timestamp"><?php echo $reply['time_created']; ?></div>
            <div class="content"><?php echo $reply['reply_text']; ?></div>
            <div class="action-buttons">
                <?php 
                    $stmt = $pdo->prepare("SELECT * FROM liked_replies WHERE user_id = ? AND reply_id = ?");
                    $stmt->execute([$_SESSION['user_id'], $reply['reply_id']]);
                    $liked_replies = $stmt->fetch(PDO::FETCH_ASSOC);
                    $replies_is_liked = $liked_replies ? 1 : 0;
                    
                    $stmt = $pdo->prepare("SELECT * FROM disliked_replies WHERE user_id = ? AND reply_id = ?");
                    $stmt->execute([$_SESSION['user_id'], $reply['reply_id']]);
                    $disliked_replies = $stmt->fetch(PDO::FETCH_ASSOC);
                    $replies_is_disliked = $disliked_replies ? 1 : 0;
                ?>
                <button reply-id="<?php echo $reply['reply_id']; ?>" class="like-btn-reply <?php if($replies_is_liked) { echo "highlighted-btn-like"; } ?>"><i class="far fa-thumbs-up"></i> <span class="like-count-reply"><?php echo $reply['likes']; ?></span></button>
                <button reply-id="<?php echo $reply['reply_id']; ?>" class="dislike-btn-reply <?php if($replies_is_disliked) { echo "highlighted-btn"; } ?>"><i class="far fa-thumbs-down"></i> <span class="dislike-count-reply"><?php echo $reply['dislikes']; ?></span></button>
             </div>
        </div>
        <?php
    }
}
 
 elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Handle GET request to fetch additional replies
    $stmt = $pdo->prepare("SELECT * FROM replies WHERE comment_id = ?");
    $stmt->bindValue(1, $comment_id, PDO::PARAM_INT);
      $stmt->execute();
    $replies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the replies
    foreach ($replies as $reply) {
        $stmt = $pdo->prepare("SELECT username ,profile_image FROM users WHERE id = ?");
        $stmt->execute([$reply['user_id']]);
        $reply_info = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $Rplyname = $reply_info[0]['username'];
        $RplyImg = $reply_info[0]['profile_image'];
        
        ?>
        <div class="comment reply">
            <img src="<?php echo $RplyImg ?>" alt="User Avatar" class="avatar">
            <div class="author"><?php echo $Rplyname; ?></div>
            <div class="timestamp"><?php echo $reply['time_created']; ?></div>
            <div class="content"><?php echo $reply['reply_text']; ?></div>
            <div class="action-buttons">
            <button reply-id="<?php echo $reply['reply_id']; ?>" class="like-btn-reply <?php if(isset( $replies_is_liked) && $replies_is_liked === 1) { echo "highlighted-btn-like"; } ?>"><i class="far fa-thumbs-up"></i> <span class="like-count-reply"><?php echo $reply['likes']; ?></span></button>
                <button reply-id="<?php echo $reply['reply_id']; ?>" class="dislike-btn-reply <?php if(isset($replies_is_disliked) && $replies_is_disliked === 1) { echo "highlighted-btn"; } ?>"><i class="far fa-thumbs-down"></i> <span class="dislike-count-reply"><?php echo $reply['dislikes']; ?></span></button>
             </div>
            </div>
        </div>
        <?php
    }
}
?>

    <script>
        $(document).ready(function() {
    // Function to handle like button click
    $('.like-btn-reply').click(function() {
        var likeButtonreply = $(this);
        var dislikeButtonreply = $(this).siblings('.dislike-btn-reply');
        var likeCountreply = parseInt(likeButtonreply.find('.like-count-reply').text());
        var dislikeCountreply = parseInt(dislikeButtonreply.find('.dislike-count-reply').text());

        if (likeButtonreply.hasClass('highlighted-btn-like')) {
            // User already liked the comment, so remove the like
            likeCountreply--;
            likeButtonreply.removeClass('highlighted-btn-like');
        } else {
            // User did not like the comment, so add the like
            likeCountreply++;
            // Check if user previously disliked the comment, if yes, remove the dislike
            if (dislikeButtonreply.hasClass('highlighted-btn')) {
                dislikeButtonreply.removeClass('highlighted-btn');
                dislikeCountreply--;
                dislikeButtonreply.find('.dislike-count-reply').text(dislikeCountreply);
            }
            likeButtonreply.addClass('highlighted-btn-like');
        }

        likeButtonreply.find('.like-count-reply').text(likeCountreply);

        var commentIdreply = likeButtonreply.attr('reply-id');
console.log(commentIdreply)
        $.ajax({
            url: '/php/like_reply',
            type: 'POST',
            data: { action: 'like', count: likeCountreply, reply_id: commentIdreply },
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    // Function to handle dislike button click
    $('.dislike-btn-reply').click(function() {
        var dislikeButtonreply = $(this);
        var likeButtonreply = $(this).siblings('.like-btn-reply');
        var dislikeCountreply = parseInt(dislikeButtonreply.find('.dislike-count-reply').text());
        var likeCountreply = parseInt(likeButtonreply.find('.like-count-reply').text());

        if (dislikeButtonreply.hasClass('highlighted-btn')) {
            dislikeCountreply--;
            dislikeButtonreply.removeClass('highlighted-btn');
        } else {
            dislikeCountreply++;
            if (likeButtonreply.hasClass('highlighted-btn-like')) {
                likeButtonreply.removeClass('highlighted-btn-like');
                likeCountreply--;
                likeButtonreply.find('.like-count-reply').text(likeCountreply);
            }
            dislikeButtonreply.addClass('highlighted-btn');
        }

        dislikeButtonreply.find('.dislike-count-reply').text(dislikeCountreply);

        var commentIdreply = dislikeButtonreply.attr('reply-id');

        $.ajax({
            url: '/php/dislike_reply.php',
            type: 'POST',
            data: { action: 'dislike', count: dislikeCountreply, reply_id: commentIdreply },
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});
    </script>