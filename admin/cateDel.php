<?php
include("include/sidebar.php");
include("../class/cateClass.php");
$category = new Category();

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
} else {
    $user_id = $_SESSION['user_id'];
}

if (!isset($_GET["slug"]) || $_GET["slug"] == null) {
    return;
} else {
    $slug = $_GET["slug"];
    $get_category_by_slug = $category->get_category_by_slug($slug);
    if ($get_category_by_slug) {
        while ($result = $get_category_by_slug->fetch_assoc()) {
            $category_name = $result['category_name'];
        }
    }
}

$delete_category = $category->delete_category($slug);

$adminId = $user_id;
$action = "Xóa thể loại";
$details = "Xóa thể loại '$category_name'";
$category->logAdminAction($adminId, $action, $details);

header("location: cateShow.php");
exit();
