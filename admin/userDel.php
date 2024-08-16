<?php
include("include/sidebar.php");
include("../class/userClass.php");
$user = new User();

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
} else {
    $user_id = $_SESSION['user_id'];
}

if (!isset($_GET["slug"]) || $_GET["slug"] == null) {
    return;
} else {
    $slug = $_GET["slug"];
    $get_user_by_slug = $user->get_user_by_slug($slug);
    if ($get_user_by_slug) {
        while ($result = $get_user_by_slug->fetch_assoc()) {
            $user_name = $result['fullName'];
        }
    }
}
$delete_user = $user->delete_user($slug);

$adminId = $user_id;
$action = "Xóa người dùng";
$details = "Xóa người dùng '$fullName'";
$playList->logAdminAction($adminId, $action, $details);

header("location: userShow.php");
exit();
