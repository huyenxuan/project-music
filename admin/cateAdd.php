<?php
ob_start();
include("include/sidebar.php");
include("include/header.php");
include("../class/cateClass.php");

$category = new Category();

if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = $_POST['category_name'];
    $adminId = $user_id;
    $action = "Thêm thể loại";
    $details = "Thêm thể loại '$category_name'";

    $insert_category = $category->insert_category($category_name);
    $category->logAdminAction($adminId, $action, $details);

    header('location: cateAdd.php?categoryName=' . urldecode($category_name));
    exit();
}
?>
<title>Thêm thể loại</title>
<link rel="stylesheet" href="./css/category.css">

<style>
    .main-content {
        margin: 15px;
    }

    label {
        font-weight: 600;
    }
</style>

<body>
    <div class="main-content">
        <h2 class="title" style="color:black; margin-bottom: 10px">Thêm thể loại</h2>
        <form action="" method="POST">
            <label for="">Tên thể loại <span style="color: red">*</span></label><br>
            <input type="text" placeholder="Nhập thể loại nhạc" name="category_name"><br>
            <button>Thêm</button>
        </form>
    </div>
    <?php
    include("include/footer.php");
    ?>