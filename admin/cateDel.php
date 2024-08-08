<?php
include("../class/cateClass.php");
$category = new Category();

if (!isset($_GET["slug"]) || $_GET["slug"] == null) {
    return;
} else {
    $slug = $_GET["slug"];
}
$delete_category = $category->delete_category($slug);
header("location: cateShow.php");
