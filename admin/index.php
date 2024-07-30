<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" type="image/png" href="asset/img/icon.jpg" />
    <link rel="stylesheet" href="./css/main.css">
    <title>HHMusic</title>
</head>

<body>
    <!-- header -->
    <header>
        <div class="hd-ctn">
            <!-- logo -->
            <div class="logo">
                <a href="index.html" class="nav-link" data-url="index.html">
                    <img src="/asset/img/logo.png" alt="">
                </a>
            </div>

            <!-- menu -->
            <nav class="menu">
                <ul>
                    <li>
                        <a href="test.html" class="nav-link" data-url="test.html">Chủ đề</a>
                    </li>
                    <li>
                        <a href="album.html" class="nav-link" data-url="album.html">Album</a>
                    </li>
                    <li>
                        <a href="nhac-viet.html" class="nav-link" data-url="nhac-viet.html">Nhạc Việt</a>
                    </li>
                    <li>
                        <a href="nhac-quoc-te.html" class="nav-link" data-url="nhac-quoc-te.html">Nhạc quốc tế</a>
                    </li>
                    <li>
                        <a href="playlist.html" class="nav-link" data-url="playlist.html">Playlist</a>
                    </li>
                </ul>
            </nav>

            <!-- search -->
            <div class="search">
                <input required type="text" placeholder="Tìm kiếm ...">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>

            <!-- timer -->
            <div class="timer">
                <i class="fa-regular fa-clock"></i>
                <div>Hẹn giờ</div>
            </div>

            <!-- account -->
            <div class="account">
                <i class="fa-solid fa-user"></i>
                <a href="register.html" class="nav-link" data-url="register.html">Đăng ký</a>
                <span> / </span>
                <a href="login.html" class="nav-link" data-url="login.html">Đăng nhập</a>
            </div>
        </div>
    </header>

    <!-- main -->
    <main>
        <div class="main-ctn" id="content">

            <!-- audio -->
            <audio hidden id="myAudio" controls>
                <source src="asset/music/songs/trong-com.mp3" type="audio/mp3">
                Your browser does not support the audio element.
            </audio>

            <!-- player control -->
            <div class="player-control">
                <div class="player-control-ctn">
                    <div class="player-control-left">
                        <div class="item">
                            <div class="media">
                                <div class="media-left">
                                    <div class="song-img">
                                        <img src="asset/music/img/Trống Cơm.jpg" alt="">
                                    </div>
                                </div>
                                <div class="media-content">
                                    <div class="song-name">Trống cơm</div>
                                    <div class="artists">Cường Seven, Soobin, Tự Long</div>
                                </div>
                                <div class="media-right">
                                    <div class="heart">
                                        <i class="toggle-heart fa-regular fa-heart"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="player-control-bar">
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
                        <div class="item">
                            <div class="time left">00:00</div>
                            <div class="duration-bar">
                                <input id="progress" class="progress" type="range" value="0" step="0.1" min="0" max="100">
                            </div>
                            <div class="time right">00:00</div>
                        </div>
                    </div>
                    <div class="player-control-right">
                        <div class="container">
                            <div class="btn btn-list">
                                <i class="fa-solid fa-list"></i>
                            </div>
                            <div class="btn btn-volume">
                                <i class="fa-solid fa-volume-high"></i>
                            </div>
                            <div class="btn btn-zoom" onclick="enterFullscreen()">
                                <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- fullcreen -->
            <div class="fullscreen"></div>

        </div>
    </main>

    <!-- footer -->
    <footer>
        <div class="ft-ctn">
            Bản quyền thuộc về HHMusic

        </div>
    </footer>

    <!-- javascript -->
    <script src="./js/main.js"></script>
</body>

</html>