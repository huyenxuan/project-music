<?php
session_start();

include("../class/loginAdmin.php");
$loginAdmin = new LoginAdmin();

$erroEmail = '';
$erroPass = '';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];
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
        $loginAdmin->login($email, $pass);
        if ($loginAdmin) {
            $erro = 'Tài khoản hoặc mật khẩu không đúng';
        }
    }
}
?>
<title>Login - Admin</title>
<link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css' rel='stylesheet'>
<link rel="shortcut icon" type="image/png" href="../asset/img/logo.jpg">
<link rel="stylesheet" href="./css/loginadmin.css">
<style>
    form div {
        margin-bottom: 10px;
    }

    form div input {
        margin: 0;
    }
</style>

<body>
    <h2>Nhập tài khoản và mật khẩu để đăng nhập!</h2>
    <span style="color:red; justify-content:center; display:flex"><?php if (isset($loginCheck)) {
        echo $loginCheck;
    } ?></span>
    <form action="login.php" method="POST">
        <div>
            <label for="">Nhập tài khoản</label><br>
            <input type="text" name="email" placeholder="Nhập email admin..." value=""><br>
            <?php if ($erroEmail !== "") {
                echo "<p style='color: red; font-size: 15px; margin-left: 10px'>" . $erroEmail . "</p>";
            } ?>
        </div>
        <div class="pw">
            <label for="">Mật khẩu</label><br>
            <input type="password" name="password" class="password" placeholder="Mật khẩu">
            <i class="toggle-password fa-solid fa-eye"></i>
            <?php if ($erroPass !== "") {
                echo "<p style='color: red; font-size: 15px; margin-left: 10px'>" . $erroPass . "</p>";
            } ?>
        </div>
        <?php if ($erro !== "") {
            echo "<p style='color: red; font-size: 15px; margin-left: 10px'>" . $erro . "</p>";
        } ?>
        <button type="submit" name="login">Đăng nhập</button>
    </form>

    <!-- javascript -->
    <script src="./js/loginadmin.js"></script>
</body>

</html>