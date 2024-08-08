<?php
include("../class/albumClass.php");
$album = new Album();

if (!isset($_GET["slug_album"]) || $_GET["slug_album"] == null) {
    return;
} else {
    $slug_album = $_GET["slug_album"];
}
$delete_album = $album->delete_album($slug_album);
header("location: albumShow.php");
