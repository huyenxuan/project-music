<?php
include('include/sidebar.php');
include("../class/albumClass.php");
$album = new Album();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (!isset($_GET["album_slug"]) || $_GET["album_slug"] == null) {
    return;
} else {
    $album_slug = $_GET["album_slug"];
    $get_album_by_slug = $album->get_album_by_slug($album_slug);
    if ($get_album_by_slug) {
        while ($result = $get_album_by_slug->fetch_assoc()) {
            $album_name = $result['album_name'];
        }
    }
}
$delete_album = $album->delete_album($album_slug);

$adminId = $user_id;
$actions = "Xóa album";
$details = "Xóa album '$album_name'";
$album->logAdminAction($adminId, $actions, $details);

header("location: albumShow.php");
exit();
