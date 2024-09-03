<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="shortcut icon" href="./asset/img/logo.png">
</head>

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
                        <a href="" class="nav_mobile_link">Trang chủ</a>
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
                <div class="login"><a href="Login.html">Đăng nhập</a></div>
            </div>
        </div>

        <div class="title"></div>