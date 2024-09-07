<?php
include("./inc/header.php");

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $show_playlist_of_user = $frontend->show_playlist_of_user($user_id);
  $show_maylike = $frontend->show_maylike($user_id);
} else {
  $show_playlist_of_user = 0;
}

$show_banner = $frontend->show_banner();
$show_song_hot = $frontend->show_song_hot();
$show_album_hot = $frontend->show_album_hot();
$show_playlist_hot = $frontend->show_playlist_hot();
$show_song_new = $frontend->show_song_new();
$show_album_new = $frontend->show_album_new();
$show_playlist_new = $frontend->show_playlist_new();
$show_user = $frontend->show_user();
?>

<title>HHMusic</title>
<link rel="stylesheet" href="./css/home.css">
<style>
  .recommend-cover {
    width: 50px;
  }

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
          $bannerCount = 0; // Initialize a counter to track the number of banners
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
                <div class="author-name"><a href=""><?php echo $resultSongHot['authorSong'] ?></a></div>
              </div>
              <button class="boxtestMenuBtn btn-heart"><i class="fa-regular fa-heart"></i></button>
              <button class="boxtestMenuBtn btn_menu"><i class="fa-solid fa-ellipsis"></i></button>
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
                  <button class="boxtestMenuBtn btnAbumPlaylist"><i class="fa-regular fa-circle-play"></i></button>
                </div>
              </div>
              <div class="album-name"><?php echo $resultAlbumHot['album_name'] ?></div>
              <div class="album-user"><a href=""><?php echo $resultAlbumHot['authorAlbum'] ?></a></div>
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
                      <img src="./admin/upload//images/imagesong/<?php echo $resultImagePlaylist['songImage'] ?>" alt="">
                      <?php
                    }
                  }
                  ?>
                </div>
                <div class="boxtestMenu">
                  <button class="boxtestMenuBtn btnAbumPlaylist"><i class="fa-regular fa-circle-play"></i></button>
                </div>
              </div>
              <div class="playlist-name"><?php echo $resultPlaylistHot['playlist_name'] ?></div>
              <div class="playlist-user"><a href=""><?php echo $resultPlaylistHot['authorPlaylist'] ?></a></div>
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
                <div class="author-name"><a href=""><?php echo $resultSongNew['authorSong'] ?></a></div>
              </div>
              <button class="boxtestMenuBtn btn-heart"><i class="fa-regular fa-heart"></i></button>
              <button class="boxtestMenuBtn btn_menu"><i class="fa-solid fa-ellipsis"></i></button>
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
                <?php echo $resultSongHot['lyrics'] ?>
              </div>
            </div>
            <?php
          }
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
                  <button class="boxtestMenuBtn btnAbumPlaylist"><i class="fa-regular fa-circle-play"></i></button>
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
                      <img src="./admin/upload//images/imagesong/<?php echo $resultImagePlaylist['songImage'] ?>" alt="">
                      <?php
                    }
                  }
                  ?>
                </div>
                <div class="boxtestMenu">
                  <button class="boxtestMenuBtn btnAbumPlaylist"><i class="fa-regular fa-circle-play"></i></button>
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

  <!-- may like -->
  <?php
  if ($show_maylike) {
    ?>
    <div class="home-recommend">
      <div class="home-recommend-title">
        <h1>Có thể bạn thích</h1>
      </div>
      <div class="home-recommend-container">
        <!-- maylike song -->
        <div class="song-container">
          <?php
          while ($resultMayLike = $show_maylike->fetch_assoc()) {
            ?>
            <!-- song item -->
            <div class="recommend-song">
              <audio hidden>
                <source src="">
              </audio>
              <div class="recommend-cover">
                <img src="assets/images/recommend-1.jpg" alt="">
                <div class="cover-overlay">
                  <button class="btn-play"><i class="fa-solid fa-play"></i></button>
                </div>
              </div>
              <div class="recommend-name">
                <div class="song-name">PAIN</div>
                <div class="author-name"><a href="">Ryan Jones</a></div>
              </div>
              <button class="boxtestMenuBtn btn-heart"><i class="fa-regular fa-heart"></i></button>
              <button class="boxtestMenuBtn btn_menu"><i class="fa-solid fa-ellipsis"></i></button>
              <!-- submenu -->
              <div class="add-playlist">
                <p>Thêm vào playlist:</p>
                <ul>
                  <li>Playlist 1</li>
                  <li>Playlist 2</li>
                  <li>Playlist 3</li>
                </ul>
              </div>
            </div>
            <?php
          }
          ?>
        </div>
      </div>
    </div>
    <?php
  }
  ?>

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
            <a href="Other-profile.html" class="follower-container">
              <div class="follower-image">
                <img src="./admin/upload/images/imageuser/<?php echo $resultUser['userimage'] ?>" alt="">
              </div>
              <div class="follower-name-container">
                <div class="follower-name"><?php echo $resultUser['fullName'] ?></div>
                <div class="count-follower"><?php echo $format->number($resultUser['followers_count']) . 'theo dõi' ?></div>
              </div>
            </a>
            <?php
          }
        }
        ?>
      </div>
    </div>
  </div>

  <!-- sidebar -->
  <div class="sidebar">
    <div class="sidebar-container">
      <!-- item -->
    </div>
  </div>
</div>
<!-- custom right-click menu -->
<div id="custom-menu" class="custom-menu">
  <ul>
    <li onclick="menuAction('Action 1')"><i class="fa-solid fa-arrow-left-long"></i>&nbsp;&nbsp; Quay lại</li>
    <li onclick="menuAction('Action 2')"><i class="fa-solid fa-arrow-right"></i>&nbsp;&nbsp; Tiếp theo</li>
    <li onclick="menuAction('Action 3')"><i class="fa-solid fa-rotate-right"></i>&nbsp;&nbsp; Tải lại trang</li>
    <li onclick="menuAction('Action 4')"><i class="fa-regular fa-circle-dot"></i>&nbsp;&nbsp; Khám phá</li>
    <li onclick="menuAction('Action 5')"><i class="fa-regular fa-circle-user"></i>&nbsp;&nbsp; Nhạc cá nhân</li>
  </ul>
</div>

<!-- audio -->
<audio hidden id="myAudio">
  <source src="" type="audio/mp3">
</audio>
<!-- player control -->
<div class="player-control">
  <div class="player-control-ctn">
    <!-- control left -->
    <div class="player-control-left">
      <div class="item">
        <div class="media">
          <div class="media-left">
            <div class="song-img">
              <img src="asset/music/img/Trống Cơm.jpg" alt="">
            </div>
          </div>
          <!-- name song, artists -->
          <div class="media-content">
            <div class="song-name">Trống cơm</div>
            <div class="artists">Cường Seven, Soobin, Tự Long</div>
          </div>
          <!-- action add list -->
          <div class="media-right">
            <!-- favorite song -->
            <div class="btn heart">
              <i class="toggle-heart fa-regular fa-heart"></i>
            </div>
            <!-- playlist add -->
            <div class="btn playlist-add">
              <i class="fa-solid fa-plus"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- control bar -->
    <div class="player-control-bar">
      <!-- action song -->
      <div class="action-ctn">
        <div class="action">
          <div class="btn btn-repeat">
            <i class="fas fa-redo"></i>
          </div>
          <div class="btn btn-prev">
            <i class="fas fa-step-backward"></i>
          </div>
          <div class="btn btn-toggle-play">
            <i class="toggle-playPause fas fa-play"></i>
          </div>
          <div class="btn btn-next">
            <i class="fas fa-step-forward"></i>
          </div>
          <div class="btn btn-random">
            <i class="fas fa-random"></i>
          </div>
        </div>
      </div>
      <!-- time -->
      <div class="item-time">
        <div class="time left">00:00</div>
        <div class="duration-bar">
          <input id="progress" class="progress" type="range" value="0" step="1" min="0" max="100">
        </div>
        <div class="time right">00:00</div>
      </div>
    </div>
    <!-- control right -->
    <div class="player-control-right">
      <div class="container">
        <button class="btn-list"><i class="fa-solid fa-list"></i></button>
        <div class="btn btn-volume">
          <i class="fa-solid fa-volume-high"></i>
          <input id="volume" class="volume" type="range" value="100" step="1" min="0" max="100">
        </div>
        <div class="btn btn-zoom" id="fullscreenButton" onclick="enterFullscreen()">
          <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- fullcreen -->
<div class="fullscreen">
  <div class="song-title">
    <div class="image-song">
      <img src="asset/music/img/Trống Cơm.jpg" alt="">
    </div>
    <div class="title">
      <div class="name-song">Trống cơm</div>
      <div class="artists">Cường Seven, Soobin, Tự Long</div>
    </div>
  </div>
  <!-- lyrics -->
  <div class="lyrics"></div>
  <div class="player-control-bar">
    <!-- action song -->
    <div class="action-ctn">
      <div class="action">
        <div class="btn btn-repeat">
          <i class="fas fa-redo"></i>
        </div>
        <div class="btn btn-prev">
          <i class="fas fa-step-backward"></i>
        </div>
        <div class="btn btn-toggle-play">
          <i class="toggle-playPause fas fa-play"></i>
        </div>
        <div class="btn btn-next">
          <i class="fas fa-step-forward"></i>
        </div>
        <div class="btn btn-random">
          <i class="fas fa-random"></i>
        </div>
      </div>
    </div>
    <!-- time -->
    <div class="item-time">
      <div class="time left">00:00</div>
      <div class="duration-bar">
        <input id="progress" class="progress" type="range" value="0" step="1" min="0" max="100">
      </div>
      <div class="time right">00:00</div>
    </div>
  </div>
</div>
</div>
<script src="./js/main.js"></script>
<script src="./js/funcFullScreen.js"></script>
<script src="./js/index.js"></script>
<script src="./js/sidebar.js"></script>
</body>

</html>