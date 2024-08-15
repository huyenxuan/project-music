<?php
ob_start();
include("../class/playlistClass.php");
$playlist = new PlayList();

$playlist_slug = $_GET['slugPlaylist'];
$get_playlist = $playlist->get_playlist_by_slug($playlist_slug);
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
    $update_playlist = $playlist->update_playlist($playlist_name, $result['playlist_id']);
    $song_id = $_POST['song_id'];
    if (is_numeric($song_id) && $song_id > 0)
        $add_song = $playlist->add_song_to_playlist($result['playlist_id'], $song_id);

    $adminId = $user_id;
    $actions = "Sửa Playlist";
    $details = "Sửa Playlist '$playlist_name'";
    $playlist->logAdminAction($adminId, $actions, $details);
    header('location: playlistShow.php');
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

<?php
include("include/sidebar.php");
include("include/header.php");
?>
<title>Sửa Playlist</title>
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
</style>

<body>
    <div class="main-content">
        <form action="" method="POST">
            <div class="info">
                <div>
                    <h2 class="title" style="color:black">Sửa Playlist</h2>
                    <input type="text" placeholder="Enter playlist name" name="playlist_name" value="<?php echo $result['playlist_name'] ?>"><br>
                </div>
                <div>
                    <h2 class="title" style="color:black;">Thêm bài hát vào Playlist</h2>
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
                </div>
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
            <tbody id="playlistTableBody">
                <?php
                $show_playlistSong = $playlist->get_playlist_songs($playlist_slug);
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
                                <a onclick="return confirm('Bạn muốn xóa bài hát này khỏi playlist ?')" href="playlistSongDel.php?playlistSongId=<?php echo $result['playlist_song_id'] ?>">Xóa</a>
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