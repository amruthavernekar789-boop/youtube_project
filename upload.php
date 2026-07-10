<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
session_start();
include("includes/db.php");

// 🔒 LOGIN CHECK
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 🔒 ADMIN CHECK
if ($_SESSION['role'] != 'admin') {
    echo "Access Denied!";
    exit();
}

$user_id = $_SESSION['user_id'];

/* =========================
   UPLOAD VIDEO
========================= */
if (isset($_POST['upload'])) {

    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";

    $title = $_POST['title'];
    $description = $_POST['description'];

    $video_name = $_FILES['video']['name'];
    $video_tmp = $_FILES['video']['tmp_name'];

    $thumb_name = $_FILES['thumbnail']['name'];
    $thumb_tmp = $_FILES['thumbnail']['tmp_name'];

    $video_path = "uploads/" . time() . "_" . $video_name;
    $thumb_path = "uploads/" . time() . "_" . $thumb_name;

    if (!is_dir("uploads")) {
        mkdir("uploads", 0777, true);
    }

    if (move_uploaded_file($video_tmp, $video_path) &&
        move_uploaded_file($thumb_tmp, $thumb_path)) {

        $query = mysqli_query($conn,
        "INSERT INTO videos(title,description,video_path,thumbnail,user_id)
         VALUES('$title','$description','$video_path','$thumb_path','$user_id')");
       
        if(!$query){
            die("DB Error: " . mysqli_error($conn));
        }

        echo "Upload Success";
        exit();

    } else {

        echo "Video Upload Failed";
        exit();
    }
}

/* =========================
   DELETE VIDEO
========================= */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM videos WHERE id='$id' AND user_id='$user_id'");
    header("Location: upload.php");
    exit();
}

/* =========================
   GET USER VIDEOS
========================= */
$videos = mysqli_query($conn,
    "SELECT * FROM videos WHERE user_id='$user_id' ORDER BY id DESC"
);
?>

<?php include("includes/header.php"); ?>





<style>

/* MAIN LAYOUT */
.upload-container{
    display:flex;
    gap:30px;
    padding:30px;
    align-items:flex-start;
}

/* LEFT SIDE */
.left-section{
    width:30%;
}

.left-section h3{
    margin-bottom:20px;
    color:red;
}

/* VIDEO CARD */
.video-card{
    background:white;
    padding:12px;
    margin-bottom:15px;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

.video-card img{
    width:100%;
    border-radius:8px;
}

.video-card h4{
    color:black;
    font-size:18px;
    margin:10px 0;
}

/* RIGHT SIDE */
.right-section{
    width:40%;
    position:sticky;
    top:100px;
}

/* TITLE */
.title{
    text-align:center;
    color:red;
    margin-bottom:20px;
}

/* UPLOAD BOX */
.upload-box{
    width:100%;
    max-width:400px;
    background:#111;
    padding:25px;
    border-radius:15px;
    box-shadow:0 0 20px rgba(255,0,0,0.4);
}

/* INPUTS */
.upload-box input,
.upload-box textarea{
    width:100%;
    padding:10px;
    margin:10px 0;
    border:none;
    border-radius:5px;
}

/* LABELS */
.upload-box label{
    display:block;
    margin:10px 0;
    color:white;
}

/* BUTTON */
.upload-box button{
    width:100%;
    padding:12px;
    background:red;
    border:none;
    border-radius:5px;
    color:white;
    font-weight:bold;
    cursor:pointer;
}

.upload-box button:hover{
    background:#cc0000;
}

</style>


<div class="upload-container">

    <!-- LEFT SIDE -->
    <div class="left-section">

        <h3>🎬 My Uploaded Videos</h3>

        <?php while ($v = mysqli_fetch_assoc($videos)) { ?>

            <div class="video-card">

                <img src="<?php echo $v['thumbnail']; ?>">

                <h4><?php echo $v['title']; ?></h4>

                <a href="upload.php?delete=<?php echo $v['id']; ?>"
                   style="color:red;text-decoration:none;">
                    🗑 Delete
                </a>

            </div>

        <?php } ?>

    </div>

    <!-- RIGHT SIDE -->
    <div class="right-section">

        <h2 class="title">🔥 Upload Video</h2>

        <form method="POST"
              enctype="multipart/form-data"
              class="upload-box">

            <input type="text"
                   name="title"
                   placeholder="Enter Video Title"
                   required>

            <textarea name="description"
                      placeholder="Enter description..."
                      required></textarea>

            <label>
                📹 Select Video
                <input type="file"
                       name="video"
                       required>
            </label>

            <label>
                🖼 Select Thumbnail
                <input type="file"
                       name="thumbnail"
                       required>
            </label>

            <button type="submit" name="upload">
                Upload Video
            </button>

        </form>

    </div>

</div>