<?php
include("db.php");

if(isset($_POST['register'])){

    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $aadhar = $_POST['aadhar'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "INSERT INTO users(name, gender, dob, aadhar, phone, email, password, role)
    VALUES('$name','$gender','$dob','$aadhar','$phone','$email','$password','user')");

    if(!$query){
        die("Error: " . mysqli_error($conn));
    }

    // ✅ redirect only after successful registration
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Create Account</title>

<style>

/* RESET */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: 'Segoe UI', sans-serif;
}

/* BODY */
body{
    background: black;
    color:white;
}

/* HEADER */
.header{
    height:70px;
    width:100%;
    background:white;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 30px;
}

.logo{
    display:flex;
    align-items:center;
    gap:10px;
    font-size:20px;
    font-weight:bold;
    color:black;
}

.logo img{
    width:50px;
}

/* MAIN */
.main{
    display:flex;
    height:calc(100vh - 70px);
}

/* LEFT */
.left{
    width:50%;
    padding:80px;
}

.left h1{
    font-size:40px;
}

.left span{
    color:red;
}

.left p{
    margin-top:20px;
    color:#aaa;
}

/* RIGHT */
.right{
    width:50%;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* FORM */
.form-box{
    width:380px;
    padding:30px;
    background:#111;
    border-radius:15px;
    box-shadow:0 0 25px rgba(255,0,0,0.3);
}

.form-box h2{
    text-align:center;
    margin-bottom:20px;
}

.form-box h2 span{
    color:red;
}

.form-box input,
.form-box select{
    width:100%;
    padding:10px;
    margin:8px 0;
    background:#222;
    border:none;
    border-radius:5px;
    color:white;
}

.form-box button{
    width:100%;
    padding:12px;
    background:red;
    border:none;
    border-radius:5px;
    color:white;
    font-weight:bold;
    margin-top:10px;
    cursor:pointer;
}

.form-box button:hover{
    background:#cc0000;
}

.form-box p{
    text-align:center;
    margin-top:15px;
}

.form-box a{
    color:red;
    text-decoration:none;
}

</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <div class="logo">
        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b8/YouTube_Logo_2017.svg">
        YouTube Learning
    </div>
</div>

<!-- MAIN -->
<div class="main">

    <!-- LEFT -->
    <div class="left">
        <h1>Welcome to <span>YouTube Learning</span></h1>
        <p>Create your account to access educational videos.</p>
    </div>

    <!-- RIGHT -->
    <div class="right">
        <form method="POST" class="form-box">

            <h2>Create <span>Account</span></h2>

            <input type="text" name="name" placeholder="Full Name" required>

            <select name="gender" required>
                <option value="">Select Gender</option>
                <option>Male</option>
                <option>Female</option>
            </select>

            <input type="date" name="dob" required>
            <input type="text" name="aadhar" placeholder="Aadhar Number">
            <input type="text" name="phone" placeholder="Phone Number">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit" name="register">CREATE ACCOUNT</button>

            <p>
                Already have an account? 
                <a href="login.php">Login</a>
            </p>

        </form>
    </div>

</div>

</body>
</html>