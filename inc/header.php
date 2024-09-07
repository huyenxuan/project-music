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
</head>
<style>
    .user {
        align-content: center;
        min-width: 115px;
        position: relative;
    }

    .user ul {
        width: 140px;
        position: absolute;
        right: 0;
        top: 60px;
        display: none;
        border-radius: 5px;
        overflow: hidden;
    }

    .user ul li {
        list-style: none;
        padding: 10px 7px;
        background-color: rgb(57, 74, 96, 0.9);
    }

    .user li a {
        text-decoration: none;
        color: white;
    }

    .user:hover ul {
        display: block;
    }

    .user div {
        border-radius: 10px;
        width: 100%;
        height: 100%;
        align-content: center;
        text-align: -webkit-center;
    }

    .user div img {
        height: 80%;
        display: flex;
        border-radius: 50%;
    }
</style>

<body>
    <div class="mainBody">

        <div class="header">
            <div class="logo"><a href="Home.html">
                    <img src="./asset/img/logo.png" alt=""></a>
            </div>

            <label for="nav_mobile_input" class="nav_bar_btn">
                <i class="fa-solid fa-bars"></i>
            </label>
            <div class="menu">
                <!-- menu -->
                <div class="headerMenu">
                    <div class="menuTab"><a href="Home.html">Trang chủ</a></div>
                    <div class="menuTab"><a href="VNsong.html">Nhạc Việt</a></div>
                    <div class="menuTab"><a href="USUKsong.html">Nhạc Âu - Mĩ</a></div>
                    <div class="menuTab"><a href="Discovery.html">Khám phá</a></div>
                    <div class="menuTab"><a href="Library.html">Thư viện</a></div>
                </div>
                <!-- timer -->
                <div class="timer">
                    <i class="fa-regular fa-clock"></i><br>
                    <div class="minute">
                        <label for="time">Hẹn giờ: </label>
                        <input type="text" name="" id="time" placeholder="...phút">
                    </div>
                </div>
                <!-- search box -->
                <div class="searchBox">
                    <form action="search.html" method="GET">
                        <button><i class="fa-solid fa-magnifying-glass"></i></button>
                        <input id="searchInput" type="search" placeholder="Tìm kiếm bài hát...">
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
                        <a href="" class="nav_mobile_link">Nhạc Việt</a>
                    </li>
                    <li>
                        <a href="" class="nav_mobile_link">Nhạc Âu - Mĩ</a>
                    </li>
                    <li>
                        <a href="Discover.html" class="nav_mobile_link">Khám phá</a>
                    </li>
                    <li>
                        <a href="Library.html" class="nav_mobile_link">Thư viện</a>
                    </li>
                </ul>
            </div>
            <!-- user -->
            <div class="user">
                <?php
                if (isset($_SESSION['user_id'])) {
                    $fullName = $_SESSION['fullName'];
                    $userimage = $_SESSION['userimage'];
                    ?>
                    <div><img <?php if (isset($userimage)) {
                        echo 'src="./admin/upload/images/imageuser/' . $userimage . '"';
                    } else {
                        echo 'src="./asset/img/user-default.png"';
                    } ?> alt="<?php echo $fullName ?>"
                            title="<?php echo $fullName ?>">
                    </div>
                    <!-- submenu -->
                    <ul>
                        <li><a href="user.php">Thông tin cá nhân</a></li>
                        <li><a href="logout.php" style="color: red; font-weight: bold">Đăng xuất</a></li>
                    </ul>
                    <?php
                } else {
                    ?>
                    <div class="login">
                        <a href="Login.php">Đăng nhập</a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

        <div class="title"></div>