<?php
include("../class/cateClass.php");
$category = new Category();

if (!isset($_GET["category_id"]) || $_GET["category_id"] == null) {
    return;
} else {
    $category_id = $_GET["category_id"];
}
$delete_category = $category->delete_category($category_id);
header("location: cateShow.php");
