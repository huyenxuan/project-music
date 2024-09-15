<?php
ob_start();
include("include/sidebar.php");
include("include/header.php");
include("../class/bannerClass.php");
$banner = new Banner();

$banner_id = $_GET['banner_id'];

$get_banner_by_id = $banner->get_banner_by_id($banner_id);
if ($get_banner_by_id) {
    $result = $get_banner_by_id->fetch_assoc();
} else {
    echo 'Không tồn tại banner này';
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

$erroBanner = '';
$erroPathway = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $banner_name = $_POST['banner_name'];
    $pathway = $_POST['pathway'];
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
    if (!empty($banner_image)) {
        // kiểm tra tệp tải lên có đúng chuẩn không
        $banner_image_temp = $_FILES['banner_image']['tmp_name'];
        $banner_image_type = mime_content_type($banner_image_temp);
        if (!in_array($banner_image_type, ['image/jpeg', 'image/png', 'image/gif'])) {
            $erroBannerImg = 'Sai định dạng ảnh';
        }
    }

    if (!empty($_FILES['banner_image']['name'])) {
        $banner_image = $_FILES['banner_image']['name'];
        $uploadDir = "upload/banner/";
        $uploadFile = $uploadDir . basename($banner_image);
        $banner_image_temp = $_FILES['banner_image']['tmp_name'];
        $banner_image_type = mime_content_type($banner_image_temp);

        if (!in_array($banner_image_type, ['image/jpeg', 'image/png', 'image/gif'])) {
            $erroBannerImg = 'Sai định dạng ảnh';
        } else if (move_uploaded_file($_FILES['banner_image']['tmp_name'], $uploadFile)) {
            echo 'Upload thành công';
        } else {
            echo "Failed to upload image.";
        }
    } else {
        $banner_image = $result['banner_image'];
    }
    if (empty($erroBanner) && empty($erroBannerImg) && empty($erroPathway)) {
        $update_banner = $banner->update_banner($banner_name, $banner_image, $pathway, $display, $banner_id);
        if ($update_banner) {
            $adminId = $user_id;
            $actions = "Cập nhật banner";
            $details = "Cập nhật banner '$banner_name'";
            $banner->logAdminAction($adminId, $actions, $details);
            ?>
            <!-- thông báo thành công -->
            <script>alert('Đã cập nhật thành công')</script>
            <?php
            header('location: bannerShow.php');
            exit();
        }
    }
}
?>
<title>Cập nhật Banner</title>
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

    .pathway {
        width: 45%;
    }

    .info img {
        border-radius: unset;
        width: 100px;
        height: auto;
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
        <h2 class="title" style="color:black">Chỉnh sửa banner</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="info">
                <div class="name">
                    <label for="">Tên banner <span style="color: red">*</span></label><br>
                    <input required name="banner_name" type="text" placeholder="Tên banner"
                        value="<?php echo $result['banner_name']; ?>">
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
                <div class="pathway">
                    <label for="">Đường dẫn <span style="color: red">*</span></label>
                    <input required type="text" name="pathway" placeholder="Nhập đường dẫn"
                        value="<?php echo $result['pathway'] ?>">
                    <?php if (!empty($erroPathway)) {
                        echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $erroPathway . "</span>";
                    } ?>
                </div>
                <img src="upload/banner/<?php echo $result['banner_image'] ?>" alt="">
            </div>
            <div class="privacy display">
                <label for="">Hiện banner</label>
                <input type="checkbox" name="display" <?php if ($result['display'] === 'show')
                    echo 'checked' ?>>
                </div>
                <button>Cập nhật</button>
            </form>
        </div>
        <?php
                include("include/footer.php");
                ?>