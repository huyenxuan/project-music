<?php
include("../class/playlistClass.php");
$playList = new PlayList();

if (!isset($_GET["slugPlaylist"]) || $_GET["slugPlaylist"] == null) {
    return;
} else {
    $slug = $_GET["slugPlaylist"];
}
$delete_playlist = $playList->delete_playlist($slug);
header("location: playlistShow.php");
