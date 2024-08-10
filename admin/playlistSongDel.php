<?php
include("../class/playlistClass.php");
$playList = new PlayList();

if (!isset($_GET["playlistSongId"]) || $_GET["playlistSongId"] == null) {
    return;
} else {
    $playlistSongId = $_GET["playlistSongId"];
}
$delete_playlistSongId = $playList->delete_playlistSongId($playlistSongId);
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
