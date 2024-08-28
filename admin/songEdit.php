<?php
ob_start();
include("include/sidebar.php");
include("include/header.php");
include('../class/songClass.php');

$song = new Song();

$song_id = $_GET['song_id'];
$get_song = $song->get_song_by_id($song_id);

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

if ($get_song) {
    $result = $get_song->fetch_assoc();
    $song_id = $result['song_id'];
} else {
    echo 'Không tồn tại bài hát này';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $song_name = $_POST['song_name'];
    $userSong_id = $user_id;
    $category_id = $_POST['category_id'];
    $lyrics = $_POST['lyrics'];
    $privacy = isset($_POST['privacy']) ? 'private' : 'public';

    if (!empty($_FILES['song_image']['name'])) {
        $song_image = $_FILES['song_image']['name'];
        $uploadDir = "upload/images/imagesong/";
        $uploadFile = $uploadDir . basename($song_image);

        if (move_uploaded_file($_FILES['song_image']['tmp_name'], $uploadFile)) {
            echo 'Upload thành công';
        } else {
            echo "Failed to upload image.";
        }
    } else {
        $song_image = $result['song_image'];
    }

    if (!empty($_FILES['file_path']['name'])) {
        $file_path = $_FILES['file_path']['name'];
        $uploadDir = "upload/song/";
        $uploadFile = $uploadDir . basename($file_path);

        if (move_uploaded_file($_FILES['file_path']['tmp_name'], $uploadFile)) {
            echo 'Upload thành công';
        } else {
            echo "Failed to upload image.";
        }
    } else {
        $file_path = $result['file_path'];
    }
    $update_song = $song->update_song($song_name, $userSong_id, $category_id, $lyrics, $privacy, $song_image, $file_path, $song_id);

    $adminId = $user_id;
    $action = "Sửa bài hát";
    $details = "Sửa bài hát '$song_name'";
    $song->logAdminAction($adminId, $action, $details);

    header("Location: songShow.php");
    exit();
}
?>
<style>
    form {
        margin-bottom: 10px;
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
        margin-bottom: 5px;
    }

    .info div input {
        width: 90% !important;
    }

    .image {
        width: 200px;
        overflow: hidden;
    }

    .image img {
        width: 50%;
        object-fit: contain;
        padding: 10px 0 10px 10px;
        margin-left: 5px;
    }

    audio {
        width: 91%;
        margin: 10px 0 10px 10px;
    }

    select {
        height: 40px;
        outline: none;
        border: 1px solid black;
        padding-left: 10px;
        border-radius: 5px;
        font-size: 15px;
        width: 90%;
        margin: 10px 0 0 15px;
    }

    option {
        height: 30px;
    }

    .main-content {
        margin: 15px;
    }

    form img {
        margin: 0;
        border: none
    }

    .lyrics textarea {
        width: 95%;
        margin-left: 15px;
        height: 200px;
        margin-top: 10px;
        border-radius: 14px;
        padding: 20px;
    }
</style>
<link rel="stylesheet" href="./css/user.css">
<title>Thêm bài hát</title>
<!-- main content -->
<div class="main-content">
    <h2 class="title">Sửa bài hát</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="info">
            <div class="name">
                <label>Tên bài hát <span style="color: red">*</span></label><br>
                <input required name="song_name" type="text" placeholder="Tên bài hát"
                    value="<?php echo $result['song_name'] ?>"><br>
            </div>
            <div class="category">
                <label for="">Thể loại <span style="color: red">*</span></label><br>
                <select required name="category_id" id="">
                    <?php
                    $show_category = $song->show_category();
                    if ($show_category) {
                        while ($resultCategory = $show_category->fetch_assoc()) {
                            ?>
                            <option <?php if ($result['category_id'] === $resultCategory['category_id'])
                                echo 'selected' ?>
                                    value="<?php echo $resultCategory['category_id'] ?>">
                                <?php echo $resultCategory['category_name'] ?>
                            </option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="author">
                <label for="">Tên tác giả <span style="color: red">*</span></label><br>
                <select required name="category_id" id="">
                    <?php
                    $show_category = $song->show_category();
                    if ($show_category) {
                        while ($resultCategory = $show_category->fetch_assoc()) {
                            ?>
                            <option <?php if ($result['category_id'] === $resultCategory['category_id'])
                                echo 'selected' ?>
                                    value="<?php echo $resultCategory['category_id'] ?>">
                                <?php echo $resultCategory['category_name'] ?>
                            </option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="file-song">
                <label for="">File nhạc <span style="color: red">*</span></label><br>
                <audio controls required>
                    <source src="upload/song/<?php echo $result['file_path'] ?>">
                </audio>
                <input type="file" name="file_path" accept="audio/*">
            </div>
            <div class="image">
                <label for="">Ảnh bìa <span style="color: red">*</span></label><br>
                <img src="upload/images/imagesong/<?php echo $result['song_image'] ?>" alt="">
                <input type="file" name="song_image" accept="image/*">
            </div>
        </div>
        <div class="lyrics">
            <label for="">Lời bài hát</label><br>
            <textarea name="lyrics" id=""><?php echo $result['lyrics'] ?></textarea>
        </div>
        <div class="privacy">
            <label for="">Riêng tư</label>
            <input type="checkbox" name="privacy" <?php if ($result['privacy'] === 'private')
                echo 'checked' ?>>
            </div>
            <button>Cập nhật</button>
        </form>
    </div>
    <?php
            include("include/footer.php");
            ?>