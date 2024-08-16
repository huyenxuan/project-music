<?php
ob_start();
include("include/sidebar.php");
include("include/header.php");
include("../class/playListClass.php");
$playList = new PlayList();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $playlist_name = $_POST['playlist_name'];
    $userPL_id = $user_id;
    $insert_playList = $playList->insert_playList($playlist_name, $userPL_id);

    $adminId = $user_id;
    $actions = "Thêm Playlist";
    $details = "Thêm Playlist '$playlist_name'";
    $playList->logAdminAction($adminId, $actions, $details);

    header('location: playlistAdd.php?playListName=' . urldecode($playlist_name));
    exit();
}
?>
<title>Thêm PlayList</title>
<link rel="stylesheet" href="./css/category.css">

<style>
    .main-content {
        margin: 15px;
    }
</style>

<body>
    <div class="main-content">
        <h2 class="title" style="color:black">Thêm PlayList</h2>
        <form action="" method="POST">
            <input type="text" placeholder="Nhập playlist nhạc" name="playlist_name"><br>
            <button>Thêm</button>
        </form>
    </div>
    <?php
    include("include/footer.php");
    ?>