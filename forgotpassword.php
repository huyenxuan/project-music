<?php
session_start();
include('class/frontendClass.php');
$frontend = new FrontEnd;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    $sendPasswordResetCode = $frontend->sendPasswordResetCode($email);
    if ($sendPasswordResetCode) {
        header('location: resetpassword.php');
        exit();
    } else {
        echo 'lỗi';
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
    <title>Quên mật khẩu</title>
    <link rel="stylesheet" href="./css/acount.css">
</head>

<body>
    <div class="login-box">
        <div class="login-header">
            <div class="tilte">Quên mật khẩu</div>
        </div>
        <form action="" class="form-forgot" method="POST">
            <input required type="email" name="email" id="email" placeholder="Nhập email của bạn">
            <button type="submit">Gửi mã</button>
        </form>
    </div>
</body>

</html>