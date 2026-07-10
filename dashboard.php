<?php
session_start();
include("includes/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 'admin') {
    echo "Access Denied!";
    exit();
}

include("includes/header.php");

/* COUNTS */
$users = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) as total FROM users")
);

$videos = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) as total FROM videos")
);

$comments = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) as total FROM comments")
);

$likes = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) as total FROM likes")
);

$dislikes = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) as total FROM dislikes")
);
?>

<style>

.dashboard-container{
    margin-left:220px;
    padding:30px;
}

.dashboard-title{
    text-align:center;
    color:red;
    margin-bottom:30px;
}

.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-bottom:40px;
}

.stat-card{
    background:#111;
    color:white;
    padding:25px;
    border-radius:15px;
    text-align:center;
    box-shadow:0 0 15px rgba(255,0,0,0.3);
}

.stat-card h2{
    color:red;
    font-size:35px;
    margin-bottom:10px;
}

.section-title{
    margin:25px 0 15px;
    color:red;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-bottom:30px;
    background:white;
}

table th{
    background:red;
    color:white;
    padding:10px;
}

table td{
    padding:10px;
    border:1px solid #ddd;
}

.thumb{
    width:100px;
    border-radius:5px;
}

.recent-box{
    background:#111;
    color:white;
    padding:20px;
    border-radius:10px;
    margin-bottom:30px;
}

.recent-box p{
    margin:8px 0;
}

.top-video{
    background:#111;
    color:white;
    padding:20px;
    border-radius:10px;
    margin-bottom:30px;
}

.delete-btn{
    color:red;
    text-decoration:none;
    font-weight:bold;
}

</style>

<div class="dashboard-container">

    <h1 class="dashboard-title">Admin Dashboard</h1>

    <!-- STATISTICS -->
    <div class="stats-grid">

        <div class="stat-card">
            <h2><?php echo $users['total']; ?></h2>
            <p>Total Users</p>
        </div>

        <div class="stat-card">
            <h2><?php echo $videos['total']; ?></h2>
            <p>Total Videos</p>
        </div>

        <div class="stat-card">
            <h2><?php echo $comments['total']; ?></h2>
            <p>Total Comments</p>
        </div>

        <div class="stat-card">
            <h2><?php echo $likes['total']; ?></h2>
            <p>Total Likes</p>
        </div>

        <div class="stat-card">
            <h2><?php echo $dislikes['total']; ?></h2>
            <p>Total Dislikes</p>
        </div>

    </div>

    <!-- MOST LIKED VIDEO -->
    <h2 class="section-title">Most Liked Video</h2>

    <div class="top-video">

        <?php

        $top = mysqli_query($conn,

        "SELECT videos.title,
        COUNT(likes.id) as totalLikes

        FROM videos

        LEFT JOIN likes
        ON videos.id = likes.video_id

        GROUP BY videos.id

        ORDER BY totalLikes DESC

        LIMIT 1");

        if(mysqli_num_rows($top)>0){

            $t = mysqli_fetch_assoc($top);

            echo "<h3>".$t['title']."</h3>";
            echo "<p>Total Likes: ".$t['totalLikes']."</p>";

        }else{

            echo "<p>No liked videos yet.</p>";
        }

        ?>

    </div>

    <!-- RECENT UPLOADS -->
    <h2 class="section-title">Recent Uploads</h2>

    <div class="recent-box">

        <?php

        $recent = mysqli_query($conn,
        "SELECT * FROM videos ORDER BY id DESC LIMIT 5");

        if(mysqli_num_rows($recent)>0){

            while($r = mysqli_fetch_assoc($recent)){

                echo "<p>🎥 ".$r['title']."</p>";
            }

        }else{

            echo "<p>No uploads yet.</p>";
        }

        ?>

    </div>

    <!-- USERS -->
    <h2 class="section-title">All Users</h2>

    <table>

        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
        </tr>

        <?php

        $allUsers = mysqli_query($conn,
        "SELECT * FROM users ORDER BY id DESC");

        while($u = mysqli_fetch_assoc($allUsers)){
        ?>

        <tr>
            <td><?php echo $u['id']; ?></td>
            <td><?php echo $u['name']; ?></td>
            <td><?php echo $u['email']; ?></td>
            <td><?php echo $u['role']; ?></td>
        </tr>

        <?php } ?>

    </table>

    <!-- VIDEOS -->
    <h2 class="section-title">All Videos</h2>

    <table>

        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Thumbnail</th>
            <th>Delete</th>
        </tr>

        <?php

        $allVideos = mysqli_query($conn,
        "SELECT * FROM videos ORDER BY id DESC");

        while($v = mysqli_fetch_assoc($allVideos)){
        ?>

        <tr>

            <td><?php echo $v['id']; ?></td>

            <td><?php echo $v['title']; ?></td>

            <td>
                <?php if(!empty($v['thumbnail'])) { ?>
                    <img src="<?php echo $v['thumbnail']; ?>" class="thumb">
                <?php } ?>
            </td>

            <td>
                <a href="delete_video.php?id=<?php echo $v['id']; ?>"
                   class="delete-btn"
                   onclick="return confirm('Delete this video?')">
                   Delete
                </a>
            </td>

        </tr>

        <?php } ?>

    </table>

</div>

<?php include("includes/footer.php"); ?>