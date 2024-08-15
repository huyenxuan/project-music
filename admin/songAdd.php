<?php
ob_start();
include('../class/songClass.php');
include("include/sidebar.php");
include("include/header.php");

$song = new Song();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $song_name = $_POST['song_name'];
    $userSong_id = $user_id;
    $category_id = $_POST['category_id'];
    $privacy = isset($_POST['privacy']) ? 'private' : 'public';
    $song_image = $_FILES['song_image']['name'];
    move_uploaded_file($_FILES['song_image']['tmp_name'], "upload/images/imagesong/" . $_FILES['song_image']['name']);
    $file_path = $_FILES['file_path']['name'];
    move_uploaded_file($_FILES['file_path']['tmp_name'], "upload/song/" . $file_path);

    $insert_song = $song->insert_song($song_name, $userSong_id, $category_id, $privacy, $song_image, $file_path);

    $adminId = $user_id;
    $action = "Thêm bài hát";
    $details = "Thêm bài hát '$song_name'";
    $song->logAdminAction($adminId, $action, $details);

    header("Location: songAdd.php?song_name=" . urlencode($song_name));
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
                <input required name="song_name" type="text" placeholder="Tên bài hát"><br>
            </div>
            <div class="category">
                <label for="">Thể loại</label><br>
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
            </div>
            <div class="file-song">
                <label for="">File nhạc</label>
                <input required type="file" name="file_path" accept="audio/*">
            </div>
            <div class="image">
                <label for="">Ảnh bìa</label>
                <input type="file" name="song_image" accept="image/*">
            </div>
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