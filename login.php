<?php
session_start();

include("./class/userClass.php");
$loginUser = new user();

$erroEmail = '';
$erroPass = '';
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    // kiểm tra email
    if ($email === '') {
        $erroEmail = 'Không được để trống trường';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erroEmail = 'Định dạng email không đúng';
    }
    // kiểm tra mật khẩu
    if ($pass === '') {
        $erroPass = 'Không được để trống trường';
    }
    // oke
    if ($erroEmail === '' && $erroPass === '') {
        $loginUser->login_user($email, $pass);
        if (!$loginUser) {
            $erro = 'Tài khoản hoặc mật khẩu không đúng';
        }
    }
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
        border-radius: 10px;
        width: 370px;
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
                <div class="email">
                    <input type="email" name="email" id="email" placeholder="Email">
                    <?php if ($erroEmail !== "") {
                        echo "<p style='color: red; font-size: 15px; margin-left: 10px'>" . $erroEmail . "</p>";
                    } ?>
                </div>
                <div class="pw">
                    <input type="password" name="pass" class="password" placeholder="Mật khẩu">
                    <i class="toggle-password fa-solid fa-eye"></i>
                    <?php if ($erroPass !== "") {
                        echo "<p style='color: red; font-size: 15px; margin-left: 10px'>" . $erroPass . "</p>";
                    }
                    if ($erro !== "") {
                        echo "<p style='color: red; font-size: 15px; margin-left: 10px'>" . $erro . "</p>";
                    } ?>
                </div>
                <div class="forgot">
                    <a href="forgotpassword.php">Quên mật khẩu</a>
                </div>
                <button type="submit">Đăng nhập</button>
            </form>
            <div class="register-link">
                <p>Bạn chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
            </div>
        </div>
    </div>

    <!-- javascript -->
    <script src="./js/account.js"></script>
</body>

</html>