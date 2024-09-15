<?php
ob_start();
include("include/sidebar.php");
include("include/header.php");
include("../class/playListClass.php");
$playList = new PlayList();

$show_user = $playList->show_user();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
$erroPlaylist = '';
$erroAuthorPL = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $playlist_name = $_POST['playlist_name'];
    $authorPL = $_POST['authorPL'];

    if (empty($Playlist_name)) {
        $erroPlaylist = "Vui lòng nhập trường này";
    } else if (preg_match('/^[^a-zA-Z]/', $Playlist_name)) {
        $erroPlaylist = 'Tên phải bắt đầu bằng chữ';
    }
    if (empty($authorPL)) {
        $erroAuthorPL = "Vui lòng nhập trường này";
    }
    if (empty($erroPlaylist) && empty($erroAuthorPL)) {
        $insert_playList = $playList->insert_playList($playlist_name, $authorPL);

        $adminId = $user_id;
        $actions = "Thêm Playlist";
        $details = "Thêm Playlist '$playlist_name'";
        $playList->logAdminAction($adminId, $actions, $details);

        header('location: playlistAdd.php?playListName=' . urldecode($playlist_name));
        exit();
    }
}
?>
<title>Thêm PlayList</title>
<link rel="stylesheet" href="./css/album.css">

<style>
    .main-content {
        margin: 15px;
    }

    .user {
        width: 45%;
    }

    select {
        height: 40px;
        border-radius: 10px;
        width: 95%;
        font-size: 17px;
        margin: 10px 0 0 10px;
        padding-left: 7px;
    }

    form input {
        margin: 10px 0 0 15px !important;
    }

    form div {
        margin-bottom: 10px;
    }
</style>

<body>
    <div class="main-content">
        <h2 class="title" style="color:black">Thêm PlayList</h2>
        <form action="" method="POST">
            <div class="info">
                <div class="name">
                    <label for="">Nhập tên Playlist <span style="color: red">*</span></label>
                    <input type="text" placeholder="Nhập playlist nhạc" name="playlist_name"><br>
                    <?php if (!empty($erroPlaylist)) {
                        echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $erroPlaylist . "</span>";
                    } ?>
                </div>
                <div class="user">
                    <label for="">Tác giả <span style="color: red">*</span></label><br>
                    <select name="authorPL" id="">
                        <option value="">--- Chọn tác giả Playlist ---</option>
                        <?php
                        if ($show_user) {
                            while ($result = $show_user->fetch_assoc()) {
                                echo "<option value='" . $result['user_id'] . "'>" . $result['fullName'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                    <?php if (!empty($erroAuthorPL)) {
                        echo "<span style='color: red; font-size: 14px; margin-left: 20px'>" . $erroAuthorPL . "</span>";
                    } ?>
                </div>
            </div>
            <div class="privacy">
                <label for="" style="margin-right: 10px">Riêng tư: </label>
                <input name="privacy" type="checkbox"><br>
            </div>
            <button>Thêm</button>
        </form>
    </div>
    <?php
    include("include/footer.php");
    ?>