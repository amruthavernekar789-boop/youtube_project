<?php
session_start();
include("includes/db.php");

$video_id = $_POST['video_id'];
$comment = $_POST['comment'];
$user_id = $_SESSION['user_id'];

mysqli_query($conn,
"INSERT INTO comments(video_id,user_id,comment)
VALUES('$video_id','$user_id','$comment')");

header("Location: watch.php?id=$video_id");
exit();
?>