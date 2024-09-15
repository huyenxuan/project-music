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

<!-- sidebar -->
<div class="sidebar">
    <div class="sidebar-container">
        <!-- item -->
        <div class="recommend-song sidebar-song" data-id="">
            <audio hidden>
                <source src="admin/upload/song/">
            </audio>
            <div class="recommend-cover">
                <img src="admin/upload/images/imagesong/" alt="">
                <div class="cover-overlay">
                    <button class="btn-play"><i class="fa-solid fa-play"></i></button>
                </div>
            </div>
            <div class="recommend-name">
                <div class="song-name"></div>
                <div class="author-name"><a href=""></a></div>
            </div>
            <button class="boxtestMenuBtn btn-heart"><i class="fa-solid fa-heart"></i></i></button>
        </div>
    </div>
</div>

<!-- audio -->
<audio hidden id="myAudio">
    <source src="" type="audio/mp3">
</audio>
<!-- player control -->
<div class="player-control" data-id="">
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
                <button class="btn-list list"><i class="fa-solid fa-list"></i></button>
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