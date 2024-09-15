<?php
include('./inc/header.php');

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $show_song_allsong_user = $frontend->show_song_allsong_user($user_id);
    $show_playlist_of_user = $frontend->show_playlist_of_user($user_id);
    $show_album_of_user = $frontend->show_album_of_user($user_id);
}
$show_category = $frontend->show_category();
// erro song
$erroSongName = '';
$erroCategory = '';
$erroSongImg = '';
$erroFilePath = '';

// erro album
$erroAlbumName = '';
$erroAlbumImg = '';

//erro playlist
$erroPlaylistName = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addSong'])) {
        $song_name = $_POST['song_name'];
        $category_id = $_POST['category_id'];
        $lyrics = $_POST['lyrics'];
        $authorSong_id = $user_id;
        $privacy = isset($_POST['privacy']) ? 'private' : 'public';
        $song_image = $_FILES['song_image']['name'];
        $file_path = $_FILES['file_path']['name'];

        if (empty($song_name)) {
            $erroSongName = "Vui lòng nhập trường này";
        } else if (preg_match('/^[^a-zA-Z]/', $song_name)) {
            $erroSongName = "Tên bài hát phải bắt đầu bằng chữ";
        }
        if (empty($category_id)) {
            $erroCategory = "Vui lòng nhập trường này";
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
            move_uploaded_file($_FILES['song_image']['tmp_name'], "./admin/upload/images/imagesong/" . $song_image);
            move_uploaded_file($_FILES['file_path']['tmp_name'], "./admin/upload/song/" . $file_path);

            if ($frontend->insert_song($song_name, $authorSong_id, $category_id, $lyrics, $privacy, $song_image, $file_path)) {
                ?>
                <script>
                    alert('Thêm thành công');
                </script>
                <?php
            } else {
                ?>
                <script>
                    alert('Thêm thất bại');
                </script>
                <?php
            }
            // header('location: library.php');
            // exit();
        }
    } elseif (isset($_POST['addAlbum'])) {
        $album_name = $_POST['album_name'];
        $authorAlbum_id = $user_id;
        $album_image = $_FILES['album_image']['name'];
        $description = '';
        $privacy = isset($_POST['privacy']) ? 'private' : 'public';

        if (empty($album_name)) {
            $erroAlbumName = "Vui lòng nhập trường này";
        } else if (preg_match('/^[^a-zA-Z]/', $albumname)) {
            $erroAlbumName = "Tên bài hát phải bắt đầu bằng chữ";
        }
        if (empty($album_image)) {
            $erroAlbumImg = "Vui lòng nhập trường này";
        } else {
            $album_image_temp = $_FILES['album_image']['tmp_name'];
            $album_image_type = mime_content_type($album_image_temp);
            if (!in_array($album_image_type, ['image/jpeg', 'image/png', 'image/gif'])) {
                $erroSongImg = "Chọn file có định dạng file ảnh";
            }
        }
        if (empty($erroAlbumName) && empty($erroAlbumImg)) {
            move_uploaded_file($_FILES['album_image']['tmp_name'], "./admin/upload/images/imagesong/" . $album_image);

            if ($frontend->insert_album($album_name, $authorAlbum_id, $album_image, $description, $privacy)) {
                ?>
                <script>
                    alert('Thêm thành công');
                </script>
                <?php
            }
            header('location: library.php');
            exit();
        }
    } elseif (isset($_POST['addPlaylist'])) {
        $playlist_name = $_POST['playlist_name'];
        $authorPlaylist_id = $user_id;
        $privacy = isset($_POST['privacy']) ? 'private' : 'public';

        if (empty($playlist_name)) {
            $erroPlaylistName = "Vui lòng nhập trường này";
        } else if (preg_match('/^[^a-zA-Z]/', $playlist_name)) {
            $erroPlaylistName = "Tên bài hát phải bắt đầu bằng chữ";
        }

        if (empty($erroPlaylistName)) {
            if ($frontend->insert_playList($playlist_name, $user_id)) {
                ?>
                <script>
                    alert('Thêm thành công');
                </script>
                <?php
            }
            // header('location: library.php');
            // exit();
        }
    } elseif (isset($_POST['deleteAlbum'])) {
        $albumId = $_POST['album_id'];
        $frontend->delete_album($albumId);
        header('location: library.php');
        exit();
    } elseif (isset($_POST['deletePlaylist'])) {
        $playlistId = $_POST['playlist_id'];
        $frontend->delete_playlist($playlistId);
        header('location: library.php');
        exit();
    } elseif (isset($_POST['deleteSong'])) {
        $songId = $_POST['song_id'];
        $frontend->delete_song($songId);
        header('location: library.php');
        exit();
    }
}

