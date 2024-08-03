<?php
ob_start();
include('../class/userClass.php');
$user = new user();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $password = $_POST['password'];
    $description = $_POST['description'];
    $role = isset($_POST['role']) ? 'admin' : 'user';

    $insert_user = $user->insert_user($fullName, $email, $phoneNumber, $password, $description, $role);

    header("Location: userAdd.php?user_name=" . urlencode($fullName));
    exit();
}
include("include/header.php");
include("include/sidebar.php");
?>
<style>
    form {
        margin-bottom: 10px;
    }

    form textarea {
        padding: 10px;
        margin: 10px 0 10px 15px;
        width: 95%;
        height: 90px;
        border-radius: 10px;
    }
</style>
<link rel="stylesheet" href="./css/user.css">
<title>Thêm tài khoản người dùng</title>
<!-- main content -->
<div class="main-content">
    <h2 class="title">Thêm người dùng</h2>
    <form action="" method="POST">
        <div class="name">
            <label for="fullName">Tên người dùng <span style="color: red">*</span></label><br>
            <input required name="fullName" type="text" placeholder="Tên người dùng"><br>
        </div>
        <div class="email">
            <label for="">Địa chỉ email <span style="color: red">*</span></label><br>
            <input required name="email" type="email" placeholder="Địa chỉ email"><br>
        </div>
        <div class="phoneNumber">
            <label for="">Số điện thoại </label><br>
            <input name="phoneNumber" type="text" placeholder="Số điện thoại"><br>
        </div>
        <div class="password">
            <label for="">Mật khẩu <span style="color: red">*</span></label><br>
            <input required name="password" type="text" placeholder="Mật khẩu"><br>
        </div>
        <div class="description">
            <label for="">Mô tả </label><br>
            <textarea name="description" id="" rows="10" cols="30">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis illum, expedita dolorem dolorum dolor eum ratione cumque porro nihil officiis iure nulla adipisci at provident eveniet tempora tenetur ad ex.
            </textarea>
        </div>
        <div class="isAdmin">
            <label for="" style="margin-right: 10px">Là admin: </label>
            <input name="role" value="admin" type="checkbox" placeholder="Là admin"><br>
        </div>
        <button>Thêm</button>
    </form>
</div>
<?php
include("include/footer.php");
?>