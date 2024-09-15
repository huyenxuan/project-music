<?php
include('./inc/header.php');

$show_usukSong = $frontend->show_usukSong();
?>
<title>Nhạc Âu Mỹ</title>
<link rel="stylesheet" href="./css/countrysong.css">

<div class="title" style="text-align: center;">Nhạc Âu Mỹ</div>

<div class="mainBox">

  <div class="search-bar-container">
    <input type="search" name="" id="searchInput" placeholder="Tìm kiếm bài hát Âu Mỹ..." onkeyup="filterList()">
  </div>

  <div class="search-item">

    <ul class="item-container" id="itemList">
      <!-- song item -->
      <?php
      if ($show_usukSong) {
        while ($resultUSUKSong = $show_usukSong->fetch_assoc()) {
          // Kiểm tra xem bài hát có trong yêu thích không
          $isFavorite = isset($_SESSION['user_id']) ? $frontend->check_song_in_favorite($_SESSION['user_id'], $resultUSUKSong['song_id']) : false;
          ?>
          <!-- song item -->
          <div class="recommend-song" data-id="<?php echo $resultUSUKSong['song_id'] ?>">
            <audio hidden>
              <source src="admin/upload/song/<?php echo $resultUSUKSong['file_path'] ?>" type="audio/mp3">
            </audio>
            <div class="recommend-cover">
              <img src="./admin/upload/images/imagesong/<?php echo $resultUSUKSong['song_image'] ?>" alt="">
              <div class="cover-overlay">
                <button class="btn-play"><i class="fa-solid fa-play"></i></button>
              </div>
            </div>
            <div class="recommend-name">
              <div class="song-name"><?php echo $format->textShorten($resultUSUKSong['song_name'], 25) ?></div>
              <div class="author-name"><a
                  href="otheruser.php?user_id=<?php echo $resultUSUKSong['user_id'] ?>"><?php echo $resultUSUKSong['authorSong'] ?></a>
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
              <?php echo $resultUSUKSong['lyrics'] ?>
            </div>
          </div>
          <?php
        }
      } else {
        echo '<div>Không có dữ liệu</div>';
      }
      ?>
    </ul>
  </div>
</div>

<?php
include('./inc/footer.php');
?>
<script>
  // btn add playlist
  document.querySelectorAll('.btn_menu').forEach(button => {
    button.addEventListener('click', function (event) {
      event.stopPropagation();
      document.querySelectorAll('.add-playlist').forEach(box => {
        if (box !== this.nextElementSibling) {
          box.style.display = 'none';
        }
      });

      const addPlaylist = this.nextElementSibling;
      if (addPlaylist.style.display === 'block') {
        addPlaylist.style.display = 'none';
      } else {
        addPlaylist.style.display = 'block';
      }
    });
  });

  // Đóng hộp khi nhấp ra ngoài nó
  document.addEventListener('click', function (event) {
    if (!event.target.closest('.btn_menu') && !event.target.closest('.add-playlist')) {
      document.querySelectorAll('.add-playlist').forEach(box => {
        box.style.display = 'none';
      });
    }
  });
</script>
<script src="js/songfavorite.js"></script>
<script src="js/banner.js"></script>
<script src="js/handleplaysong.js"></script>
<script src="js/callsong.js"></script>
<script src="js/sidebar.js"></script>
<script src="js/rightmenu.js"></script>
<script src="js/funcFullScreen.js"></script>
<script src="js/countrysong.js"></script>
</body>

</html>