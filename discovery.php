<?php
include("./inc/header.php");

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $show_playlist_of_user = $frontend->show_playlist_of_user($user_id);
} else {
    $show_playlist_of_user = 0;
}


$show_song_new = $frontend->show_song_new();
$show_album_new = $frontend->show_album_new();
$show_playlist_new = $frontend->show_playlist_new();
?>

<title>Khám phá</title>
<link rel="stylesheet" href="./css/home.css">
<style>
    .sidebar .btn-play i {
        pointer-events: none;
    }

    .btnActive {
        color: rgb(66, 158, 255);
    }
</style>

<div class="mainBox">

    <!-- new -->
    <div class="home-recommend">
        <div class="home-recommend-title">
            <h1>Sản phẩm mới ra mắt</h1>
        </div>
        <div class="home-recommend-container">
            <!-- new song -->
            <h3>Bài hát mới ra</h3>
            <div class="song-container">
                <?php
                if ($show_song_new) {
                    while ($resultSongNew = $show_song_new->fetch_assoc()) {
                        // Kiểm tra xem bài hát có trong yêu thích không
                        $isFavorite = isset($_SESSION['user_id']) ? $frontend->check_song_in_favorite($_SESSION['user_id'], $resultSongNew['song_id']) : false;
                        ?>
                        <!-- song item -->
                        <div class="recommend-song" data-id="<?php echo $resultSongNew['song_id'] ?>">
                            <audio hidden>
                                <source src="admin/upload/song/<?php echo $resultSongNew['file_path'] ?>" type="audio/mp3">
                            </audio>
                            <div class="recommend-cover">
                                <img src="./admin/upload/images/imagesong/<?php echo $resultSongNew['song_image'] ?>" alt="">
                                <div class="cover-overlay">
                                    <button class="btn-play"><i class="fa-solid fa-play"></i></button>
                                </div>
                            </div>
                            <div class="recommend-name">
                                <div class="song-name"><?php echo $format->textShorten($resultSongNew['song_name'], 25) ?></div>
                                <div class="author-name"><a
                                        href="otheruser.php?user_id=<?php echo $resultSongNew['user_id'] ?>"><?php echo $resultSongNew['authorSong'] ?></a>
                                </div>
                            </div>
                            <button class="boxtestMenuBtn btn-heart">
                                <i class="<?php echo $isFavorite ? 'fa-solid fa-heart' : 'fa-regular fa-heart' ?>"></i>
                            </button>
                            <button class="boxtestMenuBtn btn_menu"><i class="fa-solid fa-ellipsis"></i></button>
                            <!-- submenu -->
                            <div class="add-playlist">
                                <p>Thêm vào playlist:</p>
                                <ul>
                                    <?php
                                    if (isset($_SESSION['user_id'])) {
                                        $show_playlist_of_user = $frontend->show_playlist_of_user($_SESSION['user_id']);
                                        if ($show_playlist_of_user) {
                                            while ($resultPlaylist = $show_playlist_of_user->fetch_assoc()) {
                                                ?>
                                                <li data-id="<?php echo $resultPlaylist['playlist_id']; ?>" class="add-to-playlist">
                                                    <?php echo $resultPlaylist['playlist_name']; ?>
                                                </li>
                                                <?php
                                            }
                                        } else {
                                            echo '<li></li>';
                                        }
                                    } else {
                                        echo '<li>Bạn cần <a href="login.php">đăng nhập</a> trước</li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                            <!-- lyrics -->
                            <div class="song-lyrics" hidden>
                                <?php echo $resultSongNew['lyrics'] ?>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<div>Không có thông tin</div>';
                }
                ?>
            </div>
            <!-- new album -->
            <h3>Album mới ra</h3>
            <div class="album-container">
                <!-- album item -->
                <?php
                if ($show_album_new) {
                    while ($resultAlbumNew = $show_album_new->fetch_assoc()) {
                        ?>
                        <div class="album-box" data-id="<?php echo $resultAlbumNew['album_id'] ?>">
                            <div class="boxtest">
                                <div class="album-cover">
                                    <img src="./admin/upload/images/imagesong/<?php echo $resultAlbumNew['album_image'] ?>"
                                        alt="">
                                </div>
                                <div class="boxtestMenu">
                                    <button class="boxtestMenuBtn btnAlbumPlaylist"><i
                                            class="fa-regular fa-circle-play"></i></button>
                                </div>
                            </div>
                            <div class="album-name"><?php echo $resultAlbumNew['album_name'] ?></div>
                            <div class="album-user"><a href=""><?php echo $resultAlbumNew['authorAlbum'] ?></a></div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <!-- new playlist -->
            <h3>Playlist mới ra</h3>
            <div class="playlist-container">
                <!-- playlist item -->
                <?php
                if ($show_playlist_new) {
                    while ($resultPlaylistNew = $show_playlist_new->fetch_assoc()) {
                        ?>
                        <div class="playlist-box" data-id="<?php echo $resultPlaylistNew['playlist_id'] ?>">
                            <div class="boxtest">
                                <div class="playlist-cover">
                                    <?php
                                    $show_image_playlist = $frontend->show_image_playlist($resultPlaylistNew['playlist_id']);
                                    if ($show_image_playlist) {
                                        while ($resultImagePlaylist = $show_image_playlist->fetch_assoc()) {
                                            ?>
                                            <img src="./admin/upload//images/imagesong/<?php echo $resultImagePlaylist['songImage'] ?>"
                                                alt="">
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="boxtestMenu">
                                    <button class="boxtestMenuBtn btnAlbumPlaylist"><i
                                            class="fa-regular fa-circle-play"></i></button>
                                </div>
                            </div>
                            <div class="playlist-name"><?php echo $resultPlaylistNew['playlist_name'] ?></div>
                            <div class="playlist-user"><a href=""><?php echo $resultPlaylistNew['authorPlaylist'] ?></a></div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>

</div>
<?php
include('./inc/footer.php');
?>
</div>
<script src="js/songfavorite.js"></script>
<script src="js/banner.js"></script>
<script src="js/handleplaysong.js"></script>
<script src="js/callsong.js"></script>
<script src="js/sidebar.js"></script>
<script src="js/rightmenu.js"></script>
<script src="js/funcFullScreen.js"></script>
</body>

</html>