<?php
include("includes/db.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("includes/header.php");

if (!isset($_GET['id'])) {
    echo "Video not found";
    exit();
}

$id = $_GET['id'];

/* FETCH VIDEO */
$result = mysqli_query($conn, "SELECT * FROM videos WHERE id='$id'");
$video = mysqli_fetch_assoc($result);

if (!$video) {
    echo "Video not found";
    exit();
}

/* LIKE COUNT */
$like_query = mysqli_query(
    $conn,
    "SELECT COUNT(*) as total FROM likes WHERE video_id='$id'"
);
$like_data = mysqli_fetch_assoc($like_query);

/* DISLIKE COUNT */
$dislike_query = mysqli_query(
    $conn,
    "SELECT COUNT(*) as total FROM dislikes WHERE video_id='$id'"
);
$dislike_data = mysqli_fetch_assoc($dislike_query);
?>

<div class="watch-container">

    <div class="video-box">

        <!-- VIDEO -->
        <video controls width="100%">
            <source src="<?php echo $video['video_path']; ?>" type="video/mp4">
        </video>

        <!-- TITLE -->
        <h2 class="video-title">
            <?php echo $video['title']; ?>
        </h2>

        <!-- DESCRIPTION -->
        <p class="video-desc">
            <?php echo nl2br($video['description']); ?>
        </p>

        <!-- LIKE / DISLIKE -->
        <div style="display:flex; gap:10px; margin:15px 0;">

            <form method="POST" action="like.php">
                <input type="hidden" name="video_id" value="<?php echo $id; ?>">

                <button type="submit" class="like-btn">
                    👍 Like (<?php echo $like_data['total']; ?>)
                </button>
            </form>

            <form method="POST" action="dislike.php">
                <input type="hidden" name="video_id" value="<?php echo $id; ?>">

                <button type="submit" class="like-btn">
                    👎 Dislike (<?php echo $dislike_data['total']; ?>)
                </button>
            </form>

        </div>

        <!-- COMMENTS -->
        <h3>Comments</h3>

        <!-- ADD COMMENT -->
        <form method="POST" action="comment.php" class="comment-box">

            <input type="hidden"
                   name="video_id"
                   value="<?php echo $id; ?>">

            <input type="text"
                   name="comment"
                   placeholder="Write comment..."
                   required>

            <button type="submit">Post</button>

        </form>

        <hr>

        <!-- SHOW COMMENTS -->

        <?php

        $comments = mysqli_query(
$conn,
"SELECT comments.*, users.name, users.role
 FROM comments
 LEFT JOIN users ON comments.user_id = users.id
 WHERE comments.video_id='$id'
 ORDER BY comments.id DESC"
);



        if(mysqli_num_rows($comments) > 0){

            while($c = mysqli_fetch_assoc($comments)){

                echo "<p class='comment'>";

                if($c['role'] == 'admin'){
                    echo "<b style='color:red;'>👑 "
                         .$c['name'].
                         " (Admin):</b> ";
                } else {
                    echo "<b>👤 "
                         .$c['name'].
                         ":</b> ";
                }

                echo htmlspecialchars($c['comment']);

                echo "</p>";
            }

        } else {

            echo "<p>No comments yet</p>";
        }

        ?>

    </div>

</div>

<?php include("includes/footer.php"); ?>