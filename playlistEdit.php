<?php
include('./inc/header.php');

if (!isset($_SESSION['user_id'])) {
    header('location: index.php');
} else {
    $user_id = $_SESSION['user_id'];
}
$playlist_id = $_GET['playlist_id'];
$get_playlist = $frontend->get_playlist_by_id($playlist_id);
if ($get_playlist) {
    $result = $get_playlist->fetch_assoc();
} else {
    echo 'Playlist không tồn tại';
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addSong'])) {
        $song_id = $_POST['song_id'];
        if (is_numeric($song_id) && $song_id > 0) {
            $frontend->add_song_to_playlist($playlist_id, $song_id);
        }
        header('location: playlistEdit.php?playlist_id=' . $result['playlist_id']);
        exit();
    }
    if (isset($_POST['updatePlaylist'])) {
        $playlist_name = $_POST['playlist_name'];
        $authorPlaylist_id = $user_id;
        $privacy = isset($_POST['privacy']) ? 'private' : 'public';

        $frontend->update_playlist($playlist_name, $authorPlaylist_id, $privacy, $playlist_id);
        header('location: library.php');
    }
    if (isset($_POST['deleteSong'])) {
        $playlist_song_id = $_POST['playlist_song_id'];
        $frontend->delete_playlistSongId($playlist_id, $playlist_song_id);
    }
}

$all_songs = $frontend->show_song_hot();
$songs_in_playlist = $frontend->show_song_in_playlist($result['playlist_id']);
$songs_in_playlist_ids = [];
if ($songs_in_playlist) {
    while ($song_row = $songs_in_playlist->fetch_assoc()) {
        $songs_in_playlist_ids[] = $song_row['song_id'];
    }
}
?>
<title>Cập nhật playlist '
    <?php echo $result['playlist_name'] ?>'
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
<div class="title lib-title" style="margin-top: 0">Cập nhật playlist</div>
<main>
    <div class="form-ctn">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="info">
                <div class="album-name">
                    <label>Tên playlist</label><br>
                    <input required name="playlist_name" type="text" placeholder="Nhập tên playlist..."
                        value="<?php echo $result['playlist_name'] ?>">
                </div>
                <div class="list-song">
                    <label>Thêm bài hát <span>(Lưu ý: chỉ những bài hát để chế độ công khai
                            mới có thể thêm vào)</span></label><br>
                    <select name="song_id" id="">
                        <option value="">--- Chọn bài hát ---</option>
                        <?php
                        if ($all_songs) {
                            while ($song_row = $all_songs->fetch_assoc()) {
                                if (!in_array($song_row['song_id'], $songs_in_playlist_ids)) {
                                    echo "<option value='" . $song_row['song_id'] . "'>" . $song_row['song_name'] . "</option>";
                                }
                            }
                        }
                        ?>
                    </select>
                    <button name="addSong">Thêm bài hát</button>
                </div>
            </div>
            <button class="btn-update" name="updatePlaylist">Cập nhật</button>
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
                $show_playlistSong = $frontend->get_playlist_songs($playlist_id);
                if ($show_playlistSong) {
                    $i = 0;
                    while ($result = $show_playlistSong->fetch_assoc()) {
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
                                    <input type="hidden" name="playlist_song_id"
                                        value="<?php echo $result['playlist_song_id']; ?>">
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