<?php
ob_start();
session_start();
include("./class/userClass.php");
$user = new user();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $insert_user = $user->register($fullName, $email, $password);

    // exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Đăng ký</title>
    <link rel="stylesheet" href="./css/acount.css">
    <style>
        body {
            background-image: url(./asset/img/colorful-wave.gif);
            background-repeat: no-repeat;
            background-size: cover;
            color: white;
            align-content: center;
        }

        .register-box {
            margin: auto;
            background-color: rgba(205, 205, 205, 0.95);
            border-radius: 10px
        }

        h2 {
            color: red;
            width: 100%;
            z-index: 99;
            position: fixed;
            top: 75px;
            left: 35%;
        }

        .pw i {
            color: black;
        }
    </style>
</head>

<body>
    <div class="register-box">
        <audio autoplay hidden controls>
            <source src="asset/music/songs/Faded (Kygo Remix).mp3" type="audio/mp3">
        </audio>
        <div class="register-header">
            <div class="tilte">Đăng ký</div>
        </div>
        <div class="form-ctn">
            <form action="" class="form-signup" method="POST">
                <input required type="name" name="fullName" id="" placeholder="Họ và tên">
                <input required type="email" name="email" id="" placeholder="Email">
                <div class="pw">
                    <input required type="password" name="password" class="password" placeholder="Mật khẩu">
                    <i class="toggle-password fa-solid fa-eye"></i>
                </div>
                <button type="submit">Đăng ký</button>
            </form>
        </div>
        <div class="login-link">
            <p>Bạn đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>
        </div>
    </div>

    <script src="./js/account.js"></script>
</body>

</html>