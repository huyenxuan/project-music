<?php
include('./inc/header.php');

if (!isset($_SESSION['user_id'])) {
    header('location: index.php');
} else {
    $user_id = $_SESSION['user_id'];
}
$song_id = $_GET['song_id'];
$get_song = $frontend->get_song_by_id($song_id);
if ($get_song) {
    $result = $get_song->fetch_assoc();
} else {
    echo 'Bài hát không tồn tại';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['updateSong'])) {
        $song_name = $_POST['song_name'];
        $authorSong_id = $user_id;
        $category_id = $_POST['category_id'];
        $lyrics = $_POST['lyrics'];
        $privacy = isset($_POST['privacy']) ? 'private' : 'public';

        if (!empty($_FILES['song_image']['name'])) {
            $song_image = $_FILES['song_image']['name'];
            $uploadDir = "./admin/upload/images/imagesong/";
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
            $uploadDir = "./admin/upload/song/";
            $uploadFile = $uploadDir . basename($file_path);

            if (move_uploaded_file($_FILES['file_path']['tmp_name'], $uploadFile)) {
                echo 'Upload thành công';
            } else {
                echo "Failed to upload image.";
            }
        } else {
            $file_path = $result['file_path'];
        }

        if (is_numeric($category_id) && $category_id > 0) {
            $frontend->update_song($song_name, $authorSong_id, $category_id, $lyrics, $privacy, $song_image, $file_path, $song_id);
        }
        header('location: library.php');
        exit();
    }
}
?>
<title>Cập nhật bài hát '<?php echo $result['song_name'] ?>'
</title>
<style>
    body {
        height: 100%;
    }

    .title {
        margin: auto;
        padding-top: 35px;
    }

    .mainBody {
        height: auto;
    }

    .addSong {
        padding: 0 35px;
    }

    main {
        width: 70%;
        height: auto;
        margin: 10px auto;
        background-color: rgb(57, 74, 96);
        padding: 10px 20px 40px 20px;
        box-sizing: border-box;
    }

    form {
        width: 100%;
    }

    form div {
        width: 100% !important;
    }

    form .name {
        width: 620px !important;
        margin-right: -67px;
    }

    form .name input {
        cursor: auto;
    }

    select {
        cursor: pointer;
    }

    .category {
        margin-left: 167px;
    }

    form p {
        color: white;
        font-size: 19px;
        margin-top: 25px
    }

    .form-ctn form .info {
        display: flex;
        margin: 0;
        width: 100%;
    }

    .info div {
        margin: 0;
    }

    .form-ctn form label {
        color: white;
        font-size: 20px;
    }

    .form-ctn form input[type="text"] {
        width: 100%;
        height: 40px;
        border-radius: 15px;
        padding: 5px 10px;
        font-size: 17px;
        outline: none;
        margin-left: 15px;
    }

    .form-ctn form span {
        font-size: 13px;
        color: red;
    }

    .form-ctn form select {
        width: 250px;
        height: 40px;
        border-radius: 15px;
        padding: 5 10px;
        font-size: 17px;
        outline: none;
        margin-left: 15px !important;
    }

    .form-ctn form .list-song {
        margin-left: 100px;
    }

    .list-song button {
        width: 100px;
        height: 30px;
        border-radius: 10px;
        outline: none;
        border: none;
        margin-left: 10px;
    }

    form input,
    textarea {
        color: black;
    }

    textarea {
        width: 680px;
        border-radius: 10px;
        height: 100px;
        margin-left: 15px;
        padding: 7px 10px;
        font-size: 17px;
        outline: none;
    }

    .form-ctn form .album-image {
        color: white;
    }

    .form-ctn .album-image input {
        margin-left: 15px;
        font-size: 17px;
    }

    .addSong button {
        margin-top: 40px;
        width: 130px;
        border-radius: 15px;
        height: 40px;
        font-size: 18px;
        font-weight: bold;
        outline: none;
        border: none;
    }
</style>
<div class="title lib-title" style="margin-top: 0">Chỉnh sửa bài hát</div>
<main>
    <div class="form-ctn">
        <form class="addSong" action="" method="POST" enctype="multipart/form-data">
            <div style="display: flex; width: 80%; margin: 0;">
                <div class="name" style="margin: 0;">
                    <p>Tên bài hát</p>
                    <input required name="song_name" type="text" placeholder="Nhập tên bài hát..."
                        value="<?php echo $result['song_name'] ?>">
                </div>
                <div class="category">
                    <p>Thể loại</p>
                    <select required name="category_id" id="">
                        <?php
                        $show_category = $frontend->show_category();
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
            </div>
            <div>
                <p>Lời bài hát</p>
                <textarea name="lyrics" id="" placeholder="Nhập lời bài hát..."
                    spellcheck="false"><?php echo $result['lyrics'] ?></textarea>
            </div>
            <div class="privacy" style="display: flex; lign-items: center;">
                <p>Riêng tư</p>
                <input type="checkbox" name="privacy" style="width:25px; margin-top:15px" <?php if ($result['privacy'] === 'private')
                    echo 'checked' ?>>
                </div>
                <div style="display:flex">
                    <div>
                        <p>Ảnh đại diện</p>
                        <input name="song_image" type="file" accept=".jpg,.jpeg,.png" name="" id="">
                    </div>
                    <div>
                        <p>Tải lên bài hát</p>
                        <input name="file_path" type="file" accept=".mp3" name="" id="">
                    </div>
                </div>
                <button name="updateSong">Xác nhận</button>
            </form>
        </div>
    </main>
    </div>
    <script src="script.js"></script>
    </body>

    </html>