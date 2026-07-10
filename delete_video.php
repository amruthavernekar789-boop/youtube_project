<?php
session_start();
include("includes/db.php");

if($_SESSION['role'] != 'admin'){
    exit();
}

$id = $_GET['id'];

mysqli_query($conn,
"DELETE FROM videos WHERE id='$id'");

header("Location: dashboard.php");
exit();
?>