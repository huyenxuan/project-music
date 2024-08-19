<?php
session_start();
include('class/frontendClass.php');
$frontend = new FrontEnd;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reset_code = $_POST['reset_code'];
    $new_password = $_POST['new_password'];

    if (isset($_SESSION['reset_code']) && $reset_code == $_SESSION['reset_code']) {
        if ($new_password === $confirm_password) {
            $email = $_SESSION['reset_email'];
            $query = "UPDATE tbl_user SET password = '$new_password' WHERE email = '$email'";
            $frontend->db->update($query);

            unset($_SESSION['reset_code']);
            unset($_SESSION['reset_email']);

            header("Location: index.php");
            exit();
        } else {
            $error = "Passwords do not match.";
        }
    } else {
        $error = "Invalid or expired code.";
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

<body>
    <div class="login-box">
        <div class="login-header">
            <div class="tilte">Đặt lại mật khẩu</div>
        </div>
        <form action="" class="form-resetpw" method="post">
            <input type="text" name="reset_code" maxlength="6" placeholder="Nhập mã gửi về gmail">
            <div class="pw">
                <input required type="password" name="new_password" class="password" placeholder="Mật khẩu mới">
                <i class="toggle-password fa-solid fa-eye"></i>
            </div>
            <button type="submit">Đổi mật khẩu</button>
        </form>
    </div>
    <script src="./js/account.js"></script>
</body>

</html>