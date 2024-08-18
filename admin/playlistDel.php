<?php
include("include/sidebar.php");
include("../class/playlistClass.php");
$playList = new PlayList();

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
} else {
    $user_id = $_SESSION['user_id'];
}

if (!isset($_GET["playlist_id"]) || $_GET["playlist_id"] == null) {
    return;
} else {
    $playlist_id = $_GET["playlist_id"];
    $get_playlist_by_id = $playList->get_playlist_by_id($playlist_id);
    if ($get_playlist_by_id) {
        while ($result = $get_playlist_by_id->fetch_assoc()) {
            $playlist_name = $result['playlist_name'];
        }
    }
}

$delete_playlist = $playList->delete_playlist($playlist_id);

$adminId = $user_id;
$action = "Xóa thể loại";
$details = "Xóa thể loại '$playlist_name'";
$playList->logAdminAction($adminId, $action, $details);
header("location: playlistShow.php");
exit();
