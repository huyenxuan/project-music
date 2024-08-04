<?php
ob_start();
include('../class/userClass.php');
$user = new user();

$user_id = $_GET['user_id'];
$get_user = $user->get_user($user_id);
if ($get_user) {
    $result = $get_user->fetch_assoc();
} else {
    echo 'Không tồn tại người dùng này';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $password = $_POST['password'];
    $description = $_POST['description'];
    $role = isset($_POST['role']) ? 'admin' : 'user';

    $insert_user = $user->update_user($fullName, $email, $phoneNumber, $password, $description, $role, $user_id);

    header("Location: userShow.php");
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

    form input:not([type="checkbox"]) {
        color: black !important;
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
            <input required name="fullName" type="text" placeholder="Tên người dùng" value="<?php echo $result['username'] ?>"><br>
        </div>
        <div class="email">
            <label for="">Địa chỉ email <span style="color: red">*</span></label><br>
            <input required name="email" type="email" placeholder="Địa chỉ email" value="<?php echo $result['email'] ?>"><br>
        </div>
        <div class="phoneNumber">
            <label for="">Số điện thoại </label><br>
            <input name="phoneNumber" type="text" placeholder="Số điện thoại" value="<?php echo $result['phoneNumber'] ?>"><br>
        </div>
        <div class="password">
            <label for="">Mật khẩu <span style="color: red">*</span></label><br>
            <input required name="password" type="text" placeholder="Mật khẩu" value="<?php echo $result['password'] ?>"><br>
        </div>
        <div class="description">
            <label for="des">Mô tả </label><br>
            <textarea name="description" id="des" rows="10" cols="30"><?php echo $result['description'] ?></textarea>
        </div>
        <div class="image">
            <label for="image">
                <input type="file" id="image" name="image">
            </label>
        </div>
        <div class="isAdmin">
            <label for="" style="margin-right: 10px">Là admin: </label>
            <input name="role" value="admin" type="checkbox" placeholder="Là admin" <?php if ($result['role'] == 'admin') echo 'checked' ?>><br>
        </div>
        <button>Sửa</button>
    </form>
</div>
<?php
include("include/footer.php");
?>