?>
<title>Thư Viện</title>
<link rel="stylesheet" href="./css/main.css">
<link rel="stylesheet" href="./css/user.css">
<link rel="stylesheet" href="./css/home.css">
<style>
    .tab-flex {
        padding: 0 !important;
    }

    .tab-content {
        width: 100% !important;
    }

    form {
        width: 500px;
    }

    form p {
        color: white;
        font-size: 19px;
        margin-top: 25px
    }

    .addSong input,
    .addSong select,
    .addSong textarea,
    .addAlbum input,
    .addPlaylist input {
        width: 300px;
        height: 35px;
        padding: 5px 7px;
        outline: none;
        margin-left: 15px;
        font-size: 16px;
        margin-right: 20px;
    }

    .addSong textarea {
        height: 100px;
        width: 635px;
    }

    .addSong button,
    .addAlbum button,
    .addPlaylist button {
        margin-top: 15px;
        padding: 9px 13px;
        border-radius: 9px;
        margin-left: 250px;
        margin-top: 50px;
    }

    .boxtestMenu button {
        width: 40px;
        height: 40px;
        padding-top: 2px;
        border-radius: 100%;
        font-size: 25px;
        background-color: transparent;
        border: none;
        color: white;
        cursor: pointer;
    }

    .boxtestMenu button:hover {
        background-color: rgba(255, 255, 255, 0.3);
    }
