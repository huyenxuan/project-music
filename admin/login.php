<?php
session_start();

include("../class/loginAdmin.php");
$loginAdmin = new loginAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $loginCheck = $loginAdmin->login($email, $pass);
}
?>
<title>Login - Admin</title>
<link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css' rel='stylesheet'>
<link rel="stylesheet" href="./css/loginadmin.css">

<body>
    <h2>Nhập tài khoản và mật khẩu để đăng nhập!</h2>
    <span><?php if (isset($loginCheck)) {
                echo $loginCheck;
            } ?></span>
    <form action="login.php" method="POST">
        <div>
            <label for="">Nhập tài khoản</label><br>
            <input required type="text" name="email" placeholder="Nhập email admin..." value=""><br>
        </div>
        <div class="pw">
            <label for="">Mật khẩu</label><br>
            <input required type="password" name="password" class="password" placeholder="Mật khẩu">
            <i class="toggle-password fa-solid fa-eye"></i>
        </div>
        <button type="submit" name="login">Đăng nhập</button>
    </form>

    <!-- javascript -->
    <script src="./js/loginadmin.js"></script>
</body>

</html>