<?php
include("db.php");
session_start();

if(isset($_POST['login'])){

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='$password'");

    if(mysqli_num_rows($query) > 0){

        $user = mysqli_fetch_assoc($query);

       
$_SESSION['user_id'] = $user['id'];
$_SESSION['role'] = $user['role'];
$_SESSION['username'] = $user['name'];  // ✅ FIX
$_SESSION['role'] = $user['role'];

header("Location: home.php");
exit();

    } else {
        echo "<script>alert('Invalid Email or Password');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* HEADER */
        .header {
            height: 100px;
            background: white;
            display: flex;
            align-items: center;
            justify-content:center;
            padding-left: 20px;
            font-size: 32px;
            font-weight: bold;
            color: red;
            border-bottom: 2px solid red;
        }
       
        /* BACKGROUND AREA */
        .login-container {
            height: calc(100vh - 70px);
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;

            background: url("image3.jpeg") no-repeat center center/cover;
        }

        /* DARK OVERLAY */
        .login-container::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.6);
        }
        /* LOGIN BOX */
        .login-box {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
        }

        .login-box h1 {
            margin-bottom: 10px;
        }

        .login-box p {
            margin-bottom: 20px;
            font-size: 14px;
        }

        .login-box h2 {
            color: #ff4d4d;
            margin-bottom: 20px;
        }

        /* INPUTS */
        .login-box input {
            width: 260px;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
        }

        /* BUTTON */
        .login-box button {
            width: 280px;
            padding: 10px;
            background: red;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .login-box button:hover {
            background: darkred;
        }

        .login-box a {
            color: #ff4d4d;
            text-decoration: none;
        }

        .error {
            color: yellow;
            margin-bottom: 10px;
        }

    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        YouTube Accessing And Maetrial Distribution
    </div>

    <!-- LOGIN SECTION -->
    <div class="login-container">

        <div class="login-box">
            <h1>YouTube Clone</h1>
            <p>Access & Share Your Learning Content 🚀</p>

            <h2>Welcome Back !!</h2>

            <?php if(isset($error)){ ?>
                <div class="error"><?php echo $error; ?></div>
            <?php } ?>

            <form method="POST">
                <input type="email" name="email" placeholder="Email" required><br>
                <input type="password" name="password" placeholder="Password" required><br>

                <button type="submit" name="login">Login</button>
            </form>

<p>
    Don't have an account? 
    <a href="/youtube_project/register.php" target="_blank">Create Account</a>
</p>
   </div>

    </div>

</body>
</html>