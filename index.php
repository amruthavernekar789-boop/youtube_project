<!DOCTYPE html>
<html>
<head>
    <title>YouTube Loading</title>

    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: white;
            overflow: hidden;
            font-family: Arial;
        }

        /* LOGO ANIMATION */
        .logo {
            font-size: 40px;
            font-weight: bold;
            color: red;
            position: relative;
            animation: slideIn 1.5s ease forwards;
            opacity: 0;
        }

        @keyframes slideIn {
            0% {
                transform: translateY(-80px);
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
            100% {
                transform: translateY(0px);
                opacity: 1;
            }
        }

        /* optional fade out before redirect */
        .fade-out {
            animation: fadeOut 0.5s ease forwards;
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
            }
        }
    </style>
</head>

<body>

<div class="logo">YouTube</div>

<script>
    setTimeout(() => {
        document.querySelector(".logo").classList.add("fade-out");

        setTimeout(() => {
            window.location.href = "login.php";
        }, 500);

    }, 2000);
</script>

</body>
</html>