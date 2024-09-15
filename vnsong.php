<?php
include('./inc/header.php');

$show_vnSong = $frontend->show_vnSong();
?>
<title>Nhạc Việt</title>
<link rel="stylesheet" href="./css/countrysong.css">
<link rel="stylesheet" href="./css/home.css">

<div class="title" style="text-align: center;">Nhạc Việt</div>

<div class="mainBox">

  <div class="search-bar-container">
    <input type="search" name="" id="searchInput" placeholder="Tìm kiếm bài hát Việt Nam..." onkeyup="filterList()">
  </div>

  <div class="search-item">
    <ul class="item-container" id="itemList">
      <!-- song item -->
      <?php
      if ($show_vnSong) {
        while ($resultVNSong = $show_vnSong->fetch_assoc()) {
          // Kiểm tra xem bài hát có trong yêu thích không
          $isFavorite = isset($_SESSION['user_id']) ? $frontend->check_song_in_favorite($_SESSION['user_id'], $resultVNSong['song_id']) : false;
          ?>
          <!-- song item -->
          <div class="recommend-song" data-id="<?php echo $resultVNSong['song_id'] ?>">
            <audio hidden>
              <source src="admin/upload/song/<?php echo $resultVNSong['file_path'] ?>" type="audio/mp3">
            </audio>
            <div class="recommend-cover">
              <img src="./admin/upload/images/imagesong/<?php echo $resultVNSong['song_image'] ?>" alt="">
              <div class="cover-overlay">
                <button class="btn-play"><i class="fa-solid fa-play"></i></button>
              </div>
            </div>
            <div class="recommend-name">
              <div class="song-name"><?php echo $format->textShorten($resultVNSong['song_name'], 25) ?></div>
              <div class="author-name"><a
                  href="otheruser.php?user_id=<?php echo $resultVNSong['user_id'] ?>"><?php echo $resultVNSong['authorSong'] ?></a>
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
              <?php echo $resultVNSong['lyrics'] ?>
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
  // thêm vào playlist
  $(document).on('click', '.add-to-playlist', function () {
    var playlist_id = $(this).data('id');
    var song_id = $(this).closest('.recommend-song').data('id');

    $.ajax({
      url: 'add_to_playlist.php',
      type: 'POST',
      data: {
        playlist_id: playlist_id,
        song_id: song_id
      },
      success: function (response) {
        if (response.trim() === 'exists') {
          alert('Bài hát đã tồn tại trong playlist!');
        } else if (response.trim() === 'success') {
          alert('Bài hát đã được thêm vào playlist thành công!');
        }
      },
      error: function (xhr, status, error) {
        alert('Đã có lỗi xảy ra: ' + error);
      }
    });
  });

  // thêm vào yêu thích
  $(document).on('click', '.btn-heart', function () {
    var song_id = $(this).closest('.recommend-song').data('id');
    var heartIcon = $(this).find('i');

    $.ajax({
      url: 'toggle_favorite.php',
      type: 'POST',
      data: {
        song_id: song_id
      },
      success: function (response) {
        if (response.trim() === 'added') {
          heartIcon.removeClass('fa-regular').addClass('fa-solid');
          alert('Bài hát đã được thêm vào danh sách yêu thích!');
        } else if (response.trim() === 'removed') {
          heartIcon.removeClass('fa-solid').addClass('fa-regular');
          alert('Bài hát đã được xóa khỏi danh sách yêu thích!');
        } else {
          alert('Có lỗi xảy ra: ' + response);
        }
      },
      error: function (xhr, status, error) {
        alert('Đã có lỗi xảy ra: ' + error);
      }
    });
  });

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
<script src="js/banner.js"></script>
<script src="js/handleplaysong.js"></script>
<script src="js/callsong.js"></script>
<script src="js/sidebar.js"></script>
<script src="js/rightmenu.js"></script>
<script src="js/funcFullScreen.js"></script>
<script src="js/countrysong.js"></script>
</body>

</html>