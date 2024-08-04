<?php
include("../class/userClass.php");
$user = new user();

if (!isset($_GET["user_id"]) || $_GET["user_id"] == null) {
    return;
} else {
    $user_id = $_GET["user_id"];
}
$delete_user = $user->delete_user($user_id);