</style>
<div class="title lib-title">THƯ VIỆN CÁ NHÂN</div>
<?php
if (!isset($_SESSION['user_id'])) {
    echo '<div style="color: white; text-align: center; margin-top: 150px; font-size: 22px;">Vui lòng <a href="login.php" style="color:red">đăng nhập</a> trước</div>';
} else {
    ?>
    <div class="mainBox libMain">
        <div class="lib-side-bar">
            <button class="lib-tab-btn active" onclick="libTab(event, 'lib-tab-1')">Thư viện cá nhân</button>
            <button class="lib-tab-btn" onclick="libTab(event, 'lib-tab-2')">Quản lý bài hát</button>
            <button class="lib-tab-btn" onclick="libTab(event, 'lib-tab-3')">Quản lý Album</button>
            <button class="lib-tab-btn" onclick="libTab(event, 'lib-tab-4')">Quản lý Playlist</button>
        </div>
        <!-- thư viện cá nhân -->
        <div class="lib-tab-content" style="display: block;" id="lib-tab-1">
            <!-- tab navigation -->
            <div class="new-release-tab" style="width: 50%; display: flex;">
                <button class="tab-link" onclick="openTab(event, 'tab1')">BÀI HÁT</button>
                <button class="tab-link" onclick="openTab(event, 'tab2')">ALBUM</button>
                <button class="tab-link" onclick="openTab(event, 'tab3')">PLAYLIST</button>
            </div>
            <!-- tab content -->
            <!-- tab song -->
            <div class="tab-content" id="tab1">
                <div class="tab-flex">
                    <div class="song-container">
                        <!-- song item -->
                        <?php
                        if ($show_song_allsong_user) {
                            while ($resultSong = $show_song_allsong_user->fetch_assoc()) {
                                // Kiểm tra xem bài hát có trong yêu thích không
                                $isFavorite = isset($_SESSION['user_id']) ? $frontend->check_song_in_favorite($_SESSION['user_id'], $resultSong['song_id']) : false;
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
                                        <div class="song-name"><?php echo $format->textShorten($resultSong['song_name'], 25) ?>
                                        </div>
                                        <div class="author-name"><a
                                                href="otheruser.php?user_id=<?php echo $resultSong['user_id'] ?>"><?php echo $resultSong['authorSong'] ?></a>
                                        </div>
                                    </div>
                                    <button class="boxtestMenuBtn btn-heart">
                                        <i class="<?php echo $isFavorite ? 'fa-solid fa-heart' : 'fa-regular fa-heart' ?>"></i>
                                    </button>
                                    <button class="boxtestMenuBtn btn_menu"><i class="fa-solid fa-ellipsis"></i></button>
                                    <!-- submenu -->
                                    <div class="add-playlist">
                                        <ul>
                                            <li><a href="songEdit.php?song_id=<?php echo $resultSong['song_id'] ?>">Chỉnh
                                                    sửa</a></li>
                                            <li>
                                                <form method="POST"
                                                    onsubmit="return confirm('Bạn có chắc muốn xóa bài hát này không?');">
                                                    <input type="hidden" name="song_id"
                                                        value="<?php echo $resultSong['song_id']; ?>">
                                                    <button type="submit" name="deleteSong" class="btn-delete"
                                                        style="font-size:18px;opacity:1;border: none;outline: none;background: transparent;color: white;font-size: 21px;cursor: pointer;">Xóa</button>
                                                </form>
                                            </li>
                                        </ul>
                                        <p style="margin-top:0; padding-top:0">Thêm vào playlist:</p>
                                        <ul>
                                            <?php
                                            if ($show_playlist_of_user) {
                                                $show_playlist_of_user->data_seek(0);
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
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- tab album -->
            <div class="tab-content" id="tab2">
                <div class="tab-flex">
                    <div class="album-container">
                        <!-- item -->
                        <?php
                        if ($show_album_of_user) {
                            while ($resultAlbum = $show_album_of_user->fetch_assoc()) {
                                ?>
                                <div class="album-box" data-id="<?php echo $resultAlbum['album_id'] ?>">
                                    <div class="boxtest">
                                        <div class="album-cover">
                                            <img src="./admin/upload/images/imagesong/<?php echo $resultAlbum['album_image'] ?>"
                                                alt="">
                                        </div>
                                        <div class="boxtestMenu">
                                            <button class="boxtestMenuBtn btnAlbumPlaylist">
                                                <i class="fa-regular fa-circle-play"></i>
                                            </button>
                                            <button class="btn-action btn_menu">
                                                <i class="fa-solid fa-ellipsis"></i>
                                            </button>
                                            <!-- Submenu -->
                                            <div class="add-playlist"
                                                style="display: block; right: 0px; padding: 10px; top: 85%; left: 10px; ">
                                                <ul>
                                                    <li><a href="albumEdit.php?album_id=<?php echo $resultAlbum['album_id'] ?>">Chỉnh
                                                            sửa</a></li>
                                                    <li>
                                                        <form method="POST"
                                                            onsubmit="return confirm('Bạn có chắc muốn xóa album này không?');">
                                                            <input type="hidden" name="album_id"
                                                                value="<?php echo $resultAlbum['album_id']; ?>">
                                                            <button type="submit" name="deleteAlbum" class="btn-delete"
                                                                style="font-size:13px">Xóa</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
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
                            echo '<div style="text-align: center">Không có dữ liệu</div>';
                        }
                        ?>
                    </div>
                </div>

            </div>
            <!-- tab playlist -->
            <div class="tab-content" id="tab3">
                <div class="tab-flex">
                    <div class="playlist-container">
                        <!-- playlist item -->
                        <?php
                        if ($show_playlist_of_user) {
                            $show_playlist_of_user->data_seek(0);
                            while ($resultPlaylist = $show_playlist_of_user->fetch_assoc()) {
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
                                            } else {
                                                echo '<div>Không có hình ảnh</div>';
                                            }
                                            ?>
                                        </div>
                                        <div class="boxtestMenu">
                                            <button class="boxtestMenuBtn btnAlbumPlaylist">
                                                <i class="fa-regular fa-circle-play"></i>
                                            </button>
                                            <button class="btn-action btn_menu">
                                                <i class="fa-solid fa-ellipsis"></i>
                                            </button>
                                            <!-- Submenu -->
                                            <div class="add-playlist"
                                                style="display: block; right: 0px; padding: 10px; top: 85%; left: 10px; ">
                                                <ul>
                                                    <li><a
                                                            href="playlistEdit.php?playlist_id=<?php echo $resultPlaylist['playlist_id'] ?>">Chỉnh
                                                            sửa</a></li>
                                                    <li>
                                                        <form method="POST"
                                                            onsubmit="return confirm('Bạn có chắc muốn xóa playlist này không?');">
                                                            <input type="hidden" name="playlist_id"
                                                                value="<?php echo $resultPlaylist['playlist_id']; ?>">
                                                            <button type="submit" name="deletePlaylist" class="btn-delete"
                                                                style="font-size:13px">Xóa</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="playlist-name">
                                        <?php echo $resultPlaylist['playlist_name'] ?>
                                    </div>
                                    <div class="playlist-user">
                                        <a href="otheruser.php?user_id=<?php echo $resultPlaylist['user_id'] ?>">
                                            <?php echo $resultPlaylist['authorPlaylist'] ?>
                                        </a>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        <!-- favorite -->
                        <div class="album-box" data-id="0">
                            <div class="boxtest">
                                <div class="album-cover">
                                    <img src="./asset/img/favoriteImg.jpg" alt="">
                                </div>
                                <div class="boxtestMenu">
                                    <button class="boxtestMenuBtn btnAlbumPlaylist"><i
                                            class="fa-regular fa-circle-play"></i></button>
                                </div>
                            </div>
                            <div class="album-name">Danh sách yêu thích</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- quản lý bài hát -->
        <div class="lib-tab-content" id="lib-tab-2">
            <h2>Thêm Bài Hát</h2>
            <div style="padding-left:150px;">
                <form class="addSong" action="" method="POST" enctype="multipart/form-data">
                    <div style="display: flex; width: 80%; margin: 0;">
                        <div style="margin: 0;">
                            <p>Tên bài hát</p>
                            <input name="song_name" type="text" placeholder="Nhập tên bài hát...">
                            <?php if (!empty($erroSongName)) {
                                echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $erroSongName . "</span>";
                            } ?>
                        </div>
                        <div>
                            <p>Thể loại</p>
                            <select name="category_id" id="">
                                <option value="">--- Chọn Thể Loại ---</option>
                                <?php
                                if ($show_category) {
                                    while ($resultCategory = $show_category->fetch_assoc()) {
                                        ?>
                                        <option value="<?php echo $resultCategory['category_id'] ?>">
                                            <?php echo $resultCategory['category_name'] ?>
                                        </option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <?php if (!empty($erroCategory)) {
                                echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $erroCategory . "</span>";
                            } ?>
                        </div>
                    </div>
                    <div>
                        <p>Lời bài hát</p>
                        <textarea name="lyrics" id="" placeholder="Nhập lời bài hát..." spellcheck="false"></textarea>
                    </div>
                    <div class="privacy" style="display: flex; lign-items: center;">
                        <p>Riêng tư</p>
                        <input type="checkbox" name="privacy" style="width:25px; margin-top:15px">
                    </div>
                    <div style="display:flex">
                        <div>
                            <p>Ảnh đại diện</p>
                            <input name="song_image" type="file" accept=".jpg,.jpeg,.png" name="" id="">
                            <?php if (!empty($erroSongImg)) {
                                echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $erroSongImg . "</span>";
                            } ?>
                        </div>
                        <div>
                            <p>Tải lên bài hát</p>
                            <input name="file_path" type="file" accept=".mp3" name="" id="">
                            <?php if (!empty($erroFilePath)) {
                                echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $erroFilePath . "</span>";
                            } ?>
                        </div>
                    </div>
                    <button name="addSong">Xác nhận</button>
                </form>
            </div>
        </div>
        <!-- quản lý album -->
        <div class="lib-tab-content" id="lib-tab-3">
            <h2>Thêm Album</h2>
            <div style="padding-left:150px;">
                <form class="addAlbum" action="" method="POST" enctype="multipart/form-data">
                    <div style="margin: 0;">
                        <p>Tên album</p>
                        <input name="album_name" type="text" placeholder="Nhập tên album...">
                        <?php if (!empty($erroAlbumName)) {
                            echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $erroAlbumName . "</span>";
                        } ?>
                    </div>
                    <div style="display:flex">
                        <div>
                            <p>Ảnh đại diện</p>
                            <input name="album_image" type="file" accept=".jpg,.jpeg,.png" id=""><br>
                            <?php if (!empty($erroAlbumImg)) {
                                echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $erroAlbumImg . "</span>";
                            } ?>
                        </div>
                    </div>
                    <div class="privacy" style="display: flex; lign-items: center;">
                        <p>Riêng tư</p>
                        <input type="checkbox" name="privacy" style="width:25px; margin-top:15px">
                    </div>
                    <button name="addAlbum">Xác nhận</button>
                </form>
            </div>

        </div>
        <!-- quản lý playlist -->
        <div class="lib-tab-content" id="lib-tab-4">
            <h2>Thêm Playlist</h2>
            <div style="padding-left:150px;">
                <form class="addPlaylist" action="" method="POST" enctype="multipart/form-data">
                    <div style="margin: 0;">
                        <p>Tên playlist</p>
                        <input name="playlist_name" type="text" placeholder="Nhập tên playlist..."><br>
                        <?php if (!empty($erroPlaylistName)) {
                            echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $erroPlaylistName . "</span>";
                        } ?>
                    </div>
                    <div class="privacy" style="display: flex; lign-items: center;">
                        <p>Riêng tư</p>
                        <input type="checkbox" name="privacy" style="width:25px; margin-top:15px">
                    </div>
                    <button name="addPlaylist">Xác nhận</button>
                </form>
            </div>
        </div>
    </div>
    <?php
}
?>

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
<script src="js/tabcontent.js"></script>
</body>

</html>