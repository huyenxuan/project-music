<?php
include("../class/userClass.php");
$user = new User();

if (!isset($_GET["slug"]) || $_GET["slug"] == null) {
    return;
} else {
    $slug = $_GET["slug"];
}
$delete_user = $user->delete_user($slug);
header("location: userShow.php");
