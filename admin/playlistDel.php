<?php
include("include/sidebar.php");
include("../class/playlistClass.php");
$playList = new PlayList();

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
} else {
    $user_id = $_SESSION['user_id'];
}

if (!isset($_GET["slugPlaylist"]) || $_GET["slugPlaylist"] == null) {
    return;
} else {
    $slug = $_GET["slugPlaylist"];
    $get_playlist_by_slug = $playList->get_playlist_by_slug($slug);
    if ($get_playlist_by_slug) {
        while ($result = $get_playlist_by_slug->fetch_assoc()) {
            $playlist_name = $result['playlist_name'];
        }
    }
}

$delete_playlist = $playList->delete_playlist($slug);

$adminId = $user_id;
$action = "Xóa thể loại";
$details = "Xóa thể loại '$playlist_name'";
$playList->logAdminAction($adminId, $action, $details);
header("location: playlistShow.php");
exit();
