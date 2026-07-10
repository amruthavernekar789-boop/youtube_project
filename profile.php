<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

session_start();
include("includes/db.php");

if (!isset($_SESSION['user_id'])) {
    echo "Login required";
    exit();
}

$user_id = $_SESSION['user_id'];

/* YAHAN SE START */
$user = mysqli_query($conn,
"SELECT * FROM users WHERE id='$user_id'");

if(!$user){
    die(mysqli_error($conn));
}

$user_data = mysqli_fetch_assoc($user);
// Total Videos
$totalVideos = mysqli_num_rows(
    mysqli_query($conn,
    "SELECT * FROM videos WHERE user_id='$user_id'")
);

// Total Likes
$totalLikes = mysqli_fetch_assoc(
    mysqli_query($conn,"
    SELECT COUNT(*) as total
    FROM likes l
    JOIN videos v ON l.video_id=v.id
    WHERE v.user_id='$user_id'
")
);

// Recent Videos
$userVideos = mysqli_query($conn,
"SELECT * FROM videos
WHERE user_id='$user_id'
ORDER BY id DESC
LIMIT 4");


?>
<style>

.profile-container{
    max-width:1000px;
    margin:30px auto;
    padding:20px;
}

.profile-card{
    background:#111;
    color:white;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 0 20px rgba(255,0,0,0.4);
}

.profile-cover{
    height:180px;
    background:linear-gradient(135deg,#ff0000,#990000);
}

.profile-info{
    text-align:center;
    margin-top:-60px;
    padding-bottom:30px;
}

.profile-avatar{
    width:120px;
    height:120px;
    border-radius:50%;
    background:red;
    border:5px solid #111;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:50px;
    margin:auto;
}

.profile-name{
    font-size:30px;
    font-weight:bold;
    margin-top:15px;
}

.profile-email{
    color:#ccc;
    margin-top:5px;
}

.account-type{
    margin-top:10px;
    color:#aaa;
}

.stats{
    display:flex;
    justify-content:center;
    gap:20px;
    margin-top:30px;
    flex-wrap:wrap;
}

.stat-box{
    background:#222;
    width:180px;
    padding:20px;
    border-radius:15px;
}

.stat-box h3{
    color:red;
    font-size:28px;
    margin-bottom:10px;
}

.profile-actions{
    margin-top:30px;
}

.profile-actions a{
    text-decoration:none;
    background:red;
    color:white;
    padding:12px 25px;
    border-radius:10px;
    margin:10px;
    display:inline-block;
}

.profile-actions a:hover{
    background:#cc0000;
}

.recent-section{
    margin-top:40px;
}

.recent-title{
    text-align:center;
    color:white;
    margin-bottom:20px;
}

.video-grid{
    display:flex;
    gap:20px;
    justify-content:center;
    flex-wrap:wrap;
}

.video-card{
    width:220px;
    background:#222;
    border-radius:10px;
    overflow:hidden;
    padding:10px;
}

.video-card img{
    width:100%;
    height:130px;
    object-fit:cover;
    border-radius:8px;
}

.video-card p{
    color:white;
    margin-top:10px;
    text-align:center;
}

</style>

<div class="profile-container">

    <div class="profile-card">

        <div class="profile-cover"></div>

        <div class="profile-info">

            <div class="profile-avatar">
                👤
            </div>

            <div class="profile-name">
                <?php echo $user_data['name']; ?>
            </div>

            <div class="profile-email">
                <?php echo $user_data['email']; ?>
            </div>

            <div class="account-type">
                <?php echo ucfirst($user_data['role']); ?> Account 🎬
            </div>

            
<div class="profile-actions">

    <a href="dashboard.php">📊 Dashboard</a>

</div>

<div style="margin-top:30px;color:#ccc;text-align:center;">
    Welcome to YouTube Clone 🎉<br>
    Explore videos and enjoy the content.
</div>



          

            <div class="recent-section">

                <h2 class="recent-title"></h2>

                <div class="video-grid">

                    <?php
                    if(mysqli_num_rows($userVideos)>0){

                        while($video=mysqli_fetch_assoc($userVideos)){
                    ?>

                    <div class="video-card">

                        <img src="<?php echo $video['thumbnail']; ?>">

                        <p><?php echo $video['title']; ?></p>

                    </div>

                    <?php
                        }

                    } else {

                    }
                    ?>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include("includes/footer.php"); ?>