<?php
ob_start();
include("include/sidebar.php");
include("include/header.php");
include("../class/bannerClass.php");
$banner = new Banner();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $banner_name = $_POST['banner_name'];
    $pathway = $_POST['pathway'];
    $banner_image = $_FILES['banner_image']['name'];
    move_uploaded_file($_FILES['banner_image']['tmp_name'], "upload/banner/" . $banner_image);

    $insert_banner = $banner->insert_banner($banner_name, $banner_image, $pathway);

    $adminId = $user_id;
    $actions = "Thêm banner";
    $details = "Thêm banner '$banner_name'";
    $banner->logAdminAction($adminId, $actions, $details);

    header('location: bannerAdd.php?bannerName=' . urldecode($banner_name));
    exit();
}
?>
<title>Thêm Banner</title>
<link rel="stylesheet" href="./css/album.css">

<style>
    .main-content {
        margin: 15px;
    }

    select {
        height: 40px;
        border-radius: 10px;
        width: 200px;
        font-size: 17px;
        margin: 0 0 10px 10px;
    }
</style>

<body>
    <div class="main-content">
        <h2 class="title" style="color:black">Thêm banner</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="info">
                <div class="name">
                    <label for="">Tên banner <span style="color: red">*</span></label><br>
                    <input required name="banner_name" type="text" placeholder="Tên banner">
                </div>
                <div class="image">
                    <label for="image">Ảnh banner <span style="color: red">*</span></label>
                    <input required id="image" type="file" name="banner_image" accept="image/*">
                </div>
            </div>
            <div class="">
                <label for="">Đường dẫn</label>
                <input required type="text" name="pathway" placeholder="Nhập đường dẫn">
            </div>
            <button>Thêm</button>
        </form>
    </div>
    <?php
    include("include/footer.php");
    ?>