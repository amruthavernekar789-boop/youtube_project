<?php
session_start();
include("includes/db.php");
include("includes/header.php");

$query = "";

if(isset($_GET['query'])){
    $query = mysqli_real_escape_string($conn, $_GET['query']);
}
?>

<style>

.search-container{
    padding:20px;
}

.search-title{
    margin-bottom:20px;
    color:#ff0000;
}

.video-grid{
    display:flex;
    flex-wrap:wrap;
    gap:20px;
}

.video-card{
    width:280px;
    background:white;
    border-radius:12px;
    padding:10px;
    box-shadow:0 2px 10px rgba(0,0,0,0.15);
}

.video-card img{
    width:100%;
    height:170px;
    object-fit:cover;
    border-radius:10px;
}

.video-card h3{
    color:black;
    margin-top:10px;
    font-size:18px;
}

.video-card a{
    text-decoration:none;
}

.no-result{
    font-size:20px;
    color:red;
    margin-top:20px;
}

</style>

<div class="search-container">

    <h2 class="search-title">
        Search Results:
        "<?php echo htmlspecialchars($query); ?>"
    </h2>

    <div class="video-grid">

    <?php

    if(!empty($query)){

        $result = mysqli_query($conn,
        "SELECT * FROM videos
         WHERE title LIKE '%$query%'
         OR description LIKE '%$query%'
         ORDER BY id DESC");

        if(mysqli_num_rows($result) > 0){

            while($row = mysqli_fetch_assoc($result)){
            ?>

                <div class="video-card">

                    <a href="watch.php?id=<?php echo $row['id']; ?>">

                        <img src="<?php echo $row['thumbnail']; ?>">

                        <h3>
                            <?php echo $row['title']; ?>
                        </h3>

                    </a>

                </div>

            <?php
            }

        }else{
            echo "<div class='no-result'>No videos found 😔</div>";
        }

    }else{
        echo "<div class='no-result'>Please enter a search keyword 🔍</div>";
    }

    ?>

    </div>

</div>

<?php include("includes/footer.php"); ?>