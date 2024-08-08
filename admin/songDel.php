<?php
include("../class/songClass.php");
$song = new Song();

if (!isset($_GET["slugSong"]) || $_GET["slugSong"] == null) {
    return;
} else {
    $slugSong = $_GET["slugSong"];
}
$delete_song = $song->delete_song($slugSong);
header("location: songShow.php");
