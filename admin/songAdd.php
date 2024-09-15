<?php
ob_start();
include("include/sidebar.php");
include("include/header.php");
include('../class/songClass.php');

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
$song = new Song();

$erroSongName = '';
$erroCategory = '';
$erroAuthor = '';
$erroFilePath = '';
$erroSongImg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $song_name = $_POST['song_name'];
    $userSong_id = $_POST['user_id'];
    $category_id = $_POST['category_id'];
    $lyrics = $_POST['lyrics'];
    $privacy = isset($_POST['privacy']) ? 'private' : 'public';
    $song_image = $_FILES['song_image']['name'];
    $file_path = $_FILES['file_path']['name'];

    // kiểm tra các trường có rỗng hãy không
    if (empty($song_name)) {
        $erroSongName = "Vui lòng nhập trường này";
    } else if (preg_match('/^[^a-zA-Z]/', $song_name)) {
        $erroSongName = "Tên bài hát phải bắt đầu bằng chữ";
    }
    if (empty($category_id)) {
        $erroCategory = "Vui lòng nhập trường này";
    }
    if (empty($userSong_id)) {
        $erroAuthor = "Vui lòng nhập trường này";
    }
    if (empty($file_path)) {
        $erroFilePath = "Vui lòng nhập trường này";
    } else {
        $file_path_temp = $_FILES['file_path']['tmp_name'];
        $file_path_type = mime_content_type($file_path_temp);
        if (!in_array($file_path_type, ['audio/mpeg', 'audio/wav', 'audio/mp3'])) {
            $erroFilePath = "Chọn file có định dạng file âm thanh";
        }
    }
    if (empty($song_image)) {
        $erroSongImg = "Vui lòng nhập trường này";
    } else {
        $song_image_temp = $_FILES['song_image']['tmp_name'];
        $song_image_type = mime_content_type($song_image_temp);
        if (!in_array($song_image_type, ['image/jpeg', 'image/png', 'image/gif'])) {
            $erroSongImg = "Chọn file có định dạng file ảnh";
        }
    }

    if (empty($erroSongName) && empty($erroCategory) && empty($erroFilePath) && empty($erroSongImg)) {
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
                <?php if (!empty($erroSongName)) {
                    echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $erroSongName . "</span>";
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
                <?php if (!empty($erroCategory)) {
                    echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $erroCategory . "</span>";
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
                <?php if (!empty($erroAuthor)) {
                    echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $erroAuthor . "</span>";
                } ?>
            </div>
            <div class="file-song">
                <label for="">File nhạc <span style="color: red">*</span></label>
                <input type="file" name="file_path" accept="audio/*">
                <?php if (!empty($erroFilePath)) {
                    echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $erroFilePath . "</span>";
                } ?>
            </div>
            <div class="image">
                <label for="">Ảnh bìa <span style="color: red">*</span></label>
                <input type="file" name="song_image" accept="image/*">
                <?php if (!empty($erroSongImg)) {
                    echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $erroSongImg . "</span>";
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