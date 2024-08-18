<?php
include('include/sidebar.php');
include("../class/bannerClass.php");
$banner = new Banner();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (!isset($_GET["banner_id"]) || $_GET["banner_id"] == null) {
    return;
} else {
    $banner_id = $_GET["banner_id"];
    $get_banner_by_id = $banner->get_banner_by_id($banner_id);
    if ($get_banner_by_id) {
        while ($result = $get_banner_by_id->fetch_assoc()) {
            $banner_name = $result['banner_name'];
        }
    }
}
$delete_banner = $banner->delete_banner($banner_id);

$adminId = $user_id;
$actions = "Xóa banner";
$details = "Xóa banner '$banner_name'";
$banner->logAdminAction($adminId, $actions, $details);

header("location: bannerShow.php");
exit();
