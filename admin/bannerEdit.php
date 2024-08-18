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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $banner_name = $_POST['banner_name'];
    $pathway = $_POST['pathway'];

    if (!empty($_FILES['banner_image']['name'])) {
        $banner_image = $_FILES['banner_image']['name'];
        $uploadDir = "upload/banner/";
        $uploadFile = $uploadDir . basename($banner_image);

        if (move_uploaded_file($_FILES['banner_image']['tmp_name'], $uploadFile)) {
            echo 'Upload thành công';
        } else {
            echo "Failed to upload image.";
        }
    } else {
        $banner_image = $result['banner_image'];
    }

    $update_banner = $banner->update_banner($banner_name, $banner_image, $pathway, $banner_id);

    $adminId = $user_id;
    $actions = "Cập nhật banner";
    $details = "Cập nhật banner '$banner_name'";
    $banner->logAdminAction($adminId, $actions, $details);

    header('location: bannerShow.php');
    exit();
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
</style>

<body>
    <div class="main-content">
        <h2 class="title" style="color:black">Thêm banner</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="info">
                <div class="name">
                    <label for="">Tên banner <span style="color: red">*</span></label><br>
                    <input required name="banner_name" type="text" placeholder="Tên banner"
                        value="<?php echo $result['banner_name']; ?>">
                </div>
                <div class="image">
                    <label for="image">Ảnh banner <span style="color: red">*</span></label>
                    <input id="image" type="file" name="banner_image" accept="image/*">
                </div>
                <div class="pathway">
                    <label for="">Đường dẫn</label>
                    <input required type="text" name="pathway" placeholder="Nhập đường dẫn"
                        value="<?php echo $result['pathway'] ?>">
                </div>
                <img src="upload/banner/<?php echo $result['banner_image'] ?>" alt="">
            </div>
            <button>Cập nhật</button>
        </form>
    </div>
    <?php
    include("include/footer.php");
    ?>