<?php
include('./inc/header.php');

$keysearch = $_GET['keysearch'];

$show_song_by_keysearch = $frontend->show_song_by_search($keysearch);
$show_album_by_keysearch = $frontend->show_album_by_search($keysearch);
$show_playlist_by_keysearch = $frontend->show_playlist_by_search($keysearch);
$show_user_by_keysearch = $frontend->show_user_by_search($keysearch);

?>
<title>Tìm kiếm <?php echo $keysearch ?></title>
<link rel="stylesheet" href="./css/main.css">
<link rel="stylesheet" href="./css/home.css">
<link rel="stylesheet" href="./css/search.css">
<style>
    html {
        height: 100%;
    }

    .title_search {
        color: white;
        text-align: center;
    }

    .new-release-container {
        width: 80%;
        margin: 40px auto;
        padding-bottom: 40px;
    }

    .new-release-tab {
        width: 100%;
        display: flex;
        margin-top: 20px;
    }

    .new-release-tab button.active {
        background-color: rgb(59, 104, 239);
        border: none;
    }

    .new-release-tab button {
        background-color: transparent;
        border: 1px solid rgb(46, 64, 88);
        border-radius: 20px;
        outline: none;
        cursor: pointer;
        padding: 5px 15px;
        color: white;
        width: 100px;
        margin-right: 10px;
        font-size: 12px;
    }

    .tab-content {
        display: none;
        margin-top: 15px;
        border: 1px solid white;
        width: 100%;
    }

    .song-container {
        padding: 10px !important;
    }

    .fl-ctn {
        padding: 15px;
    }

    @media (max-width: 1240px) {
        .follower-container {
            width: 295px;
            margin: 0 10px 10px;
        }
    }

    .recommend-song {
        width: 315px;
    }
</style>
<div class="mainBox">
    <h2 class="title_search">Tìm kiếm từ khóa "<?php echo $keysearch ?>"</h2>

    <div class="new-release-container">
        <!-- tab navigation -->
        <div class="new-release-tab">
            <button class="tab-link active" onclick="openTab(event, 'tab1')">BÀI HÁT</button>
            <button class="tab-link" onclick="openTab(event, 'tab2')">ALBUM</button>
            <button class="tab-link" onclick="openTab(event, 'tab3')">PLAYLIST</button>
            <button class="tab-link" onclick="openTab(event, 'tab4')">TÁC GIẢ</button>
        </div>

        <!-- tab content -->
        <!-- song -->
        <div class="tab-content" id="tab1">
            <div class="song-container">
                <?php
                if ($show_song_by_keysearch) {
                    while ($resultSong = $show_song_by_keysearch->fetch_assoc()) {
                        ?>
                        <!-- song item -->
                        <div class="recommend-song" data-id="<?php echo $resultSong['song_id'] ?>">
                            <audio hidden>
                                <source src="admin/upload/song/<?php echo $resultSong['file_path'] ?>" type="audio/mp3">
                            </audio>
                            <div class="recommend-cover">
                                <img src="./admin/upload/images/imagesong/<?php echo $resultSong['song_image'] ?>" alt="">
                                <div class="cover-overlay">
                                    <button class="btn-play"><i class="fa-solid fa-play"></i></button>
                                </div>
                            </div>
                            <div class="recommend-name">
                                <div class="song-name"><?php echo $format->textShorten($resultSong['song_name'], 25) ?></div>
                                <div class="author-name"><a
                                        href="otheruser.php?user_id=<?php echo $resultSong['user_id'] ?>"><?php echo $resultSong['authorSong'] ?></a>
                                </div>
                            </div>
                            <button class="boxtestMenuBtn btn-heart"><i class="fa-regular fa-heart"></i></button>
                            <!-- submenu -->
                            <div class="add-playlist">
                                <p>Thêm vào playlist:</p>
                                <ul>
                                    <?php
                                    if ($show_playlist_of_user) {
                                        while ($resultPlaylistUser = $show_playlist_of_user->fetch_assoc()) {
                                            ?>
                                            <li><?php echo $resultPlaylistUser['playlist_name'] ?></li>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <li>Bạn cần đăng nhập trước</li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                            <!-- lyrics -->
                            <div class="song-lyrics" hidden>
                                <?php echo $resultSong['lyrics'] ?>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<div style="color: white">Không có dữ liệu</div>';
                }
                ?>
            </div>
        </div>
        <!-- album -->
        <div class="tab-content" id="tab2">
            <div class="album-container">
                <?php
                if ($show_album_by_keysearch) {
                    while ($resultAlbum = $show_album_by_keysearch->fetch_assoc()) {
                        ?>
                        <div class="album-box" data-id="<?php echo $resultAlbum['album_id'] ?>">
                            <div class="boxtest">
                                <div class="album-cover">
                                    <img src="./admin/upload/images/imagesong/<?php echo $resultAlbum['album_image'] ?>" alt="">
                                </div>
                                <div class="boxtestMenu">
                                    <button class="boxtestMenuBtn btnAbumPlaylist"><i
                                            class="fa-regular fa-circle-play"></i></button>
                                </div>
                            </div>
                            <div class="album-name"><?php echo $resultAlbum['album_name'] ?></div>
                            <div class="album-user"><a
                                    href="otheruser.php?user_id=<?php echo $resultAlbum['user_id'] ?>"><?php echo $resultAlbum['authorAlbum'] ?></a>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<div style="color:white">Không có dữ liệu</div>';
                }
                ?>
            </div>
        </div>
        <!-- playlist -->
        <div class="tab-content" id="tab3">
            <div class="playlist-container">
                <!-- playlist item -->
                <?php
                if ($show_playlist_by_keysearch) {
                    while ($resultPlaylist = $show_playlist_by_keysearch->fetch_assoc()) {
                        ?>
                        <div class="playlist-box" data-id="<?php echo $resultPlaylist['playlist_id'] ?>">
                            <div class="boxtest">
                                <div class="playlist-cover">
                                    <?php
                                    $show_image_playlist = $frontend->show_image_playlist($resultPlaylist['playlist_id']);
                                    if ($show_image_playlist) {
                                        while ($resultImagePlaylist = $show_image_playlist->fetch_assoc()) {
                                            ?>
                                            <img src="./admin/upload/images/imagesong/<?php echo $resultImagePlaylist['songImage'] ?>"
                                                alt="">
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="boxtestMenu">
                                    <button class="boxtestMenuBtn btnAbumPlaylist"><i
                                            class="fa-regular fa-circle-play"></i></button>
                                </div>
                            </div>
                            <div class="playlist-name"><?php echo $resultPlaylist['playlist_name'] ?></div>
                            <div class="playlist-user"><a
                                    href="otheruser.php?user_id=<?php echo $resultPlaylist['user_id'] ?>"><?php echo $resultPlaylist['authorPlaylist'] ?></a>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<div style="color:white">Không có dữ liệu</div>';
                }
                ?>
            </div>
        </div>
        <!-- user -->
        <div class="tab-content" id="tab4">
            <div class="fl-ctn">
                <!-- song item -->
                <?php
                if ($show_user_by_keysearch) {
                    while ($resultUser = $show_user_by_keysearch->fetch_assoc()) {
                        ?>
                        <a href="otheruser.php?user_id=<?php echo $resultUser['user_id'] ?>" class="follower-container">
                            <div class="follower-image">
                                <?php
                                if (!empty($resultUser['userimage'])) {
                                    echo '<img src="./admin/upload/images/imageuser/' . $resultUser['userimage'] . '" alt="User Image">';
                                } else {
                                    echo '<img src="./asset/img/user-default.png" alt="User Image">';
                                }
                                ?>
                            </div>
                            <div class="follower-name-container">
                                <div class="follower-name"><?php echo $resultUser['fullName'] ?></div>
                                <div class="count-follower">
                                    <?php echo $format->number($resultUser['followers_count']) . ' người theo dõi' ?>
                                </div>
                            </div>
                        </a>
                        <?php
                    }
                } else {
                    echo '<div style="color:white">Không có dữ liệu</div>';
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
<script src="js/tabcontent.js"></script>
<script src="js/handleplaysong.js"></script>
<script src="js/callsong.js"></script>
<script src="js/sidebar.js"></script>
<script src="js/rightmenu.js"></script>
<script src="js/funcFullScreen.js"></script>
</body>

</html>