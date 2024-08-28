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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $album_name = $_POST['album_name'];
    $authorAB = $_POST['authorAB'];
    $description = $_POST['description'];
    $privacy = isset($_POST['privacy']) ? 'private' : 'public';
    $album_image = $_FILES['album_image']['name'];
    move_uploaded_file($_FILES['album_image']['tmp_name'], "upload/images/imagesong/" . $album_image);

    $insert_album = $album->insert_album($album_name, $authorAB, $album_image, $description, $privacy);

    $adminId = $user_id;
    $actions = "Thêm album";
    $details = "Thêm album '$album_name'";
    $album->logAdminAction($adminId, $actions, $details);

    header('location: albumAdd.php?albumName=' . urldecode($album_name));
    exit();
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
</style>

<body>
    <div class="main-content">
        <h2 class="title" style="color:black">Thêm album</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="info">
                <div class="name">
                    <label for="">Tên album <span style="color: red">*</span></label><br>
                    <input required name="album_name" type="text" placeholder="Tên album">
                </div>
                <div class="image">
                    <label for="image">Ảnh đại diện <span style="color: red">*</span></label>
                    <input required id="image" type="file" name="album_image" accept="image/*">
                </div>
            </div>
            <div class="author">
                <label for="">Tác giả <span style="color: red">*</span></label>
                <select required name="authorAB" id="">
                    <option value="">--- Chọn tác giả ---</option>
                    <?php
                    if ($show_user) {
                        while ($result = $show_user->fetch_assoc()) {
                            echo "<option value='" . $result['user_id'] . "'>" . $result['fullName'] . "</option>";
                        }
                    }
                    ?>
                </select>
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