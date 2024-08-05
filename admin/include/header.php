<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HHMusic</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" type="image/png" href="../asset/img/icon.jpg" />
    <script src="./js/sidebar.js"></script>
    <link rel="stylesheet" href="./css/main.css">
</head>
<style>
    .main-ctn {
        min-height: 100vh;
    }
</style>

<body>
    <!-- header -->
    <header>
        <div class="header-ctn">
            <div class="logo">
                <a href="index.php" class="nav-link">
                    <img src="../asset/img/logo.png" alt="">
                </a>
            </div>
            <div class="account">
                <i class="fa-solid fa-user"></i>
                <?php
                if (isset($_SESSION['fullName'])) {
                    $fullName = $_SESSION['fullName'];
                    echo '<div class="name-admin">' . $fullName . '</div>';
                } else {
                ?>
                    <div class="name-admin">Admin</div>
                <?php
                }
                ?>
                <span> | </span>
                <div class="logout">
                    <a href="logout.php">Đăng xuất</a>
                </div>
            </div>
        </div>
    </header>