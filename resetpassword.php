<?php
session_start();
include('class/frontendClass.php');
$frontend = new FrontEnd;
$erroResetcode = "";
$erroPassword = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reset_code = $_POST['reset_code'];
    $new_password = $_POST['new_password'];

    if (isset($_SESSION['reset_code'])) {
        if ($reset_code === "") {
            $erroResetcode = "Vui lòng nhập mã đã được gửi về qua email.";
        } else if ($reset_code == $_SESSION['reset_code']) {
            $email = $_SESSION['reset_email'];
            if (strlen($new_password) < 8 || strlen($new_password) > 20) {
                $erroPassword = "Mật khẩu phải có độ dài từ 8 đến 20 ký tự.";
            } else {
                $update_password = $frontend->update_password($email, $new_password);

                unset($_SESSION['reset_code']);
                unset($_SESSION['reset_email']);

                header("Location: login.php");
                exit();
            }
        } else {
            $erroResetcode = "Mã khôi phục không đúng!";
        }
    } else {
        $error = "Không tìm thấy mã.";
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
    <link rel="stylesheet" href="./css/acount.css">
    <title>Đặt lại mật khẩu</title>
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
        border-radius: 10px
    }

    .reset_code input {
        margin-bottom: 0;
    }

    .reset_code {
        margin-bottom: 10px;
    }
</style>

<body>
    <div class="login-box">
        <div class="login-header">
            <div class="tilte">Đặt lại mật khẩu</div>
        </div>
        <form action="" class="form-resetpw" method="POST">
            <div class="reset_code">
                <input type="text" name="reset_code" maxlength="6" placeholder="Nhập mã gửi về gmail">
                <?php if ($erroResetcode !== "") {
                    echo "<p style='color: red; font-size: 17px; margin-left: 10px'>" . $erroResetcode . "</p>";
                } ?>
            </div>
            <div class="pw">
                <input type="password" name="new_password" class="password" placeholder="Mật khẩu mới"><br>
                <i class="toggle-password fa-solid fa-eye"></i>
                <?php if ($erroPassword !== "") {
                    echo "<p style='color: red; font-size: 17px; margin-left: 10px'>" . $erroPassword . "</p>";
                } ?>
            </div>
            <button type="submit">Đổi mật khẩu</button>
        </form>
    </div>
    <script src="./js/account.js"></script>
</body>

</html>