<?php
ob_start();
include("include/sidebar.php");
include("include/header.php");
include("../class/playlistClass.php");
$playlist = new PlayList();

$playlist_id = $_GET['playlist_id'];
$get_playlist = $playlist->get_playlist_by_id($playlist_id);
if ($get_playlist) {
    $result = $get_playlist->fetch_assoc();
} else {
    echo 'Playlist does not exist';
    exit();
}
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $playlist_name = $_POST['playlist_name'];
    $authorPL = $user_id;
    $song_id = $_POST['song_id'];
    if (isset($_POST['upd_playlistsong'])) {
        if (is_numeric($song_id) && $song_id > 0) {
            $add_song = $playlist->add_song_to_playlist($playlist_id, $song_id);
            // header('location: ')
        }
    }
    if (isset($_POST['upd_playlist'])) {
        $update_playlist = $playlist->update_playlist($playlist_name, $authorPL, $playlist_id);
        $adminId = $user_id;
        $actions = "Sửa Playlist";
        $details = "Sửa Playlist '$playlist_name'";
        $playlist->logAdminAction($adminId, $actions, $details);
        header('location: playlistShow.php');
    }
}

$all_songs = $playlist->show_song();
$songs_in_playlist = $playlist->get_songs_in_playlist($result['playlist_id']);
$songs_in_playlist_ids = [];
if ($songs_in_playlist) {
    while ($song_row = $songs_in_playlist->fetch_assoc()) {
        $songs_in_playlist_ids[] = $song_row['song_id'];
    }
}
?>
<title>Cập nhật Playlist</title>
<link rel="stylesheet" href="./css/category.css">
<style>
    select {
        height: 40px;
        outline: none;
        border: 1px solid black;
        margin-top: 7px;
        padding-left: 10px;
        border-radius: 5px;
        font-size: 15px;
        width: 90%;
        /* margin: 10px 0 0 15px; */
    }

    option {
        height: 30px;
    }

    .main-content {
        margin: 15px;
    }

    form .info {
        display: flex;
    }

    .info div {
        margin-right: 150px;
    }

    label {
        font-weight: 600;
    }
</style>

<body>
    <div class="main-content">
        <h2 class="title" style="color:black; margin-bottom: 10px">Cập nhật Playlist</h2>
        <form action="" method="POST">
            <div class="info">
                <div>
                    <h3 class="title" style="color:black;">Tên Playlist <span style="color: red">*</span>
                    </h3>
                    <input type="text" placeholder="Enter playlist name" name="playlist_name"
                        value="<?php echo $result['playlist_name'] ?>"><br>
                </div>
                <div>
                    <h3 class="title" style="color:black;">Thêm bài hát vào Playlist</h3>
                    <select name="song_id">
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
                    <button name="upd_playlistsong">Thêm bài hát</button>
                </div>
            </div>
            <button name="upd_playlist">Cập nhật</button>
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
            <tbody id="playlistTableBody">
                <?php
                $show_playlistSong = $playlist->get_playlist_songs($playlist_id);
                if ($show_playlistSong) {
                    $i = 0;
                    while ($result = $show_playlistSong->fetch_assoc()) {
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
                                <a onclick="return confirm('Bạn muốn xóa bài hát này khỏi playlist ?')"
                                    href="playlistSongDel.php?playlistSongId=<?php echo $result['playlist_song_id'] ?>">Xóa</a>
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