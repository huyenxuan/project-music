<?php
ob_start();
session_start();
include("./class/userClass.php");
$user = new user();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $password = $_POST['password'];

    $insert_user = $user->register($fullName, $email, $phoneNumber, $password);

    // exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Đăng ký</title>
    <link rel="stylesheet" href="./css/acount.css">
</head>

<body>
    <div class="register-box">
        <div class="register-header">
            <div class="tilte">Đăng ký</div>
        </div>
        <form action="" class="form-signup" method="POST">
            <input required type="name" name="fullName" id="" placeholder="Họ và tên">
            <input required type="email" name="email" id="" placeholder="Email">
            <input type="text" name="phoneNumber" id="" placeholder="Số điện thoại">
            <div class="pw">
                <input required type="password" name="password" class="password" placeholder="Mật khẩu">
                <i class="toggle-password fa-solid fa-eye"></i>
            </div>
            <button type="submit">Đăng ký</button>
        </form>
        <div class="login-link">
            <p>Bạn đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>
        </div>
    </div>

    <script src="./js/account.js"></script>
</body>

</html>