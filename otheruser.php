<?php
session_start();
include('./class/frontendClass.php');
include('./config/format.php');

$frontend = new FrontEnd();
$format = new Format();

$user_id = $_GET['user_id'];
$show_song_of_user = $frontend->show_song_of_user($user_id);
$show_album_of_user = $frontend->show_album_of_user($user_id);
$show_playlist_of_user = $frontend->show_playlist_of_user($user_id);
$get_user = $frontend->get_user($user_id);
if ($get_user) {
    $resultUser = $get_user->fetch_assoc();
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Cá Nhân Của <?php echo $resultUser['fullName']; ?></title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/user.css">
    <link rel="stylesheet" href="./css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="shortcut icon" href="./asset/img/logo.png">
</head>
<style>
    .profile-name {
        font-size: 20px;
    }
</style>

<body>
    <div class="mainBody">
        <div class="title"></div>
        <div class="mainBox profile">
            <div class="profile-background-container">
                <div class="profile-background">
                    <img src="./asset/img/profile_background.png" alt="">
                </div>
                <div class="profile-inform">
                    <div class="profile-name"><?php echo $resultUser['fullName'] ?>
                        <button id="btnFollow">
                            <i class="fa-solid <?php echo $isFollowing ? 'fa-check' : 'fa-plus'; ?>"></i>
                            <?php if (isset(($_SESSION['user_id']))) {
                                $isFollowing = $frontend->check_follow($_GET['user_id'], $_SESSION['user_id']);
                                echo $isFollowing ? ' Đã theo dõi' : ' Theo dõi';
                            } else {
                                echo ' Theo dõi';
                            } ?>
                        </button>
                    </div>
                    <p><?php echo $resultUser['followers_count'] ?> người theo dõi</p>
                </div>
                <div class="backhome-btn">
                    <button onclick="backHome()"><i class="fa-solid fa-house"></i> Về trang chủ</button>
                </div>
            </div>

            <div class="profile-avatar">
                <<?php
                if (!empty($resultUser['userimage'])) {
                    echo '<img src="./admin/upload/images/imageuser/' . $resultUser['userimage'] . '" alt="User Image">';
                } else {
                    echo '<img src="./asset/img/user-default.png" alt="User Image">';
                }
                ?>
            </div>

            <div class="profile-content" style="display: block;">
                <div class="lib-tab-content" style="display: block; width: 100%; height: 90vh;" id="lib-tab-1">
                    <div>
                        <h2 style="text-align: center;">Thư viện của <?php echo $resultUser['fullName'] ?></h2>
                    </div>
                    <!-- tab navigation -->
                    <div class="new-release-tab" style="width: 50%; display: flex;">
                        <button class="tab-link active" onclick="openTab(event, 'tab1')">BÀI HÁT</button>
                        <button class="tab-link" onclick="openTab(event, 'tab2')">ALBUM</button>
                        <button class="tab-link" onclick="openTab(event, 'tab3')">PLAYLIST</button>
                    </div>

                    <!-- tab content -->
                    <!-- song -->
                    <div class="tab-content" id="tab1">
                        <div class="tab-flex">
                            <div class="song-container">
                                <!-- song item -->
                                <?php
                                if ($show_song_of_user) {
                                    while ($resultSong = $show_song_of_user->fetch_assoc()) {
                                        $isFavorite = isset($_SESSION['user_id']) ? $frontend->check_song_in_favorite($_SESSION['user_id'], $resultSong['song_id']) : false;
                                        ?>
                                        <!-- song item -->
                                        <div class="recommend-song" data-id="<?php echo $resultSong['song_id'] ?>">
                                            <audio hidden>
                                                <source src="admin/upload/song/<?php echo $resultSong['file_path'] ?>"
                                                    type="audio/mp3">
                                            </audio>
                                            <div class="recommend-cover">
                                                <img src="./admin/upload/images/imagesong/<?php echo $resultSong['song_image'] ?>"
                                                    alt="">
                                                <div class="cover-overlay">
                                                    <button class="btn-play"><i class="fa-solid fa-play"></i></button>
                                                </div>
                                            </div>
                                            <div class="recommend-name">
                                                <div class="song-name">
                                                    <?php echo $format->textShorten($resultSong['song_name'], 25) ?>
                                                </div>
                                                <div class="author-name"><a
                                                        href="otheruser.php?user_id=<?php echo $resultSong['user_id'] ?>"><?php echo $resultSong['authorSong'] ?></a>
                                                </div>
                                            </div>
                                            <button class="boxtestMenuBtn btn-heart">
                                                <i
                                                    class="<?php echo $isFavorite ? 'fa-solid fa-heart' : 'fa-regular fa-heart' ?>"></i>
                                            </button>
                                            <button class="boxtestMenuBtn btn_menu"><i
                                                    class="fa-solid fa-ellipsis"></i></button>
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
                                                                <li data-id="<?php echo $resultPlaylist['playlist_id']; ?>"
                                                                    class="add-to-playlist">
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

                    <!-- album -->
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
                                    echo '<div style="text-align: center">Không có dữ liệu</div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- playlist -->
                    <div class="tab-content" id="tab3">
                        <div class="tab-flex">
                            <div class="playlist-container">
                                <!-- playlist item -->
                                <?php
                                if ($show_playlist_of_user) {
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
                                                    href="otheruser.php?user_id=<?php echo $resultPlaylist['user_id'] ?>">Đen
                                                    Vâu</a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    echo '<div>Không có dữ liệu</div>';
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include('./inc/footer.php');
    ?>
    <script>
        // const btnPLs = document.querySelectorAll('.recommend-song .btn-pl');
        const playerControl = document.querySelector('.player-control');
        const audio = document.getElementById('myAudio');
        const audioSrc = audio.querySelector('source');
        const playPauseButtons = document.querySelectorAll('.toggle-playPause');
        const playerControlImg = document.querySelector('.player-control img');

        const songNameControl = playerControl.querySelector('.song-name');
        const authorControl = playerControl.querySelector('.artists');
        const songImgFullScreen = document.querySelector('.fullscreen img');
        const songNameFullScreen = document.querySelector('.fullscreen .name-song');
        const songArtistsFullScreen = document.querySelector('.fullscreen .artists');

        // xử lý nút khởi chạy bài hát
        btnPLs.forEach(btnPlay => {
            btnPlay.addEventListener('click', () => {
                playerControl.style.bottom = '0';
                const songItem = btnPlay.closest('.recommend-song');
                if (!songItem) {
                    console.log('Không tìm thấy songItem');
                    return;
                }
                const dataId = <?php echo $user_id ?>;
                console.log(dataId);
                function fetchRelatedSongs(dataId) {
                    return fetch(`get_related_songs.php?user_id=${dataId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`Lỗi lấy bài hát: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            const sidebarContainer = document.querySelector('.sidebar-container');
                            sidebarContainer.innerHTML = '';
                            data.forEach(song => {
                                const songItem = `
                                <div class="recommend-song sidebar-song" data-id="${song.song_id}">
                                    <audio hidden>
                                      <source src="admin/upload/song/${song.filePath}">
                                    </audio>
                                    <div class="recommend-cover">
                                      <img src="admin/upload/images/imagesong/${song.song_image}" alt="${song.song_name}">
                                      <div class="cover-overlay">
                                        <button class="btn-play"><i class="fa-solid fa-play"></i></button>
                                      </div>
                                    </div>
                                    <div class="recommend-name">
                                      <div class="song-name">${song.song_name}</div>
                                      <div class="author-name"><a href="">${song.author_name}</a></div>
                                    </div>
                                    <button class="boxtestMenuBtn btn-heart"><i class="${song.is_favorited ? 'fa-solid fa-heart' : 'fa-regular fa-heart'}"></i></button>
                                    <!-- submenu -->
                                    <div class="add-playlist">
                                      <p>Thêm vào playlist:</p>
                                      <ul>
                                        <li>Playlist 1</li>
                                        <li>Playlist 2</li>
                                        <li>Playlist 3</li>
                                      </ul>
                                    </div>
                                </div>`;
                                sidebarContainer.insertAdjacentHTML('beforeend', songItem);
                            });
                            loadSidebarSongs();
                        })
                        .catch(error => {
                            console.error('Lỗi lấy bài hát:', error);
                        });
                }
                fetchRelatedSongs(dataId)
                    .then(() => {
                        const firstSongInSidebar = document.querySelector('.sidebar-container .recommend-song:first-child');
                        if (firstSongInSidebar) {
                            firstSongInSidebar.classList.add('playing');
                            const firstSongSrc = firstSongInSidebar.querySelector('audio source').getAttribute('src');
                            const firstSongImg = firstSongInSidebar.querySelector('img').getAttribute('src');
                            const firstSongName = firstSongInSidebar.querySelector('.song-name').textContent;
                            const firstSongAuthor = firstSongInSidebar.querySelector('.author-name').textContent;

                            audioSrc.setAttribute('src', firstSongSrc);
                            audio.load();
                            audio.play();

                            playerControlImg.setAttribute('src', firstSongImg);
                            songImgFullScreen.setAttribute('src', firstSongImg);
                            songNameControl.innerText = firstSongName;
                            songNameFullScreen.innerText = firstSongName;
                            authorControl.innerText = firstSongAuthor;
                            songArtistsFullScreen.innerText = firstSongAuthor;

                            isPlaying = true;
                            playPauseButtons.forEach(button => {
                                button.classList.remove('fa-play');
                                button.classList.add('fa-pause');
                            });
                        }
                    });
            })
        });
        // Load songs
        function loadSidebarSongs() {
            sidebarSongs = [...document.querySelectorAll('.sidebar .recommend-song')];
            console.log(sidebarSongs);
        }
    </script>
    <script>
        $(document).on('click', '#btnFollow', function () {
            var user_id = <?php echo $resultUser['user_id']; ?>;
            var followButton = $(this);
            var followIcon = followButton.find('i');

            $.ajax({
                url: 'toggle_follow.php',
                type: 'POST',
                data: {
                    user_id: user_id
                },
                success: function (response) {
                    if (response.trim() === 'followed') {
                        followIcon.removeClass('fa-plus').addClass('fa-check');
                        followButton.text(' Đã theo dõi');
                        followButton.addClass('active');
                        alert('Đã theo dõi người dùng này');
                    } else if (response.trim() === 'unfollowed') {
                        followIcon.removeClass('fa-check').addClass('fa-plus');
                        followButton.text(' Theo dõi');
                        followButton.removeClass('active');
                        alert('Đã hủy theo dõi người dùng này');
                    } else {
                        alert('Có lỗi xảy ra: ' + response);
                    }
                },
                error: function (xhr, status, error) {
                    alert('Đã có lỗi xảy ra: ' + error);
                }
            });
        });
    </script>
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