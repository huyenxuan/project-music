<?php
ob_start();
include("include/sidebar.php");
include("include/header.php");
include("../class/albumClass.php");
$album = new Album();

$album_id = $_GET['album_id'];
$get_album = $album->get_album_by_id($album_id);
if ($get_album) {
    $result = $get_album->fetch_assoc();
} else {
    echo 'Album does not exist';
    exit();
}
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $album_name = $_POST['album_name'];
    $authorAB = $result['user_id'];
    $description = $_POST['description'];
    $privacy = isset($_POST['privacy']) ? 'private' : 'public';

    if (!empty($_FILES['album_image']['name'])) {
        $album_image = $_FILES['album_image']['name'];
        $uploadDir = "upload/images/imagesong/";
        $uploadFile = $uploadDir . basename($album_image);

        if (move_uploaded_file($_FILES['album_image']['tmp_name'], $uploadFile)) {
            echo 'Upload thành công';
        } else {
            echo "Failed to upload image.";
        }
    } else {
        // Nếu không có ảnh mới, giữ nguyên ảnh cũ
        $album_image = $result['album_image'];
    }

    $update_album = $album->update_album($album_name, $authorAB, $album_image, $description, $privacy, $album_id);
    $song_id = $_POST['song_id'];
    if (is_numeric($song_id) && $song_id > 0)
        $add_song = $album->add_song_to_album($result['album_id'], $song_id);

    $adminId = $user_id;
    $actions = "Sửa Album";
    $details = "Sửa Album '$album_name'";
    $album->logAdminAction($adminId, $actions, $details);

    header('location: albumShow.php');
    exit();
}

$all_songs = $album->show_song_of_userId($result['user_id']);
$songs_in_album = $album->get_songs_in_album($result['album_id']);
$songs_in_album_ids = [];
if ($songs_in_album) {
    while ($song_row = $songs_in_album->fetch_assoc()) {
        $songs_in_album_ids[] = $song_row['song_id'];
    }
}

?>
<title>Cập nhật album</title>
<link rel="stylesheet" href="./css/album.css">
<style>
    form {
        width: 100%;
    }

    form input {
        margin-top: 7px !important;
    }

    select {
        height: 40px;
        outline: none;
        border: 1px solid black;
        margin: 7px 0 10px 15px;
        padding-left: 10px;
        border-radius: 10px;
        font-size: 15px;
        width: 90%;
    }

    option {
        height: 30px;
    }

    .main-content {
        margin: 15px;
    }

    form .info {
        display: flex !important;
    }

    .info div {
        /* margin-right: 10px; */
    }

    .image {
        display: flex;
    }

    .image div {
        width: 47%;
    }

    .image img {
        width: 20%;
        height: 177px;
        margin-left: 50px;
        border-radius: 0;
    }
</style>

<body>
    <div class="main-content">
        <form action="" method="POST">
            <h2 class="title" style="color:black; margin-bottom: 10px">Cập nhật Album</h2>
            <div class="info">
                <div class="name">
                    <label for="">Tên album <span style="color: red">*</span></label><br>
                    <input type="text" placeholder="Nhập tên Album" name="album_name"
                        value="<?php echo $result['album_name'] ?>"><br>
                </div>
                <div>
                    <label class="title" style="color:black;">Thêm bài hát vào Album</label><br>
                    <select name="song_id">
                        <option value="">--- Chọn bài hát ---</option>
                        <?php
                        if ($all_songs) {
                            while ($song_row = $all_songs->fetch_assoc()) {
                                // nếu như bài hát chưa được thêm vào album sẽ hiện ra
                                if (!in_array($song_row['song_id'], $songs_in_album_ids)) {
                                    echo "<option value='" . $song_row['song_id'] . "'>" . $song_row['song_name'] . "</option>";
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="image">
                <div>
                    <label for="image">Ảnh đại diện <span style="color: red">*</span></label><br>
                    <input id="image" type="file" name="album_image" accept="image/*">
                </div>
                <img src="upload/images/imagesong/<?php echo $result['album_image'] ?>" alt="">
            </div>
            <div class="description">
                <label for="">Mô tả </label><br>
                <textarea name="description" id="" rows="10" cols="30"><?php echo $result['description'] ?></textarea>
            </div>
            <div class="privacy">
                <label for="" style="margin-right: 10px">Riêng tư: </label>
                <input name="privacy" type="checkbox" <?php if ($result['privacy'] == 'private')
                    echo 'checked' ?>><br>
                </div>
                <button>Cập nhật</button>
            </form><br>
            <h2>Danh sách bài hát</h2>
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
                $show_albumSong = $album->get_album_songs($album_id);
                if ($show_albumSong) {
                    $i = 0;
                    while ($result = $show_albumSong->fetch_assoc()) {
                        $i++;
                        ?>
                        <tr style="height: 70px">
                            <td><?php echo $i ?></td>
                            <td><?php echo $result['song_name'] ?></td>
                            <td class="audio">
                                <audio controls>
                                    <source src="upload/song/<?php echo $result['file_path'] ?>">
                                </audio>
                            </td>
                            <td class="action">
                                <a onclick="return confirm('Bạn muốn xóa bài hát này khỏi album ?')"
                                    href="albumSongDel.php?albumSongId=<?php echo $result['album_song_id'] ?>">Xóa</a>
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

    <?php
    include("include/footer.php");
    ?>