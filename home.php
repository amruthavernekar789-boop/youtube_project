<?php
include("includes/db.php");
include("includes/header.php");
?>

<div class="yt-home">

    <h2 class="home-title">Welcome to Your Video Feed</h2>

    <div class="video-grid">

        <?php
        $result = mysqli_query($conn, "SELECT * FROM videos ORDER BY id DESC");

        if ($result && mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {

                // safety check
                if (!empty($row['video_path']) && file_exists($row['video_path'])) {
        ?>

        <div class="video-card">

            <a href="watch.php?id=<?php echo $row['id']; ?>">

                <video width="100%" controls>
                    <source src="<?php echo $row['video_path']; ?>" type="video/mp4">
                </video>

<h3 style="color:red;font-size:22px;">
    <?php echo $row['title']; ?>
</h3>
            </a>

        </div>

        <?php
                }
            }

        } else {
            echo "<h3 style='margin-left:220px;'>No videos uploaded yet</h3>";
        }
        ?>

    </div>

</div>

<?php include("includes/footer.php"); ?>