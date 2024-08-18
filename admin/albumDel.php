<?php
include('include/sidebar.php');
include("../class/albumClass.php");
$album = new Album();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (!isset($_GET["album_id"]) || $_GET["album_id"] == null) {
    return;
} else {
    $album_id = $_GET["album_id"];
    $get_album_by_id = $album->get_album_by_id($album_id);
    if ($get_album_by_id) {
        while ($result = $get_album_by_id->fetch_assoc()) {
            $album_name = $result['album_name'];
        }
    }
}
$delete_album = $album->delete_album($album_id);

$adminId = $user_id;
$actions = "Xóa album";
$details = "Xóa album '$album_name'";
$album->logAdminAction($adminId, $actions, $details);

header("location: albumShow.php");
exit();
