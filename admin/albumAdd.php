<?php
ob_start();
include("include/sidebar.php");
include("include/header.php");
include("../class/albumClass.php");
$album = new Album();
$show_user = $album->show_user();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

$erroAlbumName = '';
$erroAlbumImg = '';
$erroAuthorAB = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $album_name = $_POST['album_name'];
    $authorAB = $_POST['authorAB'];
    $description = $_POST['description'];
    $privacy = isset($_POST['privacy']) ? 'private' : 'public';
    $album_image = $_FILES['album_image']['name'];

    // kiểm tra các trường có rỗng hãy không
    if (empty($album_name)) {
        $erroAlbumName = "Vui lòng nhập trường này";
    } else if (preg_match('/^[^a-zA-Z]/', $albumname)) {
        $erroAlbumName = "Tên bài hát phải bắt đầu bằng chữ";
    }
    if (empty($authorAB)) {
        $erroAuthorAB = "Vui lòng nhập trường này";
    }
    if (empty($album_image)) {
        $erroAlbumImg = "Vui lòng nhập trường này";
    } else {
        $album_image_temp = $_FILES['album_image']['tmp_name'];
        $album_image_type = mime_content_type($album_image_temp);
        if (!in_array($album_image_type, ['image/jpeg', 'image/png', 'image/gif'])) {
            $erroSongImg = "Chọn file có định dạng file ảnh";
        }
    }

    if (empty($erroAlbumName) && empty($erroAlbumImg) && empty($erroAlbumAB)) {
        move_uploaded_file($_FILES['album_image']['tmp_name'], "upload/images/imagesong/" . $album_image);

        $insert_album = $album->insert_album($album_name, $authorAB, $album_image, $description, $privacy);

        $adminId = $user_id;
        $actions = "Thêm album";
        $details = "Thêm album '$album_name'";
        $album->logAdminAction($adminId, $actions, $details);

        header('location: albumAdd.php?albumName=' . urldecode($album_name));
        exit();
    }

}
?>
<title>Thêm Album</title>
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

    form div {
        margin-bottom: 10px;
    }

    form input {
        margin: 0 !important;
    }

    select {
        margin-bottom: 0;
    }
</style>

<body>
    <div class="main-content">
        <h2 class="title" style="color:black">Thêm album</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="info">
                <div class="name">
                    <label for="">Tên album <span style="color: red">*</span></label><br>
                    <input name="album_name" type="text" placeholder="Tên album">
                    <?php if (!empty($erroAlbumName)) {
                        echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $erroAlbumName . "</span>";
                    } ?>
                </div>
                <div class="image">
                    <label for="image">Ảnh đại diện <span style="color: red">*</span></label>
                    <input id="image" type="file" name="album_image" accept="image/*">
                    <?php if (!empty($erroAlbumImg)) {
                        echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $erroAlbumImg . "</span>";
                    } ?>
                </div>
            </div>
            <div class="author">
                <label for="">Tác giả <span style="color: red">*</span></label>
                <select name="authorAB" id="">
                    <option value="">--- Chọn tác giả ---</option>
                    <?php
                    if ($show_user) {
                        while ($result = $show_user->fetch_assoc()) {
                            echo "<option value='" . $result['user_id'] . "'>" . $result['fullName'] . "</option>";
                        }
                    }
                    ?>
                </select><br>
                <?php if (!empty($erroAuthorAB)) {
                    echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $erroAuthorAB . "</span>";
                } ?>
            </div>
            <div class="description">
                <label for="">Mô tả </label><br>
                <textarea name="description" id="" rows="10" cols="30"></textarea>
            </div>
            <div class="privacy">
                <label for="" style="margin-right: 10px">Riêng tư: </label>
                <input name="privacy" type="checkbox"><br>
            </div>
            <button>Thêm</button>
        </form>
    </div>
    <?php
    include("include/footer.php");
    ?>