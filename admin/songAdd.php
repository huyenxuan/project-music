<?php
ob_start();
include("include/sidebar.php");
include("include/header.php");
include('../class/songClass.php');

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

$erroEmpty = "Vui lòng nhập trường này";
$erroNameFormat = "Tên bài hát phải bắt đầu bằng chữ";
$erroFileSongFormat = "Chọn file có định dạng file âm thanh";
$erroSongImageFormat = "Chọn file có định dạng file hình ảnh";

$song = new Song();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $song_name = $_POST['song_name'];
    $userSong_id = $_POST['user_id'];
    $category_id = $_POST['category_id'];
    $lyrics = $_POST['lyrics'];
    $privacy = isset($_POST['privacy']) ? 'private' : 'public';
    $song_image = $_FILES['song_image']['name'];
    $file_path = $_FILES['file_path']['name'];

    // kiểm tra tệp tải lên có đúng chuẩn không
    $song_image_temp = $_FILES['song_image']['tmp_name'];
    $file_path_temp = $_FILES['file_path']['tmp_name'];
    $song_image_type = mime_content_type($song_image_temp);
    $file_path_type = mime_content_type($file_path_temp);

    // kiểm tra các trường có rỗng hãy không
    if (empty($song_name)) {
        $song_name_error = $erroEmpty;
    } else if (preg_match('/^[^a-zA-Z]/', $song_name)) {
        $song_name_error = $erroNameFormat;
    }
    if (empty($category_id)) {
        $category_error = $erroEmpty;
    }
    if (empty($userSong_id)) {
        $author_error = $erroEmpty;
    }
    if (empty($file_path)) {
        $file_path_error = $erroEmpty;
    } else if (!in_array($file_path_type, ['audio/mpeg', 'audio/wav', 'audio/mp3'])) {
        $file_path_error = $erroFileSongFormat;
    }
    if (empty($song_image)) {
        $song_image_error = $erroEmpty;
    } else if (!in_array($song_image_type, ['image/jpeg', 'image/png', 'image/gif'])) {
        $song_image_error = $erroSongImageFormat;
    }

    if (empty($song_name_error) && empty($category_error) && empty($file_path_error) && empty($song_image_error)) {
        move_uploaded_file($song_image_temp, "upload/images/imagesong/" . $song_image);
        move_uploaded_file($file_path_temp, "upload/song/" . $file_path);

        $song->insert_song($song_name, $userSong_id, $category_id, $lyrics, $privacy, $song_image, $file_path);

        $adminId = $user_id;
        $action = "Thêm bài hát";
        $details = "Thêm bài hát '$song_name'";
        $song->logAdminAction($adminId, $action, $details);

        header("Location: songAdd.php?&song_name=" . urlencode($song_name));
        exit();
    }
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
    }

    .info div input {
        width: 90% !important;
    }

    .image {
        width: 200px;
        overflow: hidden;
    }

    .image img {
        width: 100%;
        object-fit: contain;
        padding: 5px 0 10px 10px;
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

    .lyrics textarea {
        width: 95%;
        margin-left: 15px;
        height: 200px;
        margin-top: 10px;
        border-radius: 14px;
        padding: 20px;
    }

    form input {
        margin: 10px 0 0 15px !important;
    }

    form div {
        margin-bottom: 10px;
    }
</style>
<link rel="stylesheet" href="./css/user.css">
<title>Thêm bài hát</title>
<!-- main content -->
<div class="main-content">
    <h2 class="title">Thêm bài hát</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="info">
            <div class="name">
                <label>Tên bài hát <span style="color: red">*</span></label><br>
                <input name="song_name" type="text" placeholder="Tên bài hát"><br>
                <?php if (!empty($song_name_error)) {
                    echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $song_name_error . "</span>";
                } ?>
            </div>
            <div class="category">
                <label for="">Thể loại <span style="color: red">*</span></label><br>
                <select name="category_id" id="">
                    <option value="">--- Chọn Thể Loại ---</option>
                    <?php
                    $show_category = $song->show_category();
                    if ($show_category) {
                        while ($result = $show_category->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $result['category_id'] ?>"><?php echo $result['category_name'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <?php if (!empty($category_error)) {
                    echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $category_error . "</span>";
                } ?>
            </div>
            <div class="author">
                <label for="">Tên tác giả <span style="color: red">*</span></label><br>
                <select name="user_id" id="">
                    <option value="">--- Chọn Tác giả ---</option>
                    <?php
                    $show_user = $song->show_user();
                    if ($show_user) {
                        while ($result = $show_user->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $result['user_id'] ?>"><?php echo $result['fullName'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <?php if (!empty($author_error)) {
                    echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $author_error . "</span>";
                } ?>
            </div>
            <div class="file-song">
                <label for="">File nhạc <span style="color: red">*</span></label>
                <input type="file" name="file_path" accept="audio/*">
                <?php if (!empty($file_path_error)) {
                    echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $file_path_error . "</span>";
                } ?>
            </div>
            <div class="image">
                <label for="">Ảnh bìa <span style="color: red">*</span></label>
                <input type="file" name="song_image" accept="image/*">
                <?php if (!empty($song_image_error)) {
                    echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $song_image_error . "</span>";
                } ?>
            </div>
        </div>
        <div class="lyrics">
            <label for="">Lời bài hát</label><br>
            <textarea name="lyrics" id=""></textarea>
        </div>
        <div class="privacy">
            <label for="">Riêng tư</label>
            <input type="checkbox" name="privacy">
        </div>
        <button>Thêm</button>
    </form>
</div>
<?php
include("include/footer.php");
?>