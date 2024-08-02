<?php
ob_start();
// include('class/userClass.php');
// $user = new user();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $role = isset($_POST['role']) ? 1 : 0;

    $insert_user = $user->insert_user($fullName, $email, $phoneNumber, $address, $password, $role);

    header("Location: userAdd.php?user_name=" . urlencode($fullName));
    exit();
}
include("include/header.php");
// include("include/sidebar.php");
?>
<title>Thêm tài khoản người dùng</title>
<!-- main content -->

<div class="main-content">
    <h2>Thêm danh mục</h2>
    <form action="" method="POST">
        <div class="name">
            <label for="">Tên người dùng <span style="color: red">*</span></label><br>
            <input required name="fullName" type="text" placeholder="Tên người dùng"><br>
        </div>
        <div class="email">
            <label for="">Địa chỉ email <span style="color: red">*</span></label><br>
            <input required name="email" type="text" placeholder="Địa chỉ email"><br>
        </div>
        <div class="phoneNumber">
            <label for="">Số điện thoại </label><br>
            <input name="phoneNumber" type="text" placeholder="Số điện thoại"><br>
        </div>
        <div class="password">
            <label for="">Mật khẩu <span style="color: red">*</span></label><br>
            <input required name="password" type="text" placeholder="Mật khẩu"><br>
        </div>
        <div class="isAdmin">
            <label for="" style="margin-right: 10px">Là admin: </label>
            <input name="role" value="admin" type="checkbox" placeholder="Là admin"><br>
        </div>
        <button>Thêm</button>
    </form>
</div>