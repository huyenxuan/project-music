<div class="main-ctn">
    <header style="height: 70px;">
        <div class="header-ctn" style="height: 100%;">
            <div class="account">
                <i class="fa-solid fa-user"></i>
                <?php if (isset($_SESSION['fullName'])) {
                    $fullName = $_SESSION['fullName'];
                } ?>
                <div style="color:white; padding:0 5px"><?php echo $fullName ?></div>
                <span> | </span>
                <div class="logout">
                    <a href="logout.php" style="color:white">Đăng xuất</a>
                </div>
            </div>
        </div>
    </header>