<?php
include("includes/db.php");
session_start();

$user_id = $_SESSION['user_id'];
$video_id = $_POST['video_id'];

/* Check already disliked? */
$check = mysqli_query($conn,
"SELECT * FROM dislikes
 WHERE user_id='$user_id'
 AND video_id='$video_id'");

if(mysqli_num_rows($check)==0){

    /* Remove like first */
    mysqli_query($conn,
    "DELETE FROM likes
    WHERE user_id='$user_id'
    AND video_id='$video_id'");

    /* Add dislike */
    mysqli_query($conn,
    "INSERT INTO dislikes(user_id,video_id)
    VALUES('$user_id','$video_id')");
}

header("Location: watch.php?id=".$video_id);
exit();
?>