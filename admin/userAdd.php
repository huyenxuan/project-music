<?php
ob_start();
include('../class/userClass.php');
$user = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $description = $_POST['description'];
    $role = isset($_POST['role']) ? 'admin' : 'user';
    $userimage = $_FILES['userimage']['name'];
    move_uploaded_file($_FILES['userimage']['tmp_name'], "upload/images/imageuser/" . $_FILES['userimage']['name']);

    $insert_user = $user->insert_user($fullName, $email, $password, $description, $role, $userimage);

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

    .info {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
    }

    .info div {
        width: 50% !important;
    }

    label {
        font-weight: 600;
    }

    .info div input {
        width: 90% !important;
    }

    .image {
        width: 200px;
        /* height: 200px; */
        overflow: hidden;
    }

    .image img {
        width: 100%;
        object-fit: contain;
        padding: 5px 0 10px 10px;
    }

    .isAdmin {
        margin-top: 20px;
    }
</style>
<link rel="stylesheet" href="./css/user.css">
<title>Thêm tài khoản người dùng</title>
<!-- main content -->
<div class="main-content">
    <h2 class="title">Thêm người dùng</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="info">
            <div class="name">
                <label for="fullName">Tên người dùng <span style="color: red">*</span></label><br>
                <input required name="fullName" type="text" placeholder="Tên người dùng"><br>
            </div>
            <div class="email">
                <label for="">Địa chỉ email <span style="color: red">*</span></label><br>
                <input required name="email" type="email" placeholder="Địa chỉ email"><br>
            </div>
            <div class="password">
                <label for="">Mật khẩu <span style="color: red">*</span></label><br>
                <input required name="password" type="text" placeholder="Mật khẩu"><br>
            </div>
        </div>
        <div class="description">
            <label for="">Mô tả </label><br>
            <textarea name="description" id="" rows="10" cols="30"></textarea>
        </div>
        <div class="image">
            <label for="image">Ảnh đại diện</label>
            <input id="image" type="file" name="userimage" accept="image/*">
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