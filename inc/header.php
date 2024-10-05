<?php
session_start();
include("./class/frontendClass.php");
include("./config/format.php");

$frontend = new FrontEnd();
$format = new Format();
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="shortcut icon" href="./asset/img/logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
    .login {
        background-color: rgb(57, 74, 96, 0.9);
        padding: 5px;
        display: flex;
        justify-content: space-around;
        height: 40px !important;
    }

    .login a {
        margin: 0 !important;
        padding: 0 !important;
    }

    span {
        color: white;
    }
</style>

<body>
    <div class="mainBody">

        <div class="header">
            <div class="logo"><a href="index.php">
                    <img src="./asset/img/logo.png" alt=""></a>
            </div>

            <label for="nav_mobile_input" class="nav_bar_btn">
                <i class="fa-solid fa-bars"></i>
            </label>
            <div class="menu">
                <!-- menu -->
                <div class="headerMenu">
                    <div class="menuTab"><a href="index">Trang chủ</a></div>
                    <div class="menuTab"><a href="vnsong">Nhạc Việt</a></div>
                    <div class="menuTab"><a href="usuksong">Nhạc Âu - Mĩ</a></div>
                    <div class="menuTab"><a href="discovery">Khám phá</a></div>
                    <div class="menuTab"><a href="library">Thư viện</a></div>
                </div>
                <!-- timer -->
                <div class="timer">
                    <i class="fa-regular fa-clock"></i><br>
                    <div class="minute">
                        <input type="number" id="time" placeholder="...phút">
                        <button id="start-timer">Bắt đầu</button>
                    </div>
                </div>
                <!-- search box -->
                <div class="searchBox">
                    <form action="search.php" method="GET">
                        <button><i class="fa-solid fa-magnifying-glass"></i></button>
                        <input id="searchInput" type="search" placeholder="Tìm kiếm bài hát..." name="keysearch"
                            value="<?php echo (isset($_GET['keysearch'])) ? $_GET['keysearch'] : '' ?>">
                    </form>
                </div>
            </div>
            <input type="checkbox" name="" class="nav_input" id="nav_mobile_input">
            <label for="nav_mobile_input" class="nav_overlay"></label>
            <div class="nav_mobile">
                <label for="nav_mobile_input" class="nav_mobile_close">
                    <i class="fa-solid fa-xmark"></i>
                </label>
                <ul class="nav_mobile_list">
                    <li>
                        <a href="index.php" class="nav_mobile_link">Trang chủ</a>
                    </li>
                    <li>
                        <a href="vnsong.php" class="nav_mobile_link">Nhạc Việt</a>
                    </li>
                    <li>
                        <a href="usuksong.php" class="nav_mobile_link">Nhạc Âu - Mĩ</a>
                    </li>
                    <li>
                        <a href="discover.php" class="nav_mobile_link">Khám phá</a>
                    </li>
                    <li>
                        <a href="library.php" class="nav_mobile_link">Thư viện</a>
                    </li>
                </ul>
            </div>
            <!-- user -->
            <div class="user">
                <?php
                if (isset($_SESSION['user_id'])) {
                    $userimage = $_SESSION['userimage'];
                    ?>
                    <div><img <?php if (isset($userimage)) {
                        echo 'src="./admin/upload/images/imageuser/' . $userimage . '"';
                    } else {
                        echo 'src="./asset/img/user-default.png"';
                    } ?> alt="">
                    </div>
                    <!-- submenu -->
                    <ul>
                        <li><a href="user.php?user_id=<?php echo $_SESSION['user_id'] ?>">Thông tin cá nhân</a></li>
                        <li><a href="logout.php" style="color: red; font-weight: bold">Đăng xuất</a></li>
                    </ul>
                    <?php
                } else {
                    ?>
                    <div class="login">
                        <a href="login.php">ĐNhập</a>
                        <span>/</span>
                        <a href="register.php">ĐKý</a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

        <div class="title"></div>