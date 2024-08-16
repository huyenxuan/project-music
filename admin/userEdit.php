<?php
ob_start();
include("include/sidebar.php");
include("include/header.php");
include('../class/userClass.php');
$user = new User();

$user_slug = $_GET['slug'];
$get_user = $user->get_user_by_slug($user_slug);
if ($get_user) {
    $result = $get_user->fetch_assoc();
    $user_id = $result['user_id'];
} else {
    echo 'Không tồn tại người dùng này';
}

if (isset($_SESSION['user_id'])) {
    $userAdminid = $_SESSION['user_id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $description = $_POST['description'];
    $role = isset($_POST['role']) ? 'admin' : 'user';

    if (!empty($_FILES['userimage']['name'])) {
        $userimage = $_FILES['userimage']['name'];
        $uploadDir = "upload/images/imageuser/";
        $uploadFile = $uploadDir . basename($userimage);

        if (move_uploaded_file($_FILES['userimage']['tmp_name'], $uploadFile)) {
            echo 'Upload thành công';
        } else {
            echo "Failed to upload image.";
        }
    } else {
        // Nếu không có ảnh mới, giữ nguyên ảnh cũ
        $userimage = $result['userimage'];
    }

    $update_user = $user->update_user($fullName, $email, $password, $description, $role, $userimage, $user_id);

    $adminId = $userAdminid;
    $actions = "Sửa thông tin người dùng";
    $details = "Sửa thông tin người dùng '$fullName'";
    $user->logAdminAction($adminId, $actions, $details);

    header("Location: userShow.php");
    exit();
}
?>
<style>
    .main-content {
        margin: 15px;
    }

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
        width: 300px;
        /* height: 200px; */
        overflow: hidden;
    }

    .image input {
        margin: 0 0 0 10px !important;
    }

    .image img {
        width: 50%;
        height: 50%;
    }

    .isAdmin {
        margin-top: 20px;
    }
</style>
<link rel="stylesheet" href="./css/user.css">
<title>Sửa tài khoản người dùng</title>
<!-- main content -->
<div class="main-content">
    <h2 class="title">Sửa người dùng</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="info">
            <div class="name">
                <label for="fullName">Tên người dùng <span style="color: red">*</span></label><br>
                <input required name="fullName" type="text" placeholder="Tên người dùng" value="<?php echo $result['fullName'] ?>"><br>
            </div>
            <div class="email">
                <label for="">Địa chỉ email <span style="color: red">*</span></label><br>
                <input required name="email" type="email" placeholder="Địa chỉ email" value="<?php echo $result['email'] ?>"><br>
            </div>
            <div class="password">
                <label for="">Mật khẩu <span style="color: red">*</span></label><br>
                <input required name="password" type="text" placeholder="Mật khẩu" value="<?php echo $result['password'] ?>"><br>
            </div>
        </div>
        <div class="description">
            <label for="des">Mô tả </label><br>
            <textarea name="description" id="des" rows="10" cols="30"><?php echo $result['description'] ?></textarea>
        </div>
        <div class="image">
            <label for="image">Ảnh đại diện</label>
            <input type="file" id="image" name="userimage" accept="image/*"><br>
            <img src="upload/images/imageuser/<?php echo $result['userimage'] ?>" alt="">
        </div>
        <div class="isAdmin">
            <label for="" style="margin-right: 10px">Là admin: </label>
            <input name="role" value="admin" type="checkbox" placeholder="Là admin" <?php if ($result['role'] == 'admin') echo 'checked' ?>><br>
        </div>
        <button>Cập nhật</button>
    </form>
</div>
<?php
include("include/footer.php");
?>