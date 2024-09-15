<?php
session_start();
include('class/frontendClass.php');
$frontend = new FrontEnd;
$erroEmail = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    // kiểm tra trường email
    if ($email === "") {
        $erroEmail = "Vui lòng nhập vào email!";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erroEmail = "Định dạng email sai!";
    } else if (!($frontend->check_email($email))) {
        $erroEmail = "Email không tồn tại.";
    } else {
        $sendPasswordResetCode = $frontend->sendPasswordResetCode($email);
        if ($sendPasswordResetCode) {
            header('location: resetpassword.php');
            exit();
        } else {
            echo 'lỗi';
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
    <title>Quên mật khẩu</title>
    <link rel="stylesheet" href="./css/acount.css">
</head>
<style>
    body {
        background-image: url(./asset/img/colorful-wave.gif);
        background-repeat: no-repeat;
        background-size: cover;
        color: white;
        align-content: center;
    }

    .login-box {
        margin: auto;
        background-color: rgba(205, 205, 205, 0.95);
        border-radius: 10px;
        width: 370px;
    }

    form input {
        margin-bottom: 0;
    }
</style>

<body>
    <div class="login-box">
        <div class="login-header">
            <div class="tilte">Quên mật khẩu</div>
        </div>
        <form action="" class="form-forgot" method="POST">
            <input type="text" name="email" id="email" placeholder="Nhập email của bạn">
            <?php if ($erroEmail !== "") {
                echo "<p style='color: red; font-size: 15px; margin-left: 10px'>" . $erroEmail . "</p>";
            } ?>
            <button type="submit">Gửi mã</button>
        </form>
    </div>
</body>

</html>