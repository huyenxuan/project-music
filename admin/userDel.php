<?php
include("include/sidebar.php");
include("../class/userClass.php");
$user = new User();

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
} else {
    $user_id = $_SESSION['user_id'];
}

if (!isset($_GET["user_id"]) || $_GET["user_id"] == null) {
    return;
} else {
    $user_id = $_GET["user_id"];
    $get_user_by_id = $user->get_user_by_id($user_id);
    if ($get_user_by_id) {
        while ($result = $get_user_by_id->fetch_assoc()) {
            $user_name = $result['fullName'];
        }
    }
}
$delete_user = $user->delete_user($user_id);

$adminId = $user_id;
$action = "Xóa người dùng";
$details = "Xóa người dùng '$fullName'";
$playList->logAdminAction($adminId, $action, $details);

header("location: userShow.php");
exit();
