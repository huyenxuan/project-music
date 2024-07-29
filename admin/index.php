<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/loginadmin.css">
    <title>Đăng nhập</title>
</head>

<body>
    <h2>Nhập tài khoản và mật khẩu để đăng nhập!</h2>
    <form action="login.php" method="POST">
        <div>
            <label for="">Nhập tài khoản</label><br>
            <input required type="text" name="account" placeholder="Nhập email admin..." value=""><br>
        </div>
        <div class="pw">
            <label for="">Mật khẩu</label><br>
            <input required type="password" name="pass" class="password" placeholder="Mật khẩu">
            <i class="toggle-password fa-solid fa-eye"></i>
        </div>
        <button type="submit" name="login">Đăng nhập</button>
    </form>

    <!-- javascript -->
    <script src="./js/loginadmin.js"></script>
</body>

</html>