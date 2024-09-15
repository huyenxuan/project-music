<?php
include('./inc/header.php');

if (!isset($_SESSION['user_id'])) {
    header('location: index.php');
} else {
    $user_id = $_SESSION['user_id'];
}
$album_id = $_GET['album_id'];
$get_album = $frontend->get_album_by_id($album_id);
if ($get_album) {
    $result = $get_album->fetch_assoc();
} else {
    echo 'Album không tồn tại';
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addSong'])) {
        $song_id = $_POST['song_id'];
        if (is_numeric($song_id) && $song_id > 0) {
            $frontend->add_song_to_album($result['album_id'], $song_id);
        }
        header('location: albumEdit.php?album_id=' . $result['album_id']);
        exit();
    }
    if (isset($_POST['updateAlbum'])) {
        $album_name = $_POST['album_name'];
        $authorAlbum_id = $user_id;
        $description = $_POST['description'];
        $privacy = isset($_POST['privacy']) ? 'private' : 'public';
        if (!empty($_FILES['album_image']['name'])) {
            $old_image = $result['album_image'];
            $album_image = $_FILES['album_image']['name'];
            $uploadDir = "./admin/upload/images/imagesong/";
            $uploadFile = $uploadDir . basename($album_image);

            if (move_uploaded_file($_FILES['album_image']['tmp_name'], $uploadFile)) {
                echo 'Upload thành công';
                // Delete the old image file
                if (file_exists($uploadDir . $old_image)) {
                    unlink($uploadDir . $old_image);
                }
            } else {
                echo "Lỗi upload ảnh.";
            }
        } else {
            $album_image = $result['album_image'];
        }
        $frontend->update_album($album_name, $authorAlbum_id, $album_image, $description, $privacy, $result['album_id']);
        header('location: library.php');
    }
    if (isset($_POST['deleteSong'])) {
        $album_song_id = $_POST['album_song_id'];
        $frontend->delete_albumSongId($album_id, $album_song_id);
    }
}

$all_songs = $frontend->show_song_of_user($result['user_id']);
$songs_in_album = $frontend->show_song_in_album($result['album_id']);
$songs_in_album_ids = [];
if ($songs_in_album) {
    while ($song_row = $songs_in_album->fetch_assoc()) {
        $songs_in_album_ids[] = $song_row['song_id'];
    }
}
?>
<title>Cập nhật album '<?php echo $result['album_name'] ?>'</title>
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

    main {
        width: 70%;
        height: auto;
        margin: 10px auto;
        background-color: rgb(57, 74, 96);
        padding: 10px 20px 40px 20px;
        box-sizing: border-box;
    }

    .form-ctn form {
        margin-top: 20px;
    }

    .form-ctn form div {
        margin-top: 20px;
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

    .description textarea {
        width: 710px;
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

    .btn-update {
        width: 150px;
        height: 50px;
        margin: 20px 0;
        border-radius: 10px;
        font-weight: 600;
        background-color: rgb(34, 53, 78, 0.9);
        color: white;
        border: none;
        outline: none;
        font-size: 20px;
    }

    table {
        width: 95%;
        border-collapse: collapse;
        text-align: center;
        color: white;
        margin-top: 5px;
    }

    thead tr {
        height: 30px;
    }

    tbody tr td {
        height: 70px;
    }

    .action {
        width: 100px;
    }

    .action button {
        color: black;
        background: red;
        width: 50px;
        margin: 0;
    }

    td a {
        color: green;
        font-weight: 600;
        text-decoration: none;
    }

    td a:last-child {
        color: red;
    }
</style>
<div class="title lib-title" style="margin-top: 0">Cập nhật album</div>
<main>
    <div class="form-ctn">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="info">
                <div class="album-name">
                    <label>Tên Album</label><br>
                    <input required name="album_name" type="text" placeholder="Nhập tên album..."
                        value="<?php echo $result['album_name'] ?>">
                </div>
                <div class="list-song">
                    <label>Thêm bài hát <span>(Lưu ý: chỉ những bài hát để chế độ công khai
                            mới có thể thêm vào)</span></label><br>
                    <select name="song_id" id="">
                        <option value="">--- Chọn bài hát ---</option>
                        <?php
                        if ($all_songs) {
                            while ($song_row = $all_songs->fetch_assoc()) {
                                if (!in_array($song_row['song_id'], $songs_in_album_ids)) {
                                    echo "<option value='" . $song_row['song_id'] . "'>" . $song_row['song_name'] . "</option>";
                                }
                            }
                        }
                        ?>
                    </select>
                    <button name="addSong">Thêm bài hát</button>
                </div>
            </div>
            <div class="description">
                <label>Mô tả</label><br>
                <textarea name="description" id="" placeholder="Nhập mô tả album..." spellcheck="false"></textarea>
            </div>
            <div class="album-image">
                <label>Ảnh đại diện</label><br>
                <input name="album_image" type="file" accept=".jpg,.jpeg,.png" id=""><br>
            </div>
            <button class="btn-update" name="updateAlbum">Cập nhật</button>
        </form>
    </div>
    <div class="list-song">
        <table border="1">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên bài hát</th>
                    <th>File</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="albumTableBody">
                <?php
                $show_albumSong = $frontend->get_album_songs($album_id);
                if ($show_albumSong) {
                    $i = 0;
                    while ($result = $show_albumSong->fetch_assoc()) {
                        $i++;
                        ?>
                        <tr style="height: 70px">
                            <td>
                                <?php echo $i ?>
                            </td>
                            <td>
                                <?php echo $result['song_name'] ?>
                            </td>
                            <td class="audio">
                                <audio controls>
                                    <source src="./admin/upload/song/<?php echo $result['file_path'] ?>">
                                </audio>
                            </td>
                            <td class="action">
                                <form method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa bài hát này không?');">
                                    <input type="hidden" name="album_song_id" value="<?php echo $result['album_song_id']; ?>">
                                    <button type="submit" name="deleteSong" class="btn-delete">Xóa</button>
                                </form>
                            </td>

                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="4">Không có bài hát nào</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</main>
</div>
<script src="script.js"></script>
</body>

</html>