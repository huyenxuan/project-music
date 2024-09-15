<?php
include("./inc/header.php");

$show_banner = $frontend->show_banner();
$show_song_hot = $frontend->show_song_hot();
$show_album_hot = $frontend->show_album_hot();
$show_playlist_hot = $frontend->show_playlist_hot();
$show_song_new = $frontend->show_song_new();
$show_album_new = $frontend->show_album_new();
$show_playlist_new = $frontend->show_playlist_new();
$show_random_song = $frontend->show_random_songs();
$show_user = $frontend->show_user();
?>

<title>HHMusic</title>
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
  <!-- banner -->
  <div class="banner">
    <div class="slider">
      <div class="list-banner">
        <!-- item banner -->
        <?php
        if ($show_banner) {
          $bannerCount = 0;
          while ($resultBanner = $show_banner->fetch_assoc()) {
            $bannerCount++;
            ?>
            <div class="item-banner">
              <a href="<?php echo $resultBanner['pathway'] ?>"><img
                  src="./admin/upload/banner/<?php echo $resultBanner['banner_image'] ?>" alt=""
                  title="<?php echo $resultBanner['banner_name'] ?>"></a>
            </div>
            <?php
          }
        }
        ?>
      </div>
      <!-- dot banner -->
      <div class="dots-banner">
        <?php
        if ($show_banner) {
          for ($i = 0; $i < $bannerCount; $i++) {
            ?>
            <li></li>
            <?php
          }
        }
        ?>
      </div>
    </div>
  </div>

  <!-- hot -->
  <div class="home-recommend">
    <div class="home-recommend-title">
      <h1>Đề Xuất</h1>
    </div>
    <div class="home-recommend-container">
      <!-- hot song -->
      <h3>Bài hát nổi bật</h3>
      <div class="song-container">
        <?php
        if ($show_song_hot) {
          while ($resultSongHot = $show_song_hot->fetch_assoc()) {
            $isFavorite = isset($_SESSION['user_id']) ? $frontend->check_song_in_favorite($_SESSION['user_id'], $resultSongHot['song_id']) : false;
            ?>
            <!-- song item -->
            <div class="recommend-song" data-id="<?php echo $resultSongHot['song_id'] ?>">
              <audio hidden>
                <source src="admin/upload/song/<?php echo $resultSongHot['file_path'] ?>" type="audio/mp3">
              </audio>
              <div class="recommend-cover">
                <img src="./admin/upload/images/imagesong/<?php echo $resultSongHot['song_image'] ?>" alt="">
                <div class="cover-overlay">
                  <button class="btn-play"><i class="fa-solid fa-play"></i></button>
                </div>
              </div>
              <div class="recommend-name">
                <div class="song-name"><?php echo $format->textShorten($resultSongHot['song_name'], 25) ?></div>
                <div class="author-name"><a
                    href="otheruser.php?user_id=<?php echo $resultSongHot['user_id'] ?>"><?php echo $resultSongHot['authorSong'] ?></a>
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
                <?php echo $resultSongHot['lyrics'] ?>
              </div>
            </div>
            <?php
          }
        }
        ?>
      </div>
      <!-- hot album -->
      <h3>Album nổi bật</h3>
      <div class="album-container">
        <?php
        if ($show_album_hot) {
          while ($resultAlbumHot = $show_album_hot->fetch_assoc()) {
            ?>
            <div class="album-box" data-id="<?php echo $resultAlbumHot['album_id'] ?>">
              <div class="boxtest">
                <div class="album-cover">
                  <img src="./admin/upload/images/imagesong/<?php echo $resultAlbumHot['album_image'] ?>" alt="">
                </div>
                <div class="boxtestMenu">
                  <button class="boxtestMenuBtn btnAlbumPlaylist"><i class="fa-regular fa-circle-play"></i></button>
                </div>
              </div>
              <div class="album-name"><?php echo $resultAlbumHot['album_name'] ?></div>
              <div class="album-user"><a
                  href="otheruser.php?user_id=<?php echo $resultAlbumHot['user_id'] ?>"><?php echo $resultAlbumHot['authorAlbum'] ?></a>
              </div>
            </div>
            <?php
          }
        }
        ?>
      </div>
      <!-- hot playlist -->
      <h3>Playlist nổi bật</h3>
      <div class="playlist-container">
        <!-- playlist item -->
        <?php
        if ($show_playlist_hot) {
          while ($resultPlaylistHot = $show_playlist_hot->fetch_assoc()) {
            ?>
            <div class="playlist-box" data-id="<?php echo $resultPlaylistHot['playlist_id'] ?>">
              <div class="boxtest">
                <div class="playlist-cover">
                  <?php
                  $show_image_playlist = $frontend->show_image_playlist($resultPlaylistHot['playlist_id']);
                  if ($show_image_playlist) {
                    while ($resultImagePlaylist = $show_image_playlist->fetch_assoc()) {
                      ?>
                      <img src="./admin/upload/images/imagesong/<?php echo $resultImagePlaylist['songImage'] ?>" alt="">
                      <?php
                    }
                  }
                  ?>
                </div>
                <div class="boxtestMenu">
                  <button class="boxtestMenuBtn btnAlbumPlaylist"><i class="fa-regular fa-circle-play"></i></button>
                </div>
              </div>
              <div class="playlist-name"><?php echo $resultPlaylistHot['playlist_name'] ?></div>
              <div class="playlist-user"><a
                  href="otheruser.php?user_id=<?php echo $resultPlaylistHot['user_id'] ?>"><?php echo $resultPlaylistHot['authorPlaylist'] ?></a>
              </div>
            </div>
            <?php
          }
        }
        ?>
      </div>
    </div>
  </div>

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
                  <img src="./admin/upload/images/imagesong/<?php echo $resultAlbumNew['album_image'] ?>" alt="">
                </div>
                <div class="boxtestMenu">
                  <button class="boxtestMenuBtn btnAlbumPlaylist"><i class="fa-regular fa-circle-play"></i></button>
                </div>
              </div>
              <div class="album-name"><?php echo $resultAlbumNew['album_name'] ?></div>
              <div class="album-user"><a
                  href="otheruser.php?user_id=<?php echo $resultAlbumNew['user_id'] ?>"><?php echo $resultAlbumNew['authorAlbum'] ?></a>
              </div>
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
                      <img src="./admin/upload//images/imagesong/<?php echo $resultImagePlaylist['songImage'] ?>" alt="">
                      <?php
                    }
                  }
                  ?>
                </div>
                <div class="boxtestMenu">
                  <button class="boxtestMenuBtn btnAlbumPlaylist"><i class="fa-regular fa-circle-play"></i></button>
                </div>
              </div>
              <div class="playlist-name"><?php echo $resultPlaylistNew['playlist_name'] ?></div>
              <div class="playlist-user"><a
                  href="otheruser.php?user_id=<?php echo $resultPlaylistNew['user_id'] ?>"><?php echo $resultPlaylistNew['authorPlaylist'] ?></a>
              </div>
            </div>
            <?php
          }
        }
        ?>
      </div>
    </div>
  </div>

  <!-- may like -->
  <div class="home-recommend">
    <div class="home-recommend-title">
      <h1>Có thể bạn thích</h1>
    </div>
    <div class="home-recommend-container">
      <!-- maylike song -->
      <div class="song-container">
        <?php
        if ($show_random_song) {
          while ($resultSongRandom = $show_random_song->fetch_assoc()) {
            $isFavorite = isset($_SESSION['user_id']) ? $frontend->check_song_in_favorite($_SESSION['user_id'], $resultSongRandom['song_id']) : false;
            ?>
            <!-- song item -->
            <div class="recommend-song" data-id="<?php echo $resultSongRandom['song_id'] ?>">
              <audio hidden>
                <source src="admin/upload/song/<?php echo $resultSongRandom['file_path'] ?>" type="audio/mp3">
              </audio>
              <div class="recommend-cover">
                <img src="./admin/upload/images/imagesong/<?php echo $resultSongRandom['song_image'] ?>" alt="">
                <div class="cover-overlay">
                  <button class="btn-play"><i class="fa-solid fa-play"></i></button>
                </div>
              </div>
              <div class="recommend-name">
                <div class="song-name"><?php echo $format->textShorten($resultSongRandom['song_name'], 25) ?></div>
                <div class="author-name"><a
                    href="otheruser.php?user_id=<?php echo $resultSongRandom['user_id'] ?>"><?php echo $resultSongRandom['authorSong'] ?></a>
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
                <?php echo $resultSongRandom['lyrics'] ?>
              </div>
            </div>
            <?php
          }
        }
        ?>
      </div>
    </div>
  </div>

  <!-- users -->
  <div class="other-user home-recommend">
    <div class="home-recommend-title">
      <h1>Bạn có thể quen</h1>
    </div>
    <div class="home-recommend-container">
      <!-- maylike song -->
      <div class="fl-ctn">
        <!-- song item -->
        <?php
        if ($show_user) {
          while ($resultUser = $show_user->fetch_assoc()) {
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
<script>
  const btnPlayss = document.querySelectorAll('.btn-play');
  btnPlayss.forEach(btnPlay => {
    btnPlay.addEventListener('click', () => {
      const songItem = btnPlay.closest('.recommend-song');
      if (!songItem) {
        console.log('Không tìm thấy songItem');
        return;
      }
      const dataId = songItem.getAttribute('data-id');
      console.log(dataId);

      function updateListenCount(songId) {
        return fetch(`update_listen_count.php?song_id=${songId}`)
          .then(response => {
            if (!response.ok) {
              throw new Error(`Lỗi: ${response.status}`);
            }
            return response.json();
          })
          .then(data => {
            if (data.success) {
              console.log('Lượt nghe đã được cập nhật');
            } else {
              console.log('Cập nhật lượt nghe không thành công');
            }
          })
          .catch(error => {
            console.error('Lỗi:', error);
          });
      }
      updateListenCount(dataId);
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

</body>

</html>