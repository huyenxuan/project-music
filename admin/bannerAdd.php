<?php
ob_start();
include("include/sidebar.php");
include("include/header.php");
include("../class/bannerClass.php");
$banner = new Banner();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
$erroBanner = '';
$erroBannerImg = '';
$erroPathway = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $banner_name = $_POST['banner_name'];
    $pathway = $_POST['pathway'];
    $banner_image = $_FILES['banner_image']['name'];
    $display = isset($_POST['display']) ? 'show' : 'hidden';

    // kiểm tra các trường có rỗng hãy không
    if (empty($banner_name)) {
        $erroBanner = 'Không được để trống trường';
    } else if (preg_match('/^[^a-zA-Z]/', $banner_name)) {
        $erroBanner = "Tên banner phải bắt đầu bằng chữ";
    }
    if (empty($pathway)) {
        $erroPathway = 'Không được để trống trường';
    }
    if (empty($banner_image)) {
        $erroBannerImg = 'Không được để trống trường';
    } else {
        // kiểm tra tệp tải lên có đúng chuẩn không
        $banner_image_temp = $_FILES['banner_image']['tmp_name'];
        $banner_image_type = mime_content_type($banner_image_temp);
        if (!in_array($banner_image_type, ['image/jpeg', 'image/png', 'image/gif'])) {
            $erroBannerImg = 'Sai định dạng ảnh';
        }
    }
    if (empty($erroBanner) && empty($erroPathway) && empty($erroBannerImg)) {
        move_uploaded_file($_FILES['banner_image']['tmp_name'], "upload/banner/" . $banner_image);
        $insert_banner = $banner->insert_banner($banner_name, $banner_image, $pathway, $display);

        $adminId = $user_id;
        $actions = "Thêm banner";
        $details = "Thêm banner '$banner_name'";
        if ($banner->logAdminAction($adminId, $actions, $details)) {
            ?>
            <!-- thông báo thành công -->
            <script>alert('Đã thêm thành công')</script>
            <?php
            // header('location: bannerAdd.php?bannerName=' . urldecode($banner_name));
        } else {
            ?>
            <!-- thông báo lỗi -->
            <script>alert('Đã có lỗi xảy ra')</script>
            <?php
        }
    }
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

    form button {
        width: 140px;
        height: 40px;
    }

    form div {
        margin-bottom: 10px;
    }

    form input {
        margin: 0 !important;
    }
</style>

<body>
    <div class="main-content">
        <h2 class="title" style="color:black">Thêm banner</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="info">
                <div class="name">
                    <label for="">Tên banner <span style="color: red">*</span></label><br>
                    <input name="banner_name" type="text" placeholder="Tên banner">
                    <?php if (!empty($erroBanner)) {
                        echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $erroBanner . "</span>";
                    } ?>
                </div>
                <div class="image">
                    <label for="image">Ảnh banner <span style="color: red">*</span></label>
                    <input id="image" type="file" name="banner_image" accept="image/*">
                    <?php if (!empty($erroBannerImg)) {
                        echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $erroBannerImg . "</span>";
                    } ?>
                </div>
            </div>
            <div class="">
                <label for="">Đường dẫn <span style="color: red">*</span></label><br>
                <input type="text" name="pathway" placeholder="Nhập đường dẫn">
                <?php if (!empty($erroPathway)) {
                    echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $erroPathway . "</span>";
                } ?>
            </div>
            <div class="privacy display">
                <label for="">Hiện banner</label>
                <input type="checkbox" name="display">
            </div>
            <button>Thêm banner</button>
        </form>
    </div>
    <?php
    include("include/footer.php");
    ?>