<?php
include('include/sidebar.php');
include("../class/songClass.php");

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
} else {
    $user_id = $_SESSION['user_id'];
}

$song = new Song();

if (!isset($_GET["slugSong"]) || $_GET["slugSong"] == null) {
    return;
} else {
    $slugSong = $_GET["slugSong"];
    $get_song_by_slug = $song->get_song_by_slug($slugSong);
    if ($get_song_by_slug) {
        while ($result = $get_song_by_slug->fetch_assoc()) {
            $song_name = $result['song_name'];
        }
    }
}
$delete_song = $song->delete_song($slugSong);

$adminId = $user_id;
$action = "Xóa bài hát";
$details = "Xóa bài hát '$song_name'";
$song->logAdminAction($adminId, $action, $details);

header("location: songShow.php");
exit();
