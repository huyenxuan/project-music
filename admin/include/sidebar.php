<?php
ob_start();
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('location: login');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin HHMusic</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" type="image/png" href="../asset/img/logo.png" />
    <link rel="stylesheet" href="./css/main.css">
    <style>
        .main-content {
            margin: 20px !important;
        }

        .search {
            top: 90px !important;
            right: 20px !important;
        }

        table {
            width: 100% !important;
        }

        .side-bar {
            height: auto !important;
        }
    </style>
</head>

<body>
    <main>
        <div class="side-bar" style="background: #393c3f">
            <div class="header" style="background: #6386b5">
                <div id="image_admin">
                    <?php if (isset($_SESSION['userimage'])) {
                        $userimage = $_SESSION['userimage'];
                    } ?>
                    <img src="./upload/images/imageuser/<?php echo $userimage ?>" alt="">
                </div>
                <?php if (isset($_SESSION['fullName'])) {
                    $fullName = $_SESSION['fullName'];
                } ?>
                <h1 style="font-size:16px; color:white; text-align:center; padding-bottom: 10px;">
                    <?php echo $fullName ?>
                </h1>
            </div>
            <div class="menu">
                <div class="item">
                    <a class="sub-btn">Quản lý Banner<i class="fas fa-angle-right dropdown"></i></a>
                    <div class="sub-menu">
                        <a href="bannerAdd" class="sub-item">Thêm Banner</a>
                        <a href="bannerShow" class="sub-item">Danh sách Banner</a>
                    </div>
                </div>
                <div class="item">
                    <a class="sub-btn">Quản lý Thể loại<i class="fas fa-angle-right dropdown"></i></a>
                    <div class="sub-menu">
                        <a href="cateAdd" class="sub-item">Thêm Thể loại</a>
                        <a href="cateShow" class="sub-item">Danh sách Thể loại</a>
                    </div>
                </div>
                <div class="item">
                    <a class="sub-btn">Quản lý Bài hát<i class="fas fa-angle-right dropdown"></i></a>
                    <div class="sub-menu">
                        <a href="songAdd" class="sub-item">Thêm Bài hát</a>
                        <a href="songShow" class="sub-item">Danh sách Bài hát</a>
                    </div>
                </div>
                <div class="item">
                    <a class="sub-btn">Quản lý Playlist<i class="fas fa-angle-right dropdown"></i></a>
                    <div class="sub-menu">
                        <a href="playlistAdd" class="sub-item">Thêm Playlist</a>
                        <a href="playlistShow" class="sub-item">Danh sách Playlist</a>
                    </div>
                </div>
                <div class="item">
                    <a class="sub-btn">Quản lý Album<i class="fas fa-angle-right dropdown"></i></a>
                    <div class="sub-menu">
                        <a href="albumAdd" class="sub-item">Thêm Album</a>
                        <a href="albumShow" class="sub-item">Danh sách Album</a>
                    </div>
                </div>
                <div class="item">
                    <a class="sub-btn">Quản lý Người dùng<i class="fas fa-angle-right dropdown"></i></a>
                    <div class="sub-menu">
                        <a href="userAdd" class="sub-item">Thêm người dùng</a>
                        <a href="userShow" class="sub-item">Danh sách người dùng</a>
                    </div>
                </div>
                <div class="item">
                    <a href="activities">Activities</a>
                </div>
            </div>
        </div>