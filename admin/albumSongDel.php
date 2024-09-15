<?php
include("include/sidebar.php");
include("../class/albumClass.php");
$album = new album();

if (!isset($_GET["albumSongId"]) || $_GET["albumSongId"] == null) {
    return;
} else {
    $albumSongId = $_GET["albumSongId"];
}
$delete_albumSongId = $album->delete_albumSongId($album_id, $albumSongId);
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
