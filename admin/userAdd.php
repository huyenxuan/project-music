<?php
ob_start();
include("include/sidebar.php");
include("include/header.php");
include('../class/userClass.php');
$user = new User();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
$erroFullName = '';
$erroEmail = '';
$erroPass = '';
$erroUserImg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $description = $_POST['description'];
    $role = isset($_POST['role']) ? 'admin' : 'user';
    $userimage = $_FILES['userimage']['name'];

    // kiểm tra tên
    if ($fullName === '') {
        $erroFullName = 'Không được để trống trường';
    } else if (preg_match('/^[^a-zA-Z]/', $fullName)) {
        $erroFullName = 'Tên phải bắt đầu bằng chữ';
    }
    // kiểm tra email
    if ($email === '') {
        $erroEmail = 'Không được để trống trường';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erroEmail = 'Định dạng email không đúng';
    }
    // kiểm tra mật khẩu
    if ($password === '') {
        $erroPass = 'Không được để trống trường';
    } else if (strlen($password) < 8 || strlen($password) > 20) {
        $erroPass = 'Mật khẩu phải có độ dài lớn hơn 8 và nhỏ hơn 20';
    }
    // image
    if (!empty($userimage)) {
        $userimage_temp = $_FILES['userimage']['tmp_name'];
        $userimage_type = mime_content_type($userimage_temp);
        if (!in_array($userimage_type, ['image/jpeg', 'image/png', 'image/gif'])) {
            $erroUserImg = "Chọn file có định dạng file ảnh";
        }
    }
    if (empty($erroFullName) && empty($erroEmail) && empty($erroPass) && empty($erroUserImg)) {
        move_uploaded_file($_FILES['userimage']['tmp_name'], "upload/images/imageuser/" . $_FILES['userimage']['name']);

        $insert_user = $user->insert_user($fullName, $email, $password, $description, $role, $userimage);

        $adminId = $user_id;
        $actions = "Thêm người dùng";
        $details = "Thêm người dùng '$fullName'";
        $user->logAdminAction($adminId, $actions, $details);

        header("Location: userAdd.php?user_name=" . urlencode($fullName));
        exit();
    }

}
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

    form .image {
        width: 400px;
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

    .main-content {
        margin: 15px;
    }

    form input {
        margin: 10px 0 0 15px !important;
    }

    form div {
        margin-bottom: 10px;
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
                <input name="fullName" type="text" placeholder="Tên người dùng"><br>
                <?php if (!empty($erroFullName)) {
                    echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $erroFullName . "</span>";
                } ?>
            </div>
            <div class="email">
                <label for="">Địa chỉ email <span style="color: red">*</span></label><br>
                <input name="email" type="email" placeholder="Địa chỉ email"><br>
                <?php if (!empty($erroEmail)) {
                    echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $erroEmail . "</span>";
                } ?>
            </div>
            <div class="password">
                <label for="">Mật khẩu <span style="color: red">*</span></label><br>
                <input name="password" type="text" placeholder="Mật khẩu"><br>
                <?php if (!empty($erroPass)) {
                    echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $erroPass . "</span>";
                } ?>
            </div>
        </div>
        <div class="description">
            <label for="">Mô tả </label><br>
            <textarea name="description" id="" rows="10" cols="30"></textarea>
        </div>
        <div class="image">
            <label for="image">Ảnh đại diện</label>
            <input id="image" type="file" name="userimage" accept="image/*">
            <?php if (!empty($erroUserImg)) {
                echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $erroUserImg . "</span>";
            } ?>
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