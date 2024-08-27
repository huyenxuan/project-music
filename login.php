<?php
ob_start(); // Bắt đầu bộ đệm đầu ra
session_start();

include("./class/userClass.php");
$loginUser = new user();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $loginUser->login_user($email, $pass);
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="./css/acount.css">
<title>Đăng nhập</title>
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

    .pw i {
        color: black;
    }
</style>

<body>
    <audio autoplay hidden controls>
        <source src="asset/music/songs/Faded (Kygo Remix).mp3" type="audio/mp3">
    </audio>
    <audio src="asset/music/songs/Faded (Kygo Remix).mp3" autoplay></audio>
    <div class="login-box">
        <div class="login-header">
            <div class="tilte">Đăng nhập</div>
        </div>
        <div class="form-ctn">
            <form action="login.php" class="form-signin" method="POST">
                <input required type="email" name="email" id="email" placeholder="Email">
                <div class="pw">
                    <input required type="password" name="pass" class="password" placeholder="Mật khẩu">
                    <i class="toggle-password fa-solid fa-eye"></i>
                </div>
                <div class="forgot">
                    <a href="forgotpassword.php">Quên mật khẩu</a>
                </div>
                <button type="submit">Đăng nhập</button>
            </form>
            <span style="text-align:center">
                <?php if (isset($loginCheck)) {
                    echo $loginCheck;
                } ?>
            </span>
            <div class="register-link">
                <p>Bạn chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
            </div>
        </div>
    </div>

    <!-- javascript -->
    <script src="./js/account.js"></script>
</body>

</html>