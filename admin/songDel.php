<?php
include('include/sidebar.php');
include("../class/songClass.php");

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
} else {
    $user_id = $_SESSION['user_id'];
}

$song = new Song();

if (!isset($_GET["song_id"]) || $_GET["song_id"] == null) {
    return;
} else {
    $song_id = $_GET["song_id"];
    $get_song_by_id = $song->get_song_by_id($song_id);
    if ($get_song_by_id) {
        while ($result = $get_song_by_id->fetch_assoc()) {
            $song_name = $result['song_name'];
        }
    }
}
$delete_song = $song->delete_song($song_id);

$adminId = $user_id;
$action = "Xóa bài hát";
$details = "Xóa bài hát '$song_name'";
$song->logAdminAction($adminId, $action, $details);

header("location: songShow.php");
exit();
