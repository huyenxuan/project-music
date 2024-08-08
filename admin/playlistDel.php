<?php
include("../class/playlistClass.php");
$playList = new PlayList();

if (!isset($_GET["slug_PlayList"]) || $_GET["slug_PlayList"] == null) {
    return;
} else {
    $slug_PlayList = $_GET["slug_PlayList"];
}
$delete_playList = $playList->delete_playList($slugPlayList);
header("location: playListShow.php");
