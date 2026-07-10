<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>YouTube Clone</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
<div class="header">

<div class="logo">
    <img src="assets/images/image3.jpeg" alt="logo" width="100">

    <span></span>
</div>


    <!-- CENTER: SEARCH -->
    <div class="header-center">
        <form method="GET" action="search.php">
            <input type="text" name="query" placeholder="Search videos..." class="search-box">
            <button type="submit" class="search-btn">🔍</button>
        </form>
    </div>

    <!-- RIGHT: PROFILE -->
    <div class="header-right">
<span class="user-name">
    Hi,  <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : "Guest";
    echo $_SESSION['role']; ?>
</span>  <a href="logout.php" class="logout-btn">
    Logout</a>
    </div>

</div>

    
</header>

<div class="yt-container">

<aside class="yt-sidebar">
    <a href="home.php">Home</a>

<?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
    <a href="upload.php">Upload</a>
<?php } ?>

<a href="profile.php">Profile</a>
<a href="dashboard.php">Dashboard</a>

</aside>

<main class="yt-main">