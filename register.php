<?php
session_start();
include("./class/userClass.php");
$user = new user();

$erroFullName = '';
$erroEmail = '';
$erroPass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // kiểm tra tên
    if ($fullName === '') {
        $erroFullName = 'Không được để trống trường';
    } else if (preg_match('/^[^a-zA-Z]/', $fullName)) {
        $erroFullName = 'Tên phải bắt đầu bằng chữ';
    }
    // kiểm tra email
    if ($email === '') {
        $erroEmail = 'Không được để trống trường';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erroEmail = 'Định dạng email không đúng';
    }
    // kiểm tra mật khẩu
    if ($password === '') {
        $erroPass = 'Không được để trống trường';
    } else if (strlen($password) < 8 || strlen($password) > 20) {
        $erroPass = 'Mật khẩu phải có độ dài tối thiểu 15 ký tự';
    } else if (!preg_match('/[A-Z]/', $password)) {
        $erroPass = 'Mật khẩu phải chứa ký tự in hoa';
    } else if (!preg_match('/[a-z]/', $password)) {
        $erroPass = 'Mật khẩu phải chứa ký tự in thường';
    } else if (!preg_match('/[!@$%^&*()]/', $password)) {
        $erroPass = 'Mật khẩu phải chứa ký tự đặc biệt';
    }

    // mọi thứ đều đúng
    if ($erroFullName === '' && $erroEmail === '' && $erroPass === '') {
        $register = $user->register($fullName, $email, $password);
        if ($register) {
            ?>
            <script>alert('Đăng ký thành công')</script>
            <?php
            // header('location:login.php');
            // exit();
        }
    }
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
            border-radius: 10px;
            width: 370px;
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

        form div {
            margin-bottom: 10px;
        }

        form div input {
            margin: 0;
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
                <div class="fullName">
                    <input type="name" name="fullName" id="" placeholder="Họ và tên">
                    <?php if ($erroFullName !== "") {
                        echo "<p style='color: red; font-size: 15px; margin-left: 10px'>" . $erroFullName . "</p>";
                    } ?>
                </div>
                <div class="email">
                    <input type="text" name="email" id="" placeholder="Email">
                    <?php if ($erroEmail !== "") {
                        echo "<p style='color: red; font-size: 15px; margin-left: 10px'>" . $erroEmail . "</p>";
                    } ?>
                </div>
                <div class="pw">
                    <input type="password" name="password" class="password" placeholder="Mật khẩu">
                    <i class="toggle-password fa-solid fa-eye"></i>
                    <?php if ($erroPass !== "") {
                        echo "<p style='color: red; font-size: 15px; margin-left: 10px'>" . $erroPass . "</p>";
                    } ?>
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