<?php
include("include/sidebar.php");
include("../class/cateClass.php");
$category = new Category();

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
} else {
    $user_id = $_SESSION['user_id'];
}

if (!isset($_GET["category_id"]) || $_GET["category_id"] == null) {
    return;
} else {
    $category_id = $_GET["category_id"];
    $get_category_by_id = $category->get_category_by_id($category_id);
    if ($get_category_by__id) {
        while ($result = $get_category_by__id->fetch_assoc()) {
            $category_name = $result['category_name'];
        }
    }
}

$delete_category = $category->delete_category($category_id);

$adminId = $user_id;
$action = "Xóa thể loại";
$details = "Xóa thể loại '$category_name'";
$category->logAdminAction($adminId, $action, $details);

header("location: cateShow.php");
exit();